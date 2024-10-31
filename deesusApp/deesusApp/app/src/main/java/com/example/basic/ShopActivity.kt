package com.example.basic

import android.app.Dialog
import android.content.Context
import android.content.Intent
import android.graphics.Color
import android.graphics.Typeface
import android.graphics.drawable.ColorDrawable
import android.os.Bundle
import android.text.Editable
import android.text.InputType
import android.text.TextUtils
import android.text.TextWatcher
import android.util.Log
import android.util.TypedValue
import android.view.Gravity
import android.view.View
import android.view.ViewGroup
import android.view.Window
import android.widget.ArrayAdapter
import android.widget.Button
import android.widget.EditText
import android.widget.HorizontalScrollView
import android.widget.ImageView
import android.widget.LinearLayout
import android.widget.ScrollView
import android.widget.Spinner
import android.widget.TableLayout
import android.widget.TableRow
import android.widget.TextView
import android.widget.Toast
import androidx.appcompat.app.AlertDialog
import androidx.appcompat.app.AppCompatActivity
import androidx.cardview.widget.CardView
import androidx.lifecycle.lifecycleScope
import androidx.recyclerview.widget.GridLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.google.gson.Gson
import com.google.gson.annotations.SerializedName
import kotlinx.coroutines.CoroutineScope
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.launch
import kotlinx.coroutines.withContext
import org.json.JSONArray
import org.json.JSONObject
import java.io.BufferedReader
import java.io.InputStreamReader
import java.io.OutputStreamWriter
import java.net.HttpURLConnection
import java.net.URL
import com.bumptech.glide.Glide

class ShopActivity : AppCompatActivity() {

    data class Product(
        val image_url: String,
        val title: String,
        val price: String,
        val total_added:String
    )
    // Data class for user billing information
    data class UserBillingInfo(
        val id: Int,
        val user_id: Int,
        val full_name: String,
        val email: String,
        val card_number: String,
        val exp_month: String,
        val exp_year: String,
        val cvv: String
    )data class PaymentFields(
        val fullNameField: EditText,
        val emailField: EditText,
        val cardNumberField: EditText,
        val expiryDateField: EditText,
        val cvvField: EditText
    )

    private lateinit var sessionManager: SessionManager
    var ip = connect()
    private lateinit var productAdapter: ProductAdapter

