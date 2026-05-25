// كود المفضله
<?php
session_start(); //الـ Session تحفظ بيانات المستخدم بعد تسجيل الدخول
include 'db.php';

if (!isset($_SESSION['user_id'])) { // يتاكد هل المستخدم مسجل دخول
    header("Location: Home.php"); // اذا مو مسجل يرجعه للهوم مباشره
    exit();
}

$user_id = $_SESSION['user_id']; //ياخذ رقم المستخدم الحالي من الـ Session

if (isset($_GET['course_id'])) { //التحقق من وجود course_id

    $course_id = (int) $_GET['course_id']; //حولنا رقم الكورس لعدد صحيح عشان الحماية والتنظيم

    // نتأكد هل الكورس موجود بالمفضلة
    $check = mysqli_query($conn,
    "SELECT * FROM favorites
     WHERE user_id='$user_id'
     AND course_id='$course_id'");

    // إذا موجود ونبغا نحذفه
    if (mysqli_num_rows($check) > 0) {

        mysqli_query($conn,
        "DELETE FROM favorites
         WHERE user_id='$user_id'
         AND course_id='$course_id'");

    } else {

        // إذا مو موجود ونبغا نضيفه
        mysqli_query($conn,
        "INSERT INTO favorites (user_id, course_id)
         VALUES ('$user_id', '$course_id')");
    }
}

header("Location: " . $_SERVER['HTTP_REFERER']); //يرجع المستخدم لنفس الصفحة اللي كان فيها.
exit();
?>
