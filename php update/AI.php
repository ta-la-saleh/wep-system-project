 <?php 
include 'db.php'; //تضمين ملف الاتصال بقاعدة البيانات 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
//استعلام لجلب الكورسات التابعة لتخصص للذكاء الاصطناعي وترتيبها تنازليا  
$result = mysqli_query($conn, "SELECT * FROM course WHERE major_id = 4 ORDER BY id DESC");
?>
<!-- ai صفحة تخصص -->
<!DOCTYPE html>
<html >
<head >
    <link href="photo/logo-1.png " type="img/x-icon" rel="icon">
    <meta charset="UTF-8">
    <title>Artificial Intelligence Major</title>
    <link href="style.css" rel="stylesheet">

</head>

<body>
<!-- تضمين ملف الهيدر والمنيو -->
<?php include 'header.php'; ?>
<?php include 'menu.php'; ?>
  <!-- معلومات عن التخصص-->
<section class="about-section">
    <h2 class="about-h2"><b>About the Major</b></h2>
    <h4>
       <b> Artificial Intelligence (AI) :</b> focuses on creating systems that learn from data, recognize patterns, and make intelligent decisions with minimal human intervention.
    </h4>
</section>
<main>
    <h2 class="courses-title"><span class="linebefore"></span>
        Courses Available
    </h2>
  <!-- بداية اضافة التخصصات -->
    <div class="courses-container">
<?php   
        if(mysqli_num_rows($result) > 0) { // التحقق إذا يوجد كورسات في قاعدة البيانات
            while($row = mysqli_fetch_array($result)) { // لوب للمرور على كل كورس وعرص بياناته
                
                $course_title = mb_strtolower($row['title']);
                $course_image = "photo/AI.png"; // الصورة الأولى (مقدمة إلى الذكاء الاصطناعي)
               $course_id = $row['id'];

            $check_fav = mysqli_query($conn,
            "SELECT * FROM favorites
                WHERE user_id='$user_id'
             AND course_id='$course_id'");
            $is_favorite = mysqli_num_rows($check_fav) > 0;
                //بحث ذكي عشان يبحث عن الكلمات اذا موجودة في العنوان يغير الصورة الى صورة كورس علم البيانات والتعلم الالي
                if (strpos($course_title, 'بيانات') !== false || strpos($course_title, 'آلي') !== false || strpos($course_title, 'machine') !== false || strpos($course_title, 'data') !== false) {
                    $course_image = "photo/AI1.png"; 
                }
        ?>
           
            <div class="offer-card">
                <div class="card-header">
                  <a href="favorite.php?course_id=<?php echo $row['id']; ?>"
                      class="favorite-icon <?php echo $is_favorite ? 'saved' : ''; ?>">
                           ❤
                    </a>
                    <img src="<?php echo $course_image; ?>" alt="صورة تدل على الدورة">
                </div>

                <h3><?php echo $row['title']; ?></h3><!-- نطبع عنوان الكورس القادم من قاعدة البيانات -->
                <h6 class="description">
                    <?php echo $row['description']; ?> <!--نطبع وصف الكورس -->
                </h6>

                <div class="card-action">
                     <!-- # إذا كان الرابط موجود يتم فتحه، وإذا لا يتم وضع  -->
                    <a href="offer.php?id=<?php echo $row['id']; ?>" class="view-btn">
                        عرض التفاصيل</a>

                </div>
            </div>

        <?php 
            } 
        } else {
            // تظهر في حال لم تقومي بإضافة كورسات للذكاء الاصطناعي في الأدمن بعد
            echo "<p style='text-align:center; width:100%; grid-column: 1 / -1; color: #666;'>لا توجد دورات مضافة في هذا التخصص حالياً.</p>";
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

        <p class="signup">
            Don’t have an account?
            <a href="register.php">Sign up now</a>
        </p>

    </div>
</div>
     <!-- سكريبت جافا للتحكم بالنافذة والمفضلة-->
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