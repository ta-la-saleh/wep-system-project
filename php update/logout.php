//الكود حق تسجيل الخروج Logout
<?php
session_start();

session_destroy(); //حذف كل بيانات الـ Session

header("Location: Home.php"); // يرجع للهوم
exit();
?>