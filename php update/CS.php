<?php 
include 'db.php';
//  إذا كانت الجلسة مو مفعلة  نبدأها
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//نجيب رقم المستخدم اذا كان مسجل دخول و اذا ما كان مسجل دخول نحط 0 كقيمه افتراضيه 
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0; 
// نجيب الكورسات حقت التخصص و نرتبها من الاحدث للاقدم 
$result = mysqli_query($conn, "SELECT * FROM course WHERE major_id = 2 ORDER BY id DESC");
?>
<!--   csصفحة تخصص -->
<!DOCTYPE html>
<html >
<head >  
<link href="photo/logo-1.png " type="img/x-icon" rel="icon">
  <!-- دعم اللغة العربية والإنجليزية -->
<meta charset="UTF-8">
    <title>Computer Science Major</title>
      <!-- ملف التنسيق  -->
    <link href="style.css" rel="stylesheet">

</head>

<body>
 <!-- تضمين الهيدر و المينو -->
<?php include 'header.php'; ?>
<?php include 'menu.php'; ?>

   <!-- معلومات عن التخصص -->
<section class="about-section">
    <h2 class="about-h2"><b>About the Major</b></h2>
    <h4>
       <b> Computer Science (CS) :</b> focuses on understanding how computers work through studying algorithms, programming, data structures, and the foundations of building software systems.
</section>
<main>
    <h2 class="courses-title"><span class="linebefore"></span>
        Courses Available
    </h2>
    <!-- بداية اكواد اضافة التخصصات -->
    <div class="courses-container">
<?php 
// نتحقق من وجود كورسات في قاعدة البيانات
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)) { 
                // نحول اسم الكورس إلى حروف صغيرة للمقارنة
                $course_title = mb_strtolower($row['title']);
                $course_image = "photo/CD1.jpg"; // صورة  (أساسيات الحاسوب)
                $course_id = $row['id'];
 // للتحقق إذا كان الكورس مضاف في المفضلة للمستخدم الحالي
            $check_fav = mysqli_query($conn,
            "SELECT * FROM favorites
                WHERE user_id='$user_id'
             AND course_id='$course_id'");
            $is_favorite = mysqli_num_rows($check_fav) > 0;

        // تغيير الصورة حسب عنوان الكورس
                if (strpos($course_title, '50') !== false || strpos($course_title, 'علوم الحاسب') !== false || strpos($course_title, 'cs50') !== false) {
                    $course_image = "photo/CS50_5.jpg"; 
                } elseif (strpos($course_title, 'بايثون') !== false || strpos($course_title, 'python') !== false || strpos($course_title, 'برمجة') !== false) {
                    $course_image = "photo/python1.jpg"; // صورة كورس بايثون
                }
        ?>
            <!-- بطاقة عرض الكورس -->
            <div class="offer-card">
                <div class="card-header">
                    <!-- زر المفضلة -->
                    <a href="favorite.php?course_id=<?php echo $row['id']; ?>"
                      class="favorite-icon <?php echo $is_favorite ? 'saved' : ''; ?>">
                           ❤
                    </a>
                    <!-- صورة الكورس -->
                    <img src="<?php echo $course_image; ?>" alt="صورة تدل على الدورة">
                </div>
                    <!-- اسم الكورس --> 
                <h3><?php echo $row['title']; ?></h3>
                <!-- وصف الكورس -->
                <h6 class="description">
                    <?php echo $row['description']; ?>
                </h6> 

                <div class="card-action">
                    <!-- زر عرض تفاصيل الكورس -->
    <a href="offer.php?id=<?php echo $row['id']; ?>" class="view-btn">
        عرض التفاصيل
    </a>
</div>
            </div>

        <?php 
            } 
        } else {
            // تطلع اذا ما تم إدخال كورسات لـ CS في الأدمن 
            echo "<p style='text-align:center; width:100%; grid-column: 1 / -1; color: #666;'>لا توجد دورات مضافة في هذا التخصص حالياً.</p>";
        }
        ?>
        
    </div>
</main>

 <!--  كود تسجيل الدخول -->
<div class="modal" id="loginModal">
    <div class="small-login-box">

        <span class="close">&times;</span>

        <div class="logo-box">
    <img src="photo/logo3.png" class="logo-img">
    <span class="logo-text">
    <span class="text1">Devora</span><span class="text2">course</span>
</span>

</div>
      <!--  فورم تسجيل الدخول -->
         <form class="login-form" method="POST" action="login.php">
    <label>Username</label>
    <input type="text" placeholder="Enter your username" required>

    <label>Password</label>
    <input type="password" placeholder="Enter your password" required>

    <button type="submit" class="login-btn">Login</button>
</form>
        <!-- رابط التسجيل -->
        <p class="signup">
            Don’t have an account?
            <a href="register.html">Sign up now</a>
        </p>

    </div>
</div>
<?php if(!isset($_SESSION['user_id'])) { ?>

<script>

const modal = document.getElementById("loginModal");
const profileBtn = document.getElementById("profileBtn");
const closeBtn = document.querySelector(".close");
 // لما نضغط على البروفايل يطلع لنا نافذه تسجيل الدخول 
profileBtn.onclick = () => modal.style.display = "block";
// تتقفل النافذه لما نضغط على X
closeBtn.onclick = () => modal.style.display = "none";
//تنقفل النافذه لما نضغط على اي مكان خارجها 
window.onclick = (e) => {
    if (e.target === modal) modal.style.display = "none";
}

</script>

<?php } ?>
 


</body>
<!-- تضمين الفوتر -->
<?php include 'footer.php'; ?>
</html>