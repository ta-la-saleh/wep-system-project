//هذا الكود حق تسجيل الدخول Login
<?php
session_start(); //الـ Session تحفظ بيانات المستخدم بعد تسجيل الدخول
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") { //يتاكد هل المستخدم ضغط زر تسجيل الدخول وأرسل الفورم
    //ياخذ الايميل والباسورد من الفورم
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    //هنا عندنا حمية من بعض مشاكل قواعد البيانات
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    //استعلام تسجيل الدخول
    $sql = "SELECT * FROM user 
            WHERE email='$email' AND password='$password'";
    //تنفيذ الاستعلام
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) { // التحقق إذا الحساب موجود اذا فيه حساب مطابق او لا

        $user = mysqli_fetch_assoc($result); //يحفظ بيانات المستخدم داخل متغير
        
        //بعدين نخزنها داخل ال session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['fullName'];

        header("Location: my-account.php"); // نرجع لثفحة الحساب 
        exit();

    } else {
        header("Location: Home.php?login_error=1"); //اذا البيانات غلط نرجع للهوم
        exit();
    }
}
?>