package com.example.Student_classe_PHP

import android.content.Intent
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.provider.ContactsContract.CommonDataKinds.Email
import android.widget.Button
import android.widget.EditText
import android.widget.Toast
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.GlobalScope
import kotlinx.coroutines.launch
import kotlinx.coroutines.withContext
import org.json.JSONException
import org.json.JSONObject

import org.json.JSONTokener
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory
import java.net.URL

class LogInPage : AppCompatActivity() {
    //Global Variables
    private var urls = URL(URLs.urlLoge)
    private var postData: String = ""
    private lateinit var  postDataintrr:Array<String>
    private var email: String = ""
    private var password: String = ""

    var id_student: Int = 0
    var studentName: String = ""
    var mesg: String = ""
    var Classement: String = ""


    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_log_in_page)
        //Put here control of XML  of Activity
        val txEmail: EditText = findViewById(R.id.txtEmail)
        val txPassword: EditText = findViewById(R.id.txtPassword)
        val BtnLogin: Button = findViewById(R.id.btnLogin)
        val BtnClose: Button = findViewById(R.id.btnClose)
        val retrofit = Retrofit.Builder()
            .baseUrl("http://localhost/Ouared/student/addStudent.php") // Replace with your base URL
            .addConverterFactory(GsonConverterFactory.create())
            .build()

        val studentApi = retrofit.create(StudentApi::class.java)
        BtnClose.setOnClickListener {
            finishAndRemoveTask()
        }

        BtnLogin.setOnClickListener {
            if (validationEnter(txEmail, txPassword)) {
                GlobalScope.launch {

                    email = txEmail.text.toString()
                    password = txPassword.text.toString()
                    addStudent("vkjdv","dfv","","","")
                        txPassword.text.clear()
                        loginUser()

                }
            } else {
                txPassword.text.clear()
                Toast.makeText(this@LogInPage, "Invalid username and password.", Toast.LENGTH_LONG).show()
                txEmail.requestFocus()


            }
        }
    }


    private fun validationEnter(txEmail: EditText, txPassword: EditText): Boolean {
        var valid: Boolean = true
        if (txEmail.text.isEmpty() || txPassword.text.isEmpty()) {
            valid = false
        }
        return valid
    }


    private suspend fun loginUser() {
        //postData = "email=$email&password=$password "
        postData = "data=${email}"
        val httpConnection = HttpConnect()
        var res = httpConnection.Connect(urls, postData)
        if (res == "no user found") {
            mesg = "Student cannot be found!"
        } else {
            try {

                //parse the result
                //val jsonObject = JSONObject(res)
                /*id_student = jsonObject.s
                studentName = jsonObject.getString("first_name")
                // Avoid overwriting the 'password' variable, as it's used for login
                val lastName = jsonObject.getString("last_name")
                Classement = jsonObject.getString("last_name")*/

                //store user details in PassData class
                //ParsData.s_id_student = id_student
                ParsData.s_studentName = studentName
                ParsData.s_email = email
                ParsData.s_Old_Password = password // Is this intended? Storing password in plain text is insecure
               // ParsData.data = arrayOf(studentName,)

                mesg = "Welcome $studentName!"
                intent = Intent(this@LogInPage, MainActivity::class.java)
                startActivity(intent)
                Toast.makeText(this, mesg, Toast.LENGTH_LONG).show()
            } catch (e: JSONException) {
                // Handle JSON parsing exceptions
                e.printStackTrace()
                mesg = "Error while parsing user data."
                Toast.makeText(this, mesg, Toast.LENGTH_LONG).show()
            }
        }
    }

}
