<?php 
// الربط بقاعده البيانات 
include 'db.php'; 
// التحقق اذ الـ session بدأت او لا
if (session_status() == PHP_SESSION_NONE) {
    session_start(); //  نبدأ ال session
}
// نجيب رقم المستخدم اذا كان مسجل دخول و اذا ماكان مسجل دخول نحط 0 كقيمة افتراضيه
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
$fav_course_ids = [];
// اذا المستخدم مسجل دخول نجيب كل الكورسات الموجوده في المفضله  و حفظها في مصفوفه
if ($user_id) {
    $fav_res = mysqli_query($conn, "SELECT course_id FROM favorites WHERE user_id = $user_id");
    while ($f_row = mysqli_fetch_assoc($fav_res)) {
        $fav_course_ids[] = $f_row['course_id'];
    }
}
// التحقق اذا المستخدم كتب شي في خانه البحث
if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search_word = mysqli_real_escape_string($conn, $_GET['search']);
        // البحث عن الكلمه في العنوان او الوصف
    $result = mysqli_query($conn, "SELECT * FROM course WHERE title LIKE '%$search_word%' OR description LIKE '%$search_word%' ORDER BY id DESC");
} else {
     // إذا ما فيه بحث يعرض آخر 3 دورات 
    $result = mysqli_query($conn, "SELECT * FROM course ORDER BY id DESC LIMIT 3");
}
?>
<!DOCTYPE html>
<html >
<head >
    <link href="photo/logo-1.png " type="img/x-icon" rel="icon"> 
        <!-- دعم اللغه العربية و الانجليزية-->
    <meta charset="UTF-8">
    <title>Home Page</title>
    <!--الربط بملف التنسيق -->
    <link href="style.css" rel="stylesheet">

</head>

<body>
    
<?php include 'header.php'; ?>
<?php include 'menu.php'; ?>
<!--   الصوره الرئسية   -->
<section class="home-section">
    <img src="photo/computer-img.webp" class="computer-img">
<!-- الكتابه الي فوق الصورة -->
    <div class="home-text">
        <h1 class="h1-home">Discover the Best Courses for</h1>
        <h1 class="h2-home">Computer Majors</h1>
    </div>
</section>
 
<h2 class="courses-title">
    <span class="linebefore"></span> Majors 
</h2>
<!-- كود التخصصات مع روابط تنقل كل تخصص لصفحته   -->
<section class="major">
<!--   تقنيه المعلومات IT -->
    <div class="spec-box">
        <a href="IT.php" class="major-link">
        <div class="icon-circle">🖧</div>
        <h3>IT</h3>
        </a>
    </div>
    <!-- علوم الحاسب CS -->

    <div class="spec-box">
        <a href="CS.php" class="major-link">
        <div class="icon-circle">🖥️</div>
        <h3>CS</h3>
        </a>
    </div>
<!-- الامن السيبراني CYBER -->
    <div class="spec-box">
         <a href="CYBER.php" class="major-link">
        <div class="icon-circle">🛡️</div>
        <h3>CYBER</h3>
        </a>
        
    </div>
<!-- الذكاء الصناعي AI -->
    <div class="spec-box">
        <a href="AI.php" class="major-link">
        <div class="icon-circle">🤖</div>
        <h3>AI</h3>
        </a>
    </div>
<!-- هندسه الحاسب CE -->
    <div class="spec-box">
        <a href="CE.php" class="major-link">
        <div class="icon-circle">⚙️</div>
        <h3>CE</h3>
       </a>
    </div>

</section>
 <!-- كود لاضافه الدورات الاكثر شهره عشان يسهل على المستخدم اختيار الدورات -->
