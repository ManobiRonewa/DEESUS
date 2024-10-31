package com.example.basic

import android.content.Intent
import android.graphics.Color
import android.graphics.Typeface
import android.os.Bundle
import android.view.View
import android.widget.LinearLayout
import android.widget.ScrollView
import android.widget.TextView
import android.widget.Toast
import androidx.appcompat.app.AlertDialog
import androidx.appcompat.app.AppCompatActivity
import androidx.cardview.widget.CardView
import com.google.gson.Gson
import kotlinx.coroutines.CoroutineScope
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.launch
import kotlinx.coroutines.withContext
import java.io.BufferedReader
import java.io.InputStreamReader
import java.net.HttpURLConnection
import java.net.URL

class ContactUsActivity : AppCompatActivity() {

    var ip = connect()
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_contact_us)
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


    // Function to handle the About Us button click
    fun aboutUs(view: View) {
        // Save the user email in session
        val userSession = user_active(this)
        val userEmail = userSession.getUserEmail()?.toString()

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
                    Gson().fromJson(jsonResponse, Array<ShopActivity.Order>::class.java).toList()
                } catch (e: Exception) {
                    e.printStackTrace()
                    emptyList<ShopActivity.Order>()
                }
            }

            // Display the orders in an alert dialog
            displayOrdersDialog(orders)
        }
    }

    // Function to display the orders in an alert dialog
    fun displayOrdersDialog(orders: List<ShopActivity.Order>) {
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



}