    private val cartItems: MutableList<CartItem> by lazy {
        sessionManager.getCartItems().toMutableList()
    }
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_shop)
        sessionManager = SessionManager(this)

        val recyclerView: RecyclerView = findViewById(R.id.recyclerView)
        recyclerView.layoutManager = GridLayoutManager(this, 2)

        productAdapter = ProductAdapter(emptyList(), listOf("S", "M", "L"))
        recyclerView.adapter = productAdapter

        // Fetch the product list from the server
        fetchProductList()
    }

    // Function to fetch product list from the server
    private fun fetchProductList() {
        CoroutineScope(Dispatchers.Main).launch {
            val products = withContext(Dispatchers.IO) {
                try {
                    val url = URL("http://${ip.IP()}/deesus/get_products.php")
                    val connection = url.openConnection() as HttpURLConnection
                    connection.requestMethod = "POST"
                    connection.doOutput = true
                    connection.setRequestProperty("Content-Type", "application/json; utf-8")

                    // Create JSON object to send (if you need to send any parameters)
                    val jsonInputString = "{}" // Modify if parameters are needed
                    connection.outputStream.write(jsonInputString.toByteArray())

                    // Read the response
                    val reader = BufferedReader(InputStreamReader(connection.inputStream))
                    val jsonResponse = reader.readText()
                    reader.close()

                    // Print JSON response for debugging
                    println(jsonResponse)

                    // Parse the JSON response into Product objects
                    Gson().fromJson(jsonResponse, Array<Product>::class.java).toList()
                } catch (e: Exception) {
                    e.printStackTrace()
                    emptyList<Product>()
                }
            }

            // Update the UI with the product list
            updateUIWithProducts(products)
        }
    }

    // Function to update RecyclerView with fetched products
    private fun updateUIWithProducts(products: List<Product>) {
        productAdapter.updateData(products)
        productAdapter.notifyDataSetChanged()
    }

    private inner class ProductAdapter(
        private var products: List<Product>,
        private val sizes: List<String>
    ) : RecyclerView.Adapter<ProductAdapter.ProductViewHolder>() {

        inner class ProductViewHolder(itemView: View) : RecyclerView.ViewHolder(itemView) {
            val cardView: CardView = itemView as CardView
        }

        // Method to update product list in the adapter
        fun updateData(newProducts: List<Product>) {
            products = newProducts
        }

        override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ProductViewHolder {
            val cardView = CardView(parent.context).apply {
                layoutParams = ViewGroup.LayoutParams(
                    ViewGroup.LayoutParams.MATCH_PARENT,
                    ViewGroup.LayoutParams.WRAP_CONTENT
                )
                setCardElevation(4f)
                setCardBackgroundColor(Color.WHITE)
                setContentPadding(8, 8, 8, 8)
            }

            val linearLayout = LinearLayout(parent.context).apply {
                layoutParams = ViewGroup.LayoutParams(
                    ViewGroup.LayoutParams.MATCH_PARENT,
                    ViewGroup.LayoutParams.WRAP_CONTENT
                )
                orientation = LinearLayout.VERTICAL
                setPadding(8, 8, 8, 8)
            }

            val imageView = ImageView(parent.context).apply {
                layoutParams = LinearLayout.LayoutParams(
                    ViewGroup.LayoutParams.MATCH_PARENT,
                    500
                )
                scaleType = ImageView.ScaleType.CENTER_CROP
            }

            val titleView = TextView(parent.context).apply {
                layoutParams = LinearLayout.LayoutParams(
                    ViewGroup.LayoutParams.WRAP_CONTENT,
                    ViewGroup.LayoutParams.WRAP_CONTENT
                ).apply {
                    marginStart = 4
                    topMargin = 4
                }
                setTextColor(Color.BLACK)
                setTypeface(null, Typeface.BOLD)
                gravity = Gravity.START
            }

            val priceView = TextView(parent.context).apply {
                layoutParams = LinearLayout.LayoutParams(
                    ViewGroup.LayoutParams.WRAP_CONTENT,
                    ViewGroup.LayoutParams.WRAP_CONTENT
                )
                setTextColor(Color.DKGRAY)
                gravity = Gravity.START
            }

            // Set up the spinner with sizes
            val sizeSpinner = Spinner(parent.context).apply {
                adapter = ArrayAdapter(parent.context, android.R.layout.simple_spinner_item, sizes).apply {
                    setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item)
                }
                layoutParams = LinearLayout.LayoutParams(
                    ViewGroup.LayoutParams.MATCH_PARENT,
                    ViewGroup.LayoutParams.WRAP_CONTENT
                )
            }

            // Create a horizontal layout for the buttons
            val buttonLayout = LinearLayout(parent.context).apply {
                layoutParams = LinearLayout.LayoutParams(
                    ViewGroup.LayoutParams.MATCH_PARENT,
                    ViewGroup.LayoutParams.WRAP_CONTENT
                )
                orientation = LinearLayout.HORIZONTAL
                setBackgroundColor(Color.WHITE) // Set background color to black
                setPadding(8, 8, 8, 8)
            }

            // Button to add to cart
            val addButton = Button(parent.context).apply {
                text = "  +   "
                setBackgroundColor(Color.WHITE) // Set background color to
                setOnClickListener {
                    // Get selected size from the spinner
                    val selectedSize = sizeSpinner.selectedItem?.toString() ?: "No Size Selected"
                    // Get product title and price
                    val productTitle = titleView.text.toString()
                    val productPrice = priceView.text.toString()
                    addToCart(productTitle, selectedSize, productPrice.toDouble())
                    Toast.makeText(parent.context, "Added to Cart - Product: $productTitle, Price: $productPrice, Size: $selectedSize", Toast.LENGTH_SHORT).show()
                }
            }

            // Button to view cart
            val viewButton = Button(parent.context).apply {
                text = "Cart"
                setBackgroundColor(Color.WHITE) // Set background color to red
                setOnClickListener {
                    showCartDialog(parent.context) // Call the function to show cart dialog
                }
            }

            // Add buttons to the button layout
            buttonLayout.addView(addButton)
            buttonLayout.addView(viewButton)

            // Add views to LinearLayout and then to CardView
            linearLayout.addView(imageView)
            linearLayout.addView(titleView)
            linearLayout.addView(priceView)
            linearLayout.addView(sizeSpinner)
            linearLayout.addView(buttonLayout) // Add the button layout here
            cardView.addView(linearLayout)

            return ProductViewHolder(cardView)
        }

        override fun onBindViewHolder(holder: ProductViewHolder, position: Int) {
            val product = products[position]
            val layout = holder.cardView.getChildAt(0) as LinearLayout
            val imageView = layout.getChildAt(0) as ImageView
            val titleView = layout.getChildAt(1) as TextView
            val priceView = layout.getChildAt(2) as TextView

            // Construct the image URL
            val imageUrl = "http://${ip.IP()}/deesus/${product.image_url}"
            //Toast.makeText(this@ShopActivity, ""+product.image_url, Toast.LENGTH_SHORT).show()

            // Log the image URL to the console
            Log.d("ProductImage", "Loading image from URL: $imageView")

            // Use Glide to load the image from the URL
            Glide.with(holder.itemView.context)
                .load(imageUrl)
                .into(imageView)

            // Set the title and price
            if(product.total_added=="0"){

                titleView.text = product.title +" [ out of stock ]"
            }else{

                titleView.text = product.title
            }

            priceView.text = product.price
        }


        override fun getItemCount(): Int {
            return products.size
        }

        private fun addToCart(title: String, size: String, price: Double) {
            if (title.isNotBlank() && size.isNotBlank()) {
                val existingItem = cartItems.find { it.title == title && it.size == size }
                if (existingItem != null) {
                    // Update existing item
                    existingItem.quantity++
                    existingItem.totalPrice += price
                } else {
                    var prices = price
                    // Add new item
                    cartItems.add(CartItem(title, size, 1, price,prices))
                }
                // Save cart items
                sessionManager.saveCartItems(cartItems)
            } else {
                // Handle invalid input
                Toast.makeText(this@ShopActivity, "Invalid item details", Toast.LENGTH_SHORT).show()
            }
        }



        private fun showCartDialog(context: Context) {
            // Create a custom Dialog for a large, full-screen effect
            val dialog = Dialog(context)
            dialog.requestWindowFeature(Window.FEATURE_NO_TITLE)
            dialog.setContentView(R.layout.cart_dialog_layout) // If using an XML layout

            // Set dialog width to full screen and height to approximately 900dp
            dialog.window?.setLayout(ViewGroup.LayoutParams.MATCH_PARENT, 900)

            dialog.setTitle("Cart Items")

            if (cartItems.isEmpty()) {
                val emptyMessage = TextView(context).apply {
                    text = "Your cart is empty."
                    gravity = Gravity.CENTER
                    setTextColor(Color.BLACK)
                    setTextSize(TypedValue.COMPLEX_UNIT_SP, 18f)
                    setPadding(20, 20, 20, 20)
                }
                dialog.setContentView(emptyMessage)
            } else {
                // Create a larger TableLayout to fill more screen space
                val tableLayout = TableLayout(context).apply {
                    setPadding(32, 32, 32, 32) // Increased padding for more spacing
                    layoutParams = TableLayout.LayoutParams(
                        ViewGroup.LayoutParams.MATCH_PARENT,
                        ViewGroup.LayoutParams.WRAP_CONTENT
                    )
                    setBackgroundColor(Color.BLACK)
                }

                // Add table headers with larger text
                val headerRow = TableRow(context).apply {
                    setPadding(16, 16, 16, 16) // Larger padding
                    setBackgroundColor(Color.parseColor("#008000")) // Green header background
                }

                val headers = arrayOf("Title", "Size", "Qty", "Total", "Edit")
                headers.forEach { headerText ->
                    val header = TextView(context).apply {
                        text = headerText
                        setTypeface(null, Typeface.BOLD)
                        setTextColor(Color.WHITE)
                        setTextSize(TypedValue.COMPLEX_UNIT_SP, 18f) // Larger font size for headers
                        layoutParams = TableRow.LayoutParams(
                            TableRow.LayoutParams.WRAP_CONTENT,
                            TableRow.LayoutParams.WRAP_CONTENT
                        ).apply {
                            marginStart = 16
                            marginEnd = 16
                        }
                    }
                    headerRow.addView(header)
                }

                tableLayout.addView(headerRow)

                // Loop through cart items and add them as rows to the table layout
                cartItems.forEach { cartItem ->
                    val itemRow = TableRow(context).apply {
                        setPadding(16, 16, 16, 16)
                        layoutParams = TableRow.LayoutParams(
                            TableRow.LayoutParams.MATCH_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT
                        )
                    }

                    val titleView = TextView(context).apply {
                        text = cartItem.title
                        setTextColor(Color.WHITE)
                        setTextSize(TypedValue.COMPLEX_UNIT_SP, 16f)
                        maxWidth = 300
                        ellipsize = TextUtils.TruncateAt.END
                        isSingleLine = true
                    }
                    val sizeView = TextView(context).apply {
                        text = cartItem.size
                        setTextColor(Color.WHITE)
                        setTextSize(TypedValue.COMPLEX_UNIT_SP, 16f)
                    }
                    val quantityView = TextView(context).apply {
                        text = cartItem.quantity.toString()
                        setTextColor(Color.WHITE)
                        setTextSize(TypedValue.COMPLEX_UNIT_SP, 16f)
                    }
                    val totalView = TextView(context).apply {
                        text = "R${cartItem.totalPrice}"
                        setTextColor(Color.WHITE)
                        setTextSize(TypedValue.COMPLEX_UNIT_SP, 16f)
                    }

                    // Create edit buttons with larger font and more padding
                    val minusButton = Button(context).apply {
                        text = "-"
                        setTextSize(TypedValue.COMPLEX_UNIT_SP, 18f)
                        setBackgroundColor(Color.parseColor("#008000"))
                        setTextColor(Color.WHITE)
                        setOnClickListener {
                            if (cartItem.quantity > 1) {
                                cartItem.quantity--
                                cartItem.totalPrice = cartItem.pricePerUnit * cartItem.quantity
                                sessionManager.saveCartItems(cartItems)
                                showCartDialog(context)
                            }
                        }
                    }

                    val plusButton = Button(context).apply {
                        text = "+"
                        setTextSize(TypedValue.COMPLEX_UNIT_SP, 18f)
                        setBackgroundColor(Color.parseColor("#008000"))
                        setTextColor(Color.WHITE)
                        setOnClickListener {
                            cartItem.quantity++
                            cartItem.totalPrice = cartItem.pricePerUnit * cartItem.quantity
                            sessionManager.saveCartItems(cartItems)
                            showCartDialog(context)
                        }
                    }

                    // Add views to the row
                    itemRow.apply {
                        addView(titleView)
                        addView(sizeView)
                        addView(quantityView)
                        addView(totalView)

                        // Edit layout with larger buttons
                        val editLayout = LinearLayout(context).apply {
                            orientation = LinearLayout.HORIZONTAL
                            setPadding(16, 16, 16, 16)
                            addView(minusButton)
                            addView(plusButton)
                        }

                        addView(editLayout)
                    }

                    tableLayout.addView(itemRow)
                }

                val totalPrice = cartItems.sumOf { it.totalPrice }
                val totalRow = TableRow(context).apply {
                    setPadding(16, 16, 16, 16)
                    setBackgroundColor(Color.parseColor("#008000"))
                }
                val totalLabel = TextView(context).apply {
                    text = "Total: "
                    setTypeface(null, Typeface.BOLD)
                    setTextColor(Color.WHITE)
                    setTextSize(TypedValue.COMPLEX_UNIT_SP, 18f)
                }
                val totalValue = TextView(context).apply {
                    text = "R$totalPrice"
                    setTypeface(null, Typeface.BOLD)
                    setTextColor(Color.WHITE)
                    setTextSize(TypedValue.COMPLEX_UNIT_SP, 18f)
                }

                totalRow.apply {
                    addView(totalLabel)
                    addView(totalValue)
                }

                tableLayout.addView(totalRow)

                val horizontalScrollView = HorizontalScrollView(context).apply {
                    addView(tableLayout)
                }

                val buttonLayout = LinearLayout(context).apply {
                    orientation = LinearLayout.VERTICAL
                    setPadding(32, 32, 32, 32)
                }

                val checkoutButton = Button(context).apply {
                    text = "Checkout"
                    setBackgroundColor(Color.parseColor("#008000"))
                    setTextColor(Color.WHITE)
                    setTextSize(TypedValue.COMPLEX_UNIT_SP, 18f)
                    setOnClickListener {
                        Toast.makeText(context, "Proceeding to checkout...", Toast.LENGTH_SHORT).show()
                        showPaymentForm(context, totalPrice)
                    }
                }

                buttonLayout.addView(checkoutButton)

                val containerLayout = LinearLayout(context).apply {
                    orientation = LinearLayout.VERTICAL
                    addView(horizontalScrollView)
                    addView(buttonLayout)
                }

                dialog.setContentView(containerLayout)
            }

            dialog.setCancelable(true)
            dialog.show()
        }






        private fun showPaymentForm(context: Context, totalPrice: Double, initialEmail: String? = null) {
            val paymentFormBuilder = AlertDialog.Builder(context)

            // Custom title with black background and gray text
            val title = TextView(context).apply {
                text = "Payment Details"
                textSize = 20f
                setPadding(24, 24, 24, 24)
                setBackgroundColor(Color.BLACK)   // Title background color
                setTextColor(Color.LTGRAY)        // Title text color to gray
                gravity = Gravity.CENTER
            }
            paymentFormBuilder.setCustomTitle(title)

            // Main form layout with a white background
            val formLayout = LinearLayout(context).apply {
                orientation = LinearLayout.VERTICAL
                setPadding(32, 32, 32, 32)  // Padding for form
                setBackgroundColor(Color.WHITE)   // Form background color set to white
            }

            // Style function for clear EditText fields with black bottom border
            val styledEditText: (EditText) -> Unit = { field ->
                field.setTextColor(Color.BLACK)              // Text color black
                field.setHintTextColor(Color.DKGRAY)         // Hint color dark gray
                field.background = null                      // Remove default background
                field.setPadding(24, 24, 24, 8)              // Add padding, especially at bottom

                // Add a black bottom border
                val blackBottomBorder = View(context).apply {
                    layoutParams = LinearLayout.LayoutParams(
                        LinearLayout.LayoutParams.MATCH_PARENT, 3  // Height of the border
                    ).apply {
                        topMargin = 8  // Margin between the field and border
                    }
                    setBackgroundColor(Color.BLACK)
                }

                formLayout.addView(field)                   // Add the field first
                formLayout.addView(blackBottomBorder)       // Add the border below the field
            }

            // Create fields and apply the style function
            val fullNameField = EditText(context).apply {
                hint = "Full Name"
                inputType = InputType.TYPE_CLASS_TEXT
            }
            styledEditText(fullNameField)

            val emailField = EditText(context).apply {
                hint = "Email"
                inputType = InputType.TYPE_TEXT_VARIATION_EMAIL_ADDRESS
                setText(initialEmail)
            }
            styledEditText(emailField)

            val cardNumberField = EditText(context).apply {
                hint = "Card Number"
                inputType = InputType.TYPE_CLASS_NUMBER
            }
            styledEditText(cardNumberField)

            val expiryDateField = EditText(context).apply {
                hint = "Expiry Date (MM/YY)"
                inputType = InputType.TYPE_CLASS_DATETIME
            }
            styledEditText(expiryDateField)

            val cvvField = EditText(context).apply {
                hint = "CVV"
                inputType = InputType.TYPE_CLASS_NUMBER
            }
            styledEditText(cvvField)

            // Set the form layout to the dialog
            paymentFormBuilder.setView(formLayout)

            // Load initial billing info automatically if initialEmail is provided
            initialEmail?.let { email ->
                loadBillingInfo(context, email, fullNameField, cardNumberField, expiryDateField, cvvField)
            }

            val userSession = user_active(this@ShopActivity)
            val userEmail = userSession.getUserEmail()?.toString()
            loadBillingInfo(context, userEmail.toString(), fullNameField, cardNumberField, expiryDateField, cvvField)
            emailField.setText(userEmail)

            // Payment button to proceed with the entered details
            paymentFormBuilder.setPositiveButton("Pay") { _, _ ->
                showConfirmationDialog(context, emailField.text.toString(), totalPrice)
            }

            // Cancel button
            paymentFormBuilder.setNegativeButton("Cancel", null)

            // Display the dialog with full width
            val dialog = paymentFormBuilder.create()
            dialog.window?.setLayout(ViewGroup.LayoutParams.MATCH_PARENT, ViewGroup.LayoutParams.WRAP_CONTENT)  // Full width
            dialog.show()
        }









        private fun loadBillingInfo(
            context: Context,
            email: String,
            fullNameField: EditText,
            cardNumberField: EditText,
            expiryDateField: EditText,
            cvvField: EditText
        ) {
            CoroutineScope(Dispatchers.Main).launch {

                val billingInfo = withContext(Dispatchers.IO) {
                    try {
                        val url = URL("http://${ip.IP()}/deesus/get_billing_info.php")
                        val connection = url.openConnection() as HttpURLConnection
                        connection.requestMethod = "POST"
                        connection.doOutput = true
                        connection.setRequestProperty("Content-Type", "application/json; utf-8")

                        val jsonInputString = "{\"email\": \"$email\"}"
                        connection.outputStream.use { it.write(jsonInputString.toByteArray()) }

                        val reader = BufferedReader(InputStreamReader(connection.inputStream))
                        val jsonResponse = reader.readText()
                        reader.close()

                        Gson().fromJson(jsonResponse, UserBillingInfo::class.java)
                    } catch (e: Exception) {
                        e.printStackTrace()
                        null
                    }
                }

                billingInfo?.let {
                    fullNameField.setText(it.full_name)
                    cardNumberField.setText(it.card_number)
                    expiryDateField.setText("${it.exp_month}/${it.exp_year}")
                    cvvField.setText(it.cvv)
                } ?: Toast.makeText(context, "No billing information found for $email", Toast.LENGTH_SHORT).show()
            }
        }


        // Function to show payment confirmation dialog with black and gray theme
        private fun showConfirmationDialog(context: Context, email: String, totalPrice: Double) {
            val confirmationBuilder = AlertDialog.Builder(context)

            // Custom title with black background and gray text
            val title = TextView(context).apply {
                text = "Confirm Payment"
                textSize = 20f
                setPadding(24, 24, 24, 24)
                setBackgroundColor(Color.BLACK)     // Title background color
                setTextColor(Color.LTGRAY)          // Title text color to gray
                gravity = Gravity.CENTER
            }
            confirmationBuilder.setCustomTitle(title)

            // Custom message styling for the confirmation dialog
            val message = TextView(context).apply {
                text = "Total: R$totalPrice"
                setTextColor(Color.DKGRAY)          // Message text color
                textSize = 18f                      // Text size for better readability
                setPadding(24, 24, 24, 24)          // Padding around the message
            }
            confirmationBuilder.setView(message)

            // Confirm button to proceed with payment
            confirmationBuilder.setPositiveButton("Confirm") { _, _ ->
                // Ensure email is not empty
                if (email.isNotEmpty()) {
                    lifecycleScope.launch {
                        // Call storeAdded and pass email and products
                        val result = storeAdded(email, cartItems)
                        Toast.makeText(context, result, Toast.LENGTH_SHORT).show()
                        cartItems.clear()
                        sessionManager.saveCartItems(cartItems)  // Update session
                        val intent = Intent(context, ShopActivity::class.java)
                        context.startActivity(intent)
                        Toast.makeText(context, "Cart cleared.", Toast.LENGTH_SHORT).show()
                        Toast.makeText(context, "Payment successful!", Toast.LENGTH_SHORT).show()
                    }
                } else {
                    Toast.makeText(context, "Please enter a valid email.", Toast.LENGTH_SHORT).show()
                }
            }

            // Cancel button
            confirmationBuilder.setNegativeButton("Cancel", null)

            // Display the dialog with full width
            val dialog = confirmationBuilder.create()
            dialog.window?.setLayout(ViewGroup.LayoutParams.MATCH_PARENT, ViewGroup.LayoutParams.WRAP_CONTENT)  // Full width
            dialog.show()
        }


        suspend fun storeAdded(email: String, products: MutableList<CartItem>): String {
            return withContext(Dispatchers.IO) {
                try {
                    // Open a single connection for all products
                    val url = URL("http://${ip.IP()}/deesus/order_app.php")
                    val connection = url.openConnection() as HttpURLConnection
                    connection.requestMethod = "POST"
                    connection.doOutput = true
                    connection.setRequestProperty("Content-Type", "application/json; utf-8")

                    // Create a JSON object with email and products
                    val json = JSONObject().apply {
                        put("email", email)
                        put("products", JSONArray().apply {
                            products.forEach { product ->
                                put(JSONObject().apply {
                                    put("title", product.title)
                                    put("size", product.size)
                                    put("price", product.pricePerUnit)
                                    put("quantity", product.quantity)
                                })
                            }
                        })
                    }

                    // Log the JSON data being sent
                    println("Sending JSON: $json")

                    // Write the JSON data to the output stream
                    OutputStreamWriter(connection.outputStream).use { writer ->
                        writer.write(json.toString())
                        writer.flush()
                    }

                    // Get the response code and handle the response
                    val responseCode = connection.responseCode
                    println("Response Code: $responseCode")
                   // showCartDialog(this@ShopActivity)
                    // Handle response based on the response code
                    return@withContext if (responseCode == HttpURLConnection.HTTP_OK) {
                        BufferedReader(InputStreamReader(connection.inputStream)).use { reader ->
                            val response = reader.readText()
                            println("Response from server: $response")
                            "Success: $response"

                        }

                    } else {
                        BufferedReader(InputStreamReader(connection.errorStream)).use { reader ->
                            val errorResponse = reader.readText()
                            println("Error Response from server: $errorResponse")
                            "Error: $responseCode - $errorResponse"
                        }
                    }

                } catch (e: Exception) {
                    e.printStackTrace()
                    return@withContext "Error: ${e.message}"
                }
            }
        }







    }


    // Data class for Order
    data class Order(
        @SerializedName("order_id") val orderId: Int,
        @SerializedName("email") val email: String,
        @SerializedName("product_name") val productName: String,
        @SerializedName("product_image") val productImage: String,
        @SerializedName("product_size") val productSize: String,
        @SerializedName("price") val price: Double,
        @SerializedName("quantity") val quantity: Int,
        @SerializedName("total") val total: Double,
        @SerializedName("order_date") val orderDate: String
    )

    // Function to handle the About Us button click
    fun aboutUs(view: View) {
        // Save the user email in session
        val userSession = user_active(this)
        val userEmail = userSession.getUserEmail()?.toString()
       // Toast.makeText(this, userEmail, Toast.LENGTH_SHORT).show()
        if (!userEmail.isNullOrBlank()) {
            // Pass the email to the method
            fetchUserOrders(userEmail)
        } else {

            Toast.makeText(this, "Please login first", Toast.LENGTH_SHORT).show()
        }
    }

    // Function to fetch user orders from the server
    private fun fetchUserOrders(email: String) {
        CoroutineScope(Dispatchers.Main).launch {
            val orders = withContext(Dispatchers.IO) {
                try {
                    val url = URL("http://${ip.IP()}/deesus/get_order_app.php")
                    val connection = url.openConnection() as HttpURLConnection
                    connection.requestMethod = "POST"
                    connection.doOutput = true
                    connection.setRequestProperty("Content-Type", "application/json; utf-8")

                    // Create JSON object to send
                    val jsonInputString = "{\"email\": \"$email\"}"
                    connection.outputStream.write(jsonInputString.toByteArray())

                    // Read the response
                    val reader = BufferedReader(InputStreamReader(connection.inputStream))
                    val jsonResponse = reader.readText()
                    reader.close()

                    // Print the JSON response for debugging
                    println(jsonResponse)

                    // Parse the JSON response into Order objects
                    Gson().fromJson(jsonResponse, Array<Order>::class.java).toList()
                } catch (e: Exception) {
                    e.printStackTrace()
                    emptyList<Order>()
                }
            }

            // Display the orders in an alert dialog
            displayOrdersDialog(orders)
        }
    }

    // Function to display the orders in an alert dialog
    fun displayOrdersDialog(orders: List<Order>) {
        val builder = AlertDialog.Builder(this)
        builder.setTitle("Made orders")

// Create a ScrollView programmatically
        val scrollView = ScrollView(this)
        val linearLayout = LinearLayout(this).apply {
            orientation = LinearLayout.VERTICAL
            setPadding(16, 16, 16, 16)
        }

// Create a card for each order
        for (order in orders) {
            val cardView = CardView(this).apply {
                layoutParams = LinearLayout.LayoutParams(
                    LinearLayout.LayoutParams.MATCH_PARENT,
                    LinearLayout.LayoutParams.WRAP_CONTENT
                ).apply {
                    setMargins(8, 8, 8, 8)
                }
                radius = 8f
                cardElevation = 4f
                setContentPadding(16, 16, 16, 16)
                setCardBackgroundColor(Color.BLACK) // Set card background to black
            }

            // Create a vertical layout for the card content
            val cardContentLayout = LinearLayout(this).apply {
                orientation = LinearLayout.VERTICAL
            }

            // Set the Product Name as the card title (using a larger font size)
            val titleView = TextView(this).apply {
                text = "Product: ${order.productName ?: "N/A"}"
                textSize = 18f
                setTypeface(null, Typeface.BOLD)
                setTextColor(Color.WHITE) // Set title text color to white for contrast
            }
            cardContentLayout.addView(titleView)

            // Display other order details
            val details = StringBuilder().apply {
                append("Order ID: ${order.orderId}\n")
                append("Quantity: ${order.quantity}\n")
                append("Total: R${order.total}\n")
                append("Order Date: ${order.orderDate ?: "N/A"}\n")
            }

            val detailsView = TextView(this).apply {
                text = details.toString()
                textSize = 16f
                setTextColor(Color.LTGRAY) // Set details text color to light gray for readability
            }
            cardContentLayout.addView(detailsView)

            // Add the card content layout to the card view
            cardView.addView(cardContentLayout)

            // Add each card to the main linear layout
            linearLayout.addView(cardView)
        }

// Add the main linear layout to the scroll view
        scrollView.addView(linearLayout)

// Set the ScrollView as the dialog's view
        builder.setView(scrollView)
            .setPositiveButton("close") { dialog, _ -> dialog.dismiss() }

        builder.create().show()
    }

    //when the button shop is clicked
    fun shops(view: View) {
        //open the shop page
        val open_shop = Intent(this, ShopActivity::class.java);
        startActivity(open_shop)
    }
    //when the button shop is clicked
    fun home(view: View) {
        //open the shop page
        val open_shop = Intent(this, MainActivity::class.java);
        startActivity(open_shop)
    }



    fun contactUs(view: View) {

        //open the shop page
        val open_ContactUs = Intent(this, ContactUsActivity::class.java);
        startActivity(open_ContactUs)
    }

    // Function to handle the Profile button click
    fun profile(view: View) {
        // Get the user session
        val userSession = user_active(this)
        val userEmail = userSession.getUserEmail()?.toString()

        // Check if the user session is not empty
        if (!userEmail.isNullOrBlank()) {
            // Ask the user if they want to log out
            showLogoutConfirmationDialog()
        } else {
            // Open the profile page if session is empty
            val openProfileIntent = Intent(this, ProfileActivity::class.java)
            startActivity(openProfileIntent)
        }
    }

    // Function to show the logout confirmation dialog
    private fun showLogoutConfirmationDialog() {
        val builder = AlertDialog.Builder(this)
        builder.setTitle("Logout Confirmation")
        builder.setMessage("Are you sure you want to logout?")

        builder.setPositiveButton("Yes") { dialog, _ ->
            // Clear the session
            clearUserSession()
            dialog.dismiss()
        }

        builder.setNegativeButton("No") { dialog, _ ->
            dialog.dismiss()
        }

        val alertDialog = builder.create()
        alertDialog.show()
    }

    // Function to clear the user session (Implement this as needed)
    private fun clearUserSession() {
        // Code to clear the user session
        val userSession = user_active(this)
        userSession.clearSession()
        Toast.makeText(this, "you have successfully logged-out", Toast.LENGTH_SHORT).show()
        // Open the profile page if session is empty
        val openProfileIntent = Intent(this, MainActivity::class.java)
        startActivity(openProfileIntent)


    }

}
