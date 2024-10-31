package com.example.basic

import android.content.Intent
import android.graphics.Color
import android.os.Bundle
import android.view.View
import android.widget.Button
import android.widget.TableLayout
import android.widget.TableRow
import android.widget.TextView
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import com.google.gson.Gson
import kotlinx.coroutines.CoroutineScope
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.launch
import kotlinx.coroutines.withContext
import java.io.BufferedReader
import java.io.InputStreamReader
import java.net.HttpURLConnection
import java.net.URL

// Data class to represent a User
data class User(val id: String, val name: String, val email: String, val calls: String)

class adminManageUsers : AppCompatActivity() {

    private lateinit var tableLayout: TableLayout
    private var userList = mutableListOf<User>() // Mutable list to manage users
    var ip = connect()

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_admin_manage_users) // Your main layout

        tableLayout = findViewById(R.id.tableLayout)

        // Fetch users from server
        fetchUsers()
    }

    // Function to fetch users from the server
    private fun fetchUsers() {
        CoroutineScope(Dispatchers.Main).launch {
            userList = withContext(Dispatchers.IO) {
                try {
                    val url = URL("http://${ip.IP()}/deesus/userload.php")
                    val connection = url.openConnection() as HttpURLConnection
                    connection.requestMethod = "POST"
                    connection.doOutput = true
                    connection.setRequestProperty("Content-Type", "application/json; utf-8")

                    // Read the response
                    val reader = BufferedReader(InputStreamReader(connection.inputStream))
                    val jsonResponse = reader.readText()
                    reader.close()

                    // Print the JSON response for debugging
                    println(jsonResponse)

                    // Parse the JSON response into User objects and convert to MutableList
                    Gson().fromJson(jsonResponse, Array<User>::class.java).toList().toMutableList()
                } catch (e: Exception) {
                    e.printStackTrace()
                    mutableListOf<User>() // Return an empty MutableList in case of error
                }
            }

            // Populate the table with the fetched user data
            populateTable()
        }
    }


    // Populate the table with user data
    private fun populateTable() {
        // Clear existing rows except the header
        tableLayout.removeViewsInLayout(1, tableLayout.childCount - 1)

        for (user in userList) {
            val tableRow = TableRow(this).apply {
                setBackgroundColor(Color.parseColor("#FFFFFF")) // White row background
                layoutParams = TableLayout.LayoutParams(
                    TableLayout.LayoutParams.MATCH_PARENT,
                    TableLayout.LayoutParams.WRAP_CONTENT
                ).apply {
                    setMargins(0, 4, 0, 4) // Add spacing between rows
                }
            }

            val userNameTextView = TextView(this).apply {
                layoutParams = TableRow.LayoutParams(0, TableRow.LayoutParams.WRAP_CONTENT, 1f)
                text = user.name
                textSize = 16f
                setPadding(16, 16, 16, 16)
                setTextColor(Color.parseColor("#333333")) // Dark grey text
                textAlignment = TextView.TEXT_ALIGNMENT_CENTER
            }

            val userEmailTextView = TextView(this).apply {
                layoutParams = TableRow.LayoutParams(0, TableRow.LayoutParams.WRAP_CONTENT, 1f)
                text = user.email
                textSize = 16f
                setPadding(16, 16, 16, 16)
                setTextColor(Color.parseColor("#333333"))
                textAlignment = TextView.TEXT_ALIGNMENT_CENTER
            }

            val userCallsTextView = TextView(this).apply {
                layoutParams = TableRow.LayoutParams(0, TableRow.LayoutParams.WRAP_CONTENT, 1f)
                text = user.calls.toString()
                textSize = 16f
                setPadding(16, 16, 16, 16)
                setTextColor(Color.parseColor("#333333"))
                textAlignment = TextView.TEXT_ALIGNMENT_CENTER
            }

            val deleteButton = Button(this).apply {
                text = "-"
                setBackgroundColor(Color.WHITE) // White button background
                setTextColor(Color.BLACK) // Black text color
                textSize = 14f
                setPadding(16, 8, 16, 8)
                setOnClickListener {
                    deleteUser(user)
                }
            }

            // Add each view to the row
            tableRow.addView(userNameTextView)
            tableRow.addView(userEmailTextView)
            tableRow.addView(userCallsTextView)
            tableRow.addView(deleteButton)

            // Add the row to the table layout
            tableLayout.addView(tableRow)
        }
    }


    // Function to delete a user
    private fun deleteUser(user: User) {
        // Remove user from the list
        userList.remove(user)
        delete(user.id)

        // Fetch users from server
        fetchUsers()


        Toast.makeText(this, "${user.name} has been deleted.", Toast.LENGTH_SHORT).show()
       // populateTable()
    }


    // Function to fetch users from the server
    private fun delete(id: String?) {
        CoroutineScope(Dispatchers.Main).launch {
            userList = withContext(Dispatchers.IO) {
                try {
                    val url = URL("http://${ip.IP()}/deesus/deleteuser.php")
                    val connection = url.openConnection() as HttpURLConnection
                    connection.requestMethod = "POST"
                    connection.doOutput = true
                    connection.setRequestProperty("Content-Type", "application/json; utf-8")

                    // Create JSON object to send with user ID
                    val jsonInputString = "{\"id\": \"$id\"}"
                    connection.outputStream.write(jsonInputString.toByteArray())

                    // Read the response
                    val reader = BufferedReader(InputStreamReader(connection.inputStream))
                    val jsonResponse = reader.readText()
                    reader.close()

                    // Print the JSON response for debugging
                    println(jsonResponse)

                    // Parse the JSON response into User objects and convert to MutableList
                    Gson().fromJson(jsonResponse, Array<User>::class.java).toList().toMutableList()
                } catch (e: Exception) {
                    e.printStackTrace()
                    mutableListOf<User>() // Return an empty MutableList in case of error
                }
            }

            // Populate the table with the updated user data
           // populateTable()
        }
    }

    fun mains(view: View) {
        
        //open the shop page
        val open_profile = Intent(this, admin::class.java);
        startActivity(open_profile)
    }





}
