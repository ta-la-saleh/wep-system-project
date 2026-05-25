<?php 
//  الاتصال بالقاعدة أول شيء في الصفحة
include 'db.php'; 

// استعلام لجلب جميع الكورسات   
$result = mysqli_query($conn, "SELECT * FROM course ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    
    <link href="photo/logo-1.png" type="img/x-icon" rel="icon">
    <meta charset="UTF-8">
    <title>Devora Courses</title>
    <!--ربط ملف css-->
    <link href="style.css" rel="stylesheet">
</head>
<body>

     <!--تضمين ملف الهيدر والمنيو -->
<?php include 'header.php'; ?>
<?php include 'menu.php'; ?>

<!--عرض محتويات الصفحة الرئيسية الصورة والنص-->
<section class="home-section">
    <img src="photo/computer-img.webp" class="computer-img">
    <div class="home-text">
        <h1 class="h1-home">Discover the Best Courses for</h1>
        <h1 class="h2-home">Computer Majors</h1>
    </div>
</section>

<main>
    <h2 class="courses-title">
        <span class="linebefore"></span> Courses Available
    </h2>

    <div class="courses-container">
        <?php 
        
        if (mysqli_num_rows($result) > 0) {//التحقق اذا قاعدة البيانات تحوي كورسات او لا
            while($row = mysqli_fetch_array($result)) { //لوب للمرور على كل الكورسات
        ?>

            <!-- كود اضافه الدورات الى قائمة المفضلات موجود مع كل دوره في الموقع -->
            <div class="offer-card">
                <div class="card-header">
                    <span class="favorite-icon">❤️</span>
                    <img src="photo/it.jpg" alt="صورة الدورة">
                </div>
                <h3><?php echo $row['title']; ?></h3><!-- لطباعة عنوان الكورس القادم من قاعدة البيانات -->
                <h6 class="description"><?php echo $row['description']; ?></h6>,<!--طباعة وصف الكورس-->
                <div class="card-action">
                    <a href="#" class="view-btn">عرض التفاصيل</a>
                </div>
            </div>
        <?php 
            } 
        } else {
             //رسالة تظهر اذا لم نقم باضافة كورسات بعد 
            echo "<p style='text-align:center; width:100%'>لا توجد دورات مضافة حالياً.</p>";
        }
        ?>
    </div>
</main>
<!-- كود تسجيل الدخول-->
<div class="modal" id="loginModal">
    <div class="small-login-box">
        <span class="close">&times;</span>
        <div class="logo-box">
            <img src="photo/logo3.png" class="logo-img">
            <span class="logo-text"><span class="text1">Devora</span><span class="text2">course</span></span>
        </div>
        <!-- فورم تسجيل الدخول -->
        <form class="login-form">
            <label>Username</label>
            <input type="text" placeholder="Enter your username" required>
            <label>Password</label>
            <input type="password" placeholder="Enter your password" required>
            <button type="submit" class="login-btn">Login</button>
        </form>
         <!-- رابط إنشاء حساب -->
        <p class="signup">Don’t have an account? <a href="register.html">Sign up now</a></p>
    </div>
</div>


<?php if(!isset($_SESSION['user_id'])) { ?>

<script>
// جلب عناصر نافذة تسجيل الدخول
const modal = document.getElementById("loginModal");
const profileBtn = document.getElementById("profileBtn");
const closeBtn = document.querySelector(".close");

// فتح نافذة تسجيل الدخول عند الضغط على زر البروفايل
if(profileBtn) {
    profileBtn.onclick = () => modal.style.display = "block";
}
// إغلاق النافذة عند الضغط على زر الإغلاق
closeBtn.onclick = () => modal.style.display = "none";
// إغلاق النافذة عند الضغط خارجها
window.onclick = (e) => {
    if (e.target === modal) modal.style.display = "none";
}

// كود اضافة او ازالة المفضلة
document.querySelectorAll('.favorite-icon').forEach(icon => {
    icon.addEventListener('click', () => {
        icon.classList.toggle('active');
    });
});

</script>

<?php } ?>

</body>
<!-- تضمين الفوتر -->
<?php include 'footer.php'; ?>
</html>