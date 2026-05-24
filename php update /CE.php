  <?php 
include 'db.php'; 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
//اسحب الدورات من قاعده البيانات لتخصص هندسة البرمجيات
$result = mysqli_query($conn, "SELECT * FROM course WHERE major_id = 5 ORDER BY id DESC");
?>
  <!-- ce صفحه تخصص  -->
<!DOCTYPE html>
<html >
<head >
    <link href="photo/logo-1.png " type="img/x-icon" rel="icon"> <!-- الأيقونة اللي تظهر بالتبويب -->
    <meta charset="UTF-8">
    <title>Software Engineering Major</title>
    <link href="style.css" rel="stylesheet"> <!-- ربط CSS -->

</head>

<body>
 
<?php include 'header.php'; ?>
<?php include 'menu.php'; ?>
    <!-- قسم فيه معلومات عامه للمستخدم عن التخصص -->
<section class="about-section">
    <h2 class="about-h2"><b>About the Major</b></h2>
    <h4>
       <b> Software Engineering (SE) :</b> focuses on designing, developing, testing, and maintaining software using structured methods to ensure quality, reliability, and efficiency.</h4>
</section>
  
<main>
    <!-- عنوان الدورات -->
    <h2 class="courses-title"><span class="linebefore"></span> 
        Courses Available
    </h2>
     <!-- المكان اللي ينعرض داخله كل الكورسات -->
    <div class="courses-container">
<?php 
        if(mysqli_num_rows($result) > 0) { //اول شي نتاكد هل الكورس موجود او لا 
            while($row = mysqli_fetch_array($result)) {  //نبدأ نمر على الكورسات 
            $course_id = $row['id'];

            $check_fav = mysqli_query($conn,
            "SELECT * FROM favorites
                WHERE user_id='$user_id'
             AND course_id='$course_id'");
            $is_favorite = mysqli_num_rows($check_fav) > 0;

                $course_title = mb_strtolower($row['title']);  //نحول اسم الكورس لحروف صغيرة عشان الفحص يصير أسهل
                $course_image = "photo/CE.jpg"; // إذا ما تحقق أي شرط نستخدم صوره اغتراضيه الي هي (إنترنت الأشياء)
                //اذا شاف واحد من هذه العنواين يغير الصورة تلقائيا على حسب العنوان
                if (strpos($course_title, 'روبوت') !== false || strpos($course_title, 'robot') !== false) {
                    $course_image = "photo/CE1.jpg"; 
                } elseif (strpos($course_title, 'شبك') !== false || strpos($course_title, 'network') !== false) {
                    $course_image = "photo/CE2.jpg"; 
                }
        ?>
            
            <div class="offer-card">
                <div class="card-header"> 
                 <!-- أيقونة المفضلة ❤️ -->
                    <a href="favorite.php?course_id=<?php echo $row['id']; ?>"
                      class="favorite-icon <?php echo $is_favorite ? 'saved' : ''; ?>">
                           ❤
                    </a>
                    <!-- تنعرض الصورة اللي تحددت من شرط الـ if -->
                    <img src="<?php echo $course_image; ?>" alt="صورة تدل على الدورة"> 
                </div>
                
                <h3><?php echo $row['title']; ?></h3>
                
                <h6 class="description">
                    <?php echo $row['description']; ?>
                </h6> 

                <div class="card-action">
           <!-- يرسل المستخدم لصفحة التفاصيل (صفحة الـ offer) -->
          <a href="offer.php?id=<?php echo $row['id']; ?>" class="view-btn">
        عرض التفاصيل
         </a>
       </div>
            </div>

        <?php 
            } 
        } else {
            // تظهر في حال لم نقم بإضافة كورسات لهندسة البرمجيات في الأدمن بعد
            echo "<p style='text-align:center; width:100%; grid-column: 1 / -1; color: #666;'>لا توجد دورات مضافة في هذا التخصص حالياً.</p>";
        }
        ?>
     
    </div>
</main>
  
<!-- نافذة تسجيل الدخول -->
<div class="modal" id="loginModal">
    <div class="small-login-box">

        <span class="close">&times;</span>

        <div class="logo-box">
    <img src="photo/logo3.png" class="logo-img">
    <span class="logo-text">
    <span class="text1">Devora</span><span class="text2">course</span>
</span>

</div>
       <!-- فورم تسجيل الدخول -->
        <form class="login-form" method="POST" action="login.php">
    <label>Username</label>
    <input type="text" placeholder="Enter your username" required>

    <label>Password</label>
    <input type="password" placeholder="Enter your password" required>

    <button type="submit" class="login-btn">Login</button>
</form>
        <!-- إذا ما كان فيه حساب فيه خيار التسجيل -->
        <p class="signup">
            Don’t have an account?
            <a href="register.php">Sign up now</a>
        </p>

    </div>
</div>
<!-- نخلي نافذة تسجيل الدخول تفاعلية -->
<?php if(!isset($_SESSION['user_id'])) { ?>

<script>

const modal = document.getElementById("loginModal");
const profileBtn = document.getElementById("profileBtn");
const closeBtn = document.querySelector(".close");

profileBtn.onclick = () => modal.style.display = "block";

closeBtn.onclick = () => modal.style.display = "none";

window.onclick = (e) => {
    if (e.target === modal) modal.style.display = "none";
}

</script>

<?php } ?>
  

</body>
<!-- تضمين الفوتر -->
 <?php include 'footer.php'; ?>
</html>
