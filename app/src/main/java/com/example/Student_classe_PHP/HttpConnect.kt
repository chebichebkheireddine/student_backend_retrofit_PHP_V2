package com.example.Student_classe_PHP

import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.withContext
import java.io.BufferedReader
import java.io.DataOutputStream
import java.io.InputStreamReader
import java.net.HttpURLConnection
import java.net.URL

import okhttp3.MediaType.Companion.toMediaType
import okhttp3.OkHttpClient
import okhttp3.Request
import okhttp3.RequestBody.Companion.toRequestBody


class HttpConnect {
    var res:String=""// we hold http server response request
    var resa:String=""// we hold http server response request
    suspend fun addStudent(
        firstName: String,
        lastName: String,
        dateOfBirth: String,
        email: String,
        phoneNumber: String
    ): Array<String> {
        val url = "http://localhost/Ouared/student/addStudent.php" // Replace this with your actual PHP API URL

        val client = OkHttpClient()

        val json = """
        {
            "first_name": "$firstName",
            "last_name": "$lastName",
            "date_of_birth": "$dateOfBirth",
            "email": "$email",
            "phone_number": "$phoneNumber"
        }
    """.trimIndent()

        val requestBody = json.toRequestBody("application/json".toMediaType())

        val request = Request.Builder()
            .url(url)
            .post(requestBody)
            .build()

        return withContext(Dispatchers.IO) {
            val response = client.newCall(request).execute()
            val responseBody = response.body?.string() ?: ""
            responseBody.split("\n").toTypedArray() // Split by new lines to create an array of strings
        }
    }
    suspend fun Connect(url: URL , postData:String):String{
        withContext(Dispatchers.IO)
        {
            var http= url.openConnection() as HttpURLConnection
            http.requestMethod="POST"
            http.doOutput=true
            http.useCaches=false

            DataOutputStream(http.outputStream).use{it.writeBytes(postData)}//send the POST request
            BufferedReader(InputStreamReader(http.inputStream)).use{br ->//reads responses
                var line :String?
                while(br.readLine().also { line= it }!=null){
                    res=line.toString()
                }
            }
            http.disconnect()
        }
        return res  // return calling functin
    }

}