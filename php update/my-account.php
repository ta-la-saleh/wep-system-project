<?php
// الربط بقاعده البيانات 
include 'db.php';
session_start();
// التحقق اذا كان المستخدم مسجل دخول/ اذا لم يسجل دخول يرجع للصفحه الرئسيه
if (!isset($_SESSION['user_id'])) {
    header("Location: Home.php");
    exit();
}
// حفظ رقم المستخدم 
$user_id = $_SESSION['user_id'];
// جلب بيانات المستخدم
$result = mysqli_query($conn, "SELECT * FROM user WHERE id = $user_id");

$user = mysqli_fetch_assoc($result);

$result = mysqli_query($conn, "SELECT * FROM user WHERE id = $user_id");

$user = mysqli_fetch_assoc($result);
?>

<!-- الصفحه الشخصيه للمستخدم -->
<!DOCTYPE html>
<html>
<head>
    <link href="photo/logo-1.png" type="img/x-icon" rel="icon">
    <!-- دعم اللغه العربية و الانجليزية-->
    <meta charset="UTF-8">
    <title>My account</title>
    <!--  الربط بملف التنسيق -->
    <link rel="stylesheet" href="style.css"> 
</head>

<body>

<div class="page-content">

// تضمين الهيدر و المينو
<?php include 'header.php'; ?>
<?php include 'menu.php'; ?>

    <!-- كود اضافة معلومات المستخدم  
     / المفترض تربط بقاعدة البيانات بحيث اول مايسجل المستخدم الدخول تحفظ بياناته هنا -->
<section class="about-section">
    <h2 class="about-h2"><b>Welcome to your account</b></h2>
    <h4>
       <div>
        <!-- عرض اسم المستخدم من قاعدة البيانات -->
    User name :
    <?php echo $user['fullName']; ?>
</div>
<br>

<div>
    Email :
    <?php echo $user['email']; ?>
</div>
<br>
<!-- كلمة المرور لا تظهر حفاظاً على الأمان -->
<div>
    Password :
    ********
</div>
    </h4>
</section>
<a href="logout.php" class="view-btn">Logout</a>

<!-- كود الدورات المفضلة -->
 <div class="favorites-section">
    <h2 class="courses-title"><span class="linebefore"></span>
        My favourite courses (❤)
    </h2>
    
    <div class="courses-container">
<?php
// استعلام عشا نجيب الدورات المفضلة للمستخدم
$fav_query = mysqli_query($conn, "
    SELECT course.*
    FROM favorites
    JOIN course ON favorites.course_id = course.id
    WHERE favorites.user_id = $user_id
    ORDER BY favorites.id DESC
");
// التحقق إذا كان عند المستخدم دورات مفضلة
if (mysqli_num_rows($fav_query) > 0) {
    while ($fav = mysqli_fetch_array($fav_query)) {
?>
        <div class="offer-card">
            <div class="card-header">
                <img src="photo/<?php echo $fav['image']; ?>" alt="صورة الدورة">
            </div>

            <h3><?php echo htmlspecialchars($fav['title']); ?></h3>

            <h6 class="description">
                <?php echo htmlspecialchars($fav['description']); ?>
            </h6>

            <div class="card-action">
                <a href="offer.php?id=<?php echo $fav['id']; ?>" class="view-btn">
                    عرض التفاصيل
                </a>
            </div>
        </div>
<?php
    }
} else {
      // رسالة إذا مافي دورات مفضلة
    echo "<p style='margin:30px;'>ما عندك دورات مفضلة حالياً.</p>";
}
?>
</div>
</div>

</div> 

</body>
// تضمين الفوتر
<?php include 'footer.php'; ?>
</html>