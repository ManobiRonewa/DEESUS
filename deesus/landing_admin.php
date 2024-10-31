<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Clothing Store - Income Report</title>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: white;
            color: #333;
        }

        /* Container and Header Styling */
        .container {
            width: 100%;
            margin: 0px auto;
            padding: 0px;
            background-color: white;
            border-radius: 8px;
        }

        header {
            background-color: #4CAF50;
            color: #fff;
            padding: 15px 0;
            text-align: center;
            border-radius: 8px 8px 0 0;
            font-size: 24px;
        }

        h2 {
            color: #333;
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        /* Form Styling */
        .filter {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            align-items: center;
            margin-bottom: 30px;
        }

        .filter label, .filter select, .filter input[type="text"], .filter input[type="submit"] {
            font-size: 16px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .filter input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        /* Table Styling */
        .scrollable {
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
            margin-top: 10px;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
            position: sticky;
            top: 0;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Responsive Styling */
        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 15px;
            }

            .filter label, .filter select, .filter input[type="text"], .filter input[type="submit"] {
                font-size: 14px;
                padding: 8px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Income Report</h2>

        <form method="GET" class="filter">
            <label for="startDate">Start Date:</label>
            <input type="text" name="startDate" id="startDate" class="datepicker" value="<?= htmlspecialchars($_GET['startDate'] ?? '') ?>">
            <label for="endDate">End Date:</label>
            <input type="text" name="endDate" id="endDate" class="datepicker" value="<?= htmlspecialchars($_GET['endDate'] ?? '') ?>">
            <input type="submit" value="Filter">
        </form>

        <?php
        include "conn.php"; // Database connection

        // Initialize dates
        $startDate = $_GET['startDate'] ?? date('Y-m-d', strtotime('-1 month')); // Default to last month
        $endDate = $_GET['endDate'] ?? date('Y-m-d'); // Default to today

        // Base query for total income
        $query = "SELECT SUM(total) AS income FROM orders";
        $conditions = [];

        // Check if a custom date range is provided
        if (!empty($startDate) && !empty($endDate)) {
            $conditions[] = "order_date BETWEEN ? AND ?";
        }

        // Build the final query
        if (count($conditions) > 0) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        // Prepare and execute the statement for total income
        $stmt = $conn->prepare($query);
        if (count($conditions) > 0 && end($conditions) === "order_date BETWEEN ? AND ?") {
            $stmt->bind_param('ss', $startDate, $endDate);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $income = $result->fetch_assoc()['income'] ?? 0;

        // Display total income
        echo "<h3>Total Income: R" . number_format($income, 2) . "</h3>";
        ?>

        <h4>Order list made</h4>
        <div class="scrollable">
            <table>
                <tr>
                    <th>No</th>
                    <th>Product Name</th>
                    <th>Product Image</th>
                    <th>Product Size</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Order Date</th>
                </tr>

                <?php
                // Retrieve order details based on the selected timeframe and date range
                $query = "SELECT * FROM orders";
                $conditions = [];

                // Check if a custom date range is provided
                if (!empty($startDate) && !empty($endDate)) {
                    $conditions[] = "order_date BETWEEN ? AND ?";
                }

                // Build the final query for order details
                if (count($conditions) > 0) {
                    $query .= " WHERE " . implode(" AND ", $conditions);
                }

                // Prepare and execute the statement for order details
                $stmt = $conn->prepare($query);
                if (count($conditions) > 0 && end($conditions) === "order_date BETWEEN ? AND ?") {
                    $stmt->bind_param('ss', $startDate, $endDate);
                }
                $stmt->execute();
                $result = $stmt->get_result();
$count=1;
                // Check if any orders exist
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" .$count++. "</td>";
                        echo "<td>" . $row['product_name'] . "</td>";
                        echo "<td><img src='" . $row['product_image'] . "' width='50' height='50'></td>";
                        echo "<td>" . $row['product_size'] . "</td>";
                        echo "<td>R" . number_format($row['price'], 2) . "</td>";
                        echo "<td>" . $row['quantity'] . "</td>";
                        echo "<td>R" . number_format($row['total'], 2) . "</td>";
                        echo "<td>" . $row['order_date'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No orders found for the selected date range.</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(function() {
            $("#startDate, #endDate").datepicker({
                dateFormat: "yy-mm-dd"
            });
        });
    </script>
</body>
</html>
