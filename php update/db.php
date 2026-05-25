<?php
/* نربط الـ PHP بقاعدة البيانات */

$servername = "localhost"; 
$username   = "root";     
$password   = "";         
$dbname     = "devoracourse"; 
/* هنا سوينا الربط باستخدام:
اسم السيرفر + اليوزر + الباسورد + اسم الداتابيس */
$conn = mysqli_connect($servername, $username, $password, $dbname);
/* التحقق إذا الربط نجح أو لا */
if (!$conn) {
    /* إذا فشل الاتصال تظهر رسالة الخطأ */
    die("Connection failed: " . mysqli_connect_error());
}

?>