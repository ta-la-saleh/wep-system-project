<?php
session_start();
// الربط بقاعده البيانات 
include 'db.php';

// التحقق اذا كان المستخدم مسجل دخول/ اذا لم يسجل دخول يرجع للصفحه الرئسيه
if (!isset($_SESSION['user_id'])) {
    header("Location: Home.php");
    exit();
}
// حفظ رقم المستخدم 
$user_id = $_SESSION['user_id'];

if (isset($_GET['course_id'])) {
    $course_id = (int) $_GET['course_id'];
// حذف الدورة من  favorites للمستخدم الحالي
    mysqli_query($conn, "
        DELETE FROM favorites 
        WHERE user_id = $user_id 
        AND course_id = $course_id
    ");
}
// بعد الحذف يرجع المستخدم إلى صفحة حسابه
header("Location: my-account.php");
//ايقاف التنفيذ
exit();
?>