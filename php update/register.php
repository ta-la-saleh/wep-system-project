 <?php
include 'db.php';

// php validation
// هنا سوينا تخزين لرسايل الخطأ والنجاح
$errors = [];
$success = "";

//إذا النجاح موجود بالرابط ف اعرض رسالة النجاح
if (isset($_GET['success'])) {
    $success = "Account created successfully";
}

// نتأكد إن المستخدم ضغط زر إنشاء الحساب وأرسل الفورم
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // trim يشيل المسافات الزايدة من البداية والنهاية
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // نتحقق ان البيانات مو فاضية
    if (empty($fullname)) {
        $errors[] = "Full name is required";
    }

    if (empty($email)) {
        $errors[] = "Email is required";

    // نتأكد أن صيغة الايميل صحيحة
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    if (empty($password)) {
        $errors[] = "Password is required";
    }

    // اذا مافي اخطاء معناته البيانات سليمة
    if (empty($errors)) {

        // حماية البيانات قبل التخزين
        $fullname = mysqli_real_escape_string($conn, $fullname);
        $email = mysqli_real_escape_string($conn, $email);
        $password = mysqli_real_escape_string($conn, $password);

        // نضيف مستخدم جديد داخل جدول user
        $sql = "INSERT INTO user (fullName, email, password, creation_date)
                VALUES ('$fullname', '$email', '$password', NOW())";

        //اذا نجح الحفظ في قاعدة البيانات تظهر رسالة نجاح
        if (mysqli_query($conn, $sql)) {

            header("Location: register.php?success=1");
            exit();

        // اذا فشل الحفظ تظهر رسالة خطأ
        } else {

            $errors[] = "Database error: " . mysqli_error($conn);

        }
    }
}
?>

<!-- صفحة تسجنيل الدخول اذا كان المستخدم ما عنده حساب من قبل -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link href="photo/logo-1.png" type="img/x-icon" rel="icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Create Account</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="page-content">

<?php include 'header.php'; ?>
<?php include 'menu.php'; ?>

<!-- كود مربع انشاء الحساب -->
<div class="main-wrapper">

    <div class="form-card">

        <div class="form-header">

            <i class="user-icon">👤</i>

            <h2>Create Your Account</h2>

            <p>Fill in your details to get started</p>

            <?php

            // اذا فيه اخطاء تنعرض 
            if (!empty($errors)) {

                foreach ($errors as $error) {

                    echo "<p style='color:red;'>$error</p>";

                }
            }

            // اذا تم التسجيل بنجاح تظهر رسالة خضراء
            if (!empty($success)) {

                echo "<p id='successText' style='color:green;'>$success</p>";

            }

            ?>

        </div>

        <!-- من هنا تبدا خانات تسجيل الدخول -->

        <!-- 
        method="POST" يرسل البيانات بطريقة مخفية
        action="register.php" يرسل البيانات لنفس الصفحة
        novalidate يلغي تحقق المتصفح الافتراضي
        -->
        <form id="registrationForm" method="POST" action="register.php" novalidate>

            <!-- خانة الاسم -->
            <div class="input-group">

                <input type="text" id="fullname" name="fullname" placeholder="Full Name" required>

                <!-- مكان ظهور خطأ الجافاسكربت -->
                <span class="error-msg" id="userError"></span>

            </div>

            <!-- خانة الايميل -->
            <div class="input-group">

                <input type="email" id="email" name="email" placeholder="Email" required>

                <span class="error-msg" id="emailError"></span>

            </div>

            <!-- خانة الباسوورد -->
            <div class="input-group">

                <input type="password" id="password" name="password" placeholder="Password" required>

                <span class="error-msg" id="passError"></span>

            </div>

            <!-- زر انشاء الحساب -->
            <button type="submit" class="submit-btn">

                Create Account

            </button>

        </form>

    </div>

</div>

<!-- عشان اربط بكود تحقق الجافا سكريبت -->
<script src="validation.js"></script>

<!-- كود المودل الي يطلع لما يصير الحساب -->
<div id="successModal" class="success-modal"
<?php if(isset($_GET['success'])) echo 'style="display:flex;"'; else echo 'style="display:none;"'; ?>>

    <div class="modal-content">

        <div class="success-icon">✔</div> <!-- أيقونة النجاح -->
        <h3>Success!</h3>
        <p>Your account has been created successfully.</p>
        <button onclick="closeModal()" class="close-modal-btn"> <!-- هنا زر ال continue -->
            Continue
        </button>

    </div>

</div>

<script>

// دالة اغلاق نافذة النجاح
function closeModal() {

    // اخفاء المودال
    document.getElementById("successModal").style.display = "none";

    // اخفاء النص الاخضر
    var successText = document.getElementById("successText");

    if (successText) { //التحقق من وجود رسالة النجاح

        successText.style.display = "none"; //اخفاء الرسالة

    }

    window.history.replaceState({}, document.title, "register.php"); // اذا نجح كل شي يرجعنا لصفحة الريجستر الطبيعيه 

}

</script>

<?php include 'footer.php'; ?>

</div>

</body>
</html>
