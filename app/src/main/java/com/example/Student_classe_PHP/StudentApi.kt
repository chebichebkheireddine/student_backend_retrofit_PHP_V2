package com.example.Student_classe_PHP
import retrofit2.Call
import retrofit2.http.Body
import retrofit2.http.POST

interface StudentApi {
    @POST("student/addStudent.php")
    suspend fun addStudent(@Body student: Student): String


}