<main>
   <h2 class="courses-title" id="popular-courses">
        <span class="linebefore"></span>
        Most Popular Courses
    </h2>

    <div class="courses-container">
        <?php 
         // التحقق من وجود الدوره في قاعده البيانات
           if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) { 
                $course_title = $row['title'];
                $major_id = $row['major_id']; 
                $course_id = $row['id']; 
                // التحقق اذ الدورة موجودة في المفضلة للمستخدم 
                $check_fav = mysqli_query($conn,
                "SELECT * FROM favorites WHERE user_id='$user_id' AND course_id='$course_id'");
               $is_favorite = mysqli_num_rows($check_fav) > 0;
                // اختيار الصوره على حسب كلمات مفتاحيه في اسم الدوره 
                if (strpos($course_title, 'الذكاء') !== false || strpos($course_title, 'AI') !== false) {
                    $course_image = "photo/AI.png"; // صورة الذكاء الاصطناعي
                } elseif (strpos($course_title, 'قواعد') !== false || strpos($course_title, 'بيانات') !== false || strpos($course_title, 'SQL') !== false) {
                   $course_image = "photo/it.jpg";// صورة قواعد البيانات/الـ IT
                } elseif (strpos($course_title, 'CS50') !== false || strpos($course_title, 'علوم الحاسب') !== false) {
                    $course_image = "photo/CS50_5.jpg"; // صورة كورس علوم الحاسب الشهير
                } elseif (strpos($course_title, 'الأمن') !== false || strpos($course_title, 'سيبراني') !== false) {
                    $course_image = "photo/Cyber-Security-4.jpg"; // صورة الأمن السيبراني
                } elseif (strpos($course_title, 'الأشياء') !== false || strpos($course_title, 'IoT') !== false) {
                    $course_image = "photo/CE.jpg"; // صورة إنترنت الأشياء
                } else {
                   // إذا مافي توجد كلمات مفتاحية  يختار صورة حسب التخصص
                    if ($major_id == 1) { $course_image = "photo/it.jpg"; }
                    elseif ($major_id == 2) { $course_image = "photo/CS50_5.jpg"; }
                    elseif ($major_id == 3) { $course_image = "photo/Cyber-Security-4.jpg"; }
                    elseif ($major_id == 4) { $course_image = "photo/AI.png"; }
                    elseif ($major_id == 5) { $course_image = "photo/CE.jpg"; }
                    else { $course_image = "photo/it.jpg"; }
                }
        
        ?>
    <!-- كود اضافه الدورات للمفضله موجود مع كل دوره في الموقع -->
        <div class="offer-card">
            <div class="card-header">
                 <!-- زر إضافة أو إزالة الدورة من المفضلة -->
                <a href="favorite.php?course_id=<?php echo $row['id']; ?>"
               class="favorite-icon <?php echo $is_favorite ? 'saved' : ''; ?>">
                ❤
                </a>
                <img src="<?php echo $course_image; ?>" alt="صورة تدل على الدورة">
            </div>

           <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                <h6 class="description">
                    <?php echo htmlspecialchars($row['description']); ?>
                </h6>
                
                <div class="card-action">
                    <a href="offer.php?id=<?php echo $row['id']; ?>" class="view-btn">
              عرض التفاصيل
              </a>
              
                </div>
            </div>
        <?php 
            } 
        } else {
            // رسالة تطلع للمستخدم اذا كتب كلمة في البحث ما لها كورسات
            echo "<p style='text-align:center; width:100%; color: #666; font-weight: bold; padding: 20px; font-size: 18px;'>عذراً، لم يتم العثور على دورات تطابق بحثك.</p>";
        }
        ?>
    </div>
</main>




<!-- نافذة تسجيل الدخول  -->
<div class="modal" id="loginModal">
    <div class="small-login-box">
  <!-- زر اغلاقها  -->
     <span class="close">&times;</span>
        <div class="logo-box">

            <img src="photo/logo3.png" class="logo-img">
            <span class="logo-text">
            <span class="text1">Devora</span><span class="text2">course</span>
            </span>

        </div>
        

         <!-- يطلع على شكل نافذه  Profile فورم تسجيل الدخول اذا كان المستخدم عنده حساب  في ال  -->
    <form class="login-form" method="POST" action="login.php">
    <label>Email</label>
    <input type="email" name="email" placeholder="Enter your email" required>

    <label>Password</label>
    <input type="password" name="password" placeholder="Enter your password" required>

    <button type="submit" class="login-btn">Login</button>
     </form>
     <!--  اذا ما كان عنده حساب  ينتقل لصفحة تسجيل الدخول -->
        <p class="signup">
            Don’t have an account?
            <a href="register.php">Sign up now</a>
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
//تنقفل النافذه لما نضغط على اي مكان خارجه
window.onclick = (e) => {
    if (e.target === modal) modal.style.display = "none";
}

</script>

<?php } ?>

<script>

// كود زر المفضله(القلب)
document.querySelectorAll('.favorite-icon').forEach(icon => {
    icon.addEventListener('click', () => {
        icon.classList.toggle('active');
    });
});

</script>
 
           

</body>

<?php include 'footer.php'; ?>
</html>
