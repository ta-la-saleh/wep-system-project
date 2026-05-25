<?php 
include 'db.php'; //تضمين ملف الاتصال بقاعدة البيانات 
//استعلام لجلب الكورسات التابعة لتخصص تقنية الملعومات وترتيبها
$result = mysqli_query($conn, "SELECT * FROM course WHERE major_id = 1 ORDER BY id DESC");
?>
 <!--  it صفحه تخصص ال -->
<!DOCTYPE html>
<html >
<head >
    <link href="photo/logo-1.png " type="img/x-icon" rel="icon">
    <meta charset="UTF-8">
    <title>Information Technology Major</title>
    <link href="style.css" rel="stylesheet">

</head>

<body>
   <!-- تضمين ملف الهيدر والمنيو -->
  <?php include 'header.php'; ?>
  <?php include 'menu.php'; ?>

  <!-- اضافة معلومات عامه عن التخصص -->
<section class="about-section">
    <h2 class="about-h2"><b>About the Major</b></h2>
    <h4>
       <b> Information Technology (IT) :</b> focuses on managing, supporting, and maintaining computer systems, networks, and digital infrastructure to ensure smooth and efficient operations.</h4>
</section>


<main>
    <h2 class="courses-title"><span class="linebefore"></span>
        Courses Available
    </h2>
     <!-- بداية التخصصات -->
<div class="courses-container">

    <?php 
    if(mysqli_num_rows($result) > 0) {//التحقق اذا قاعدة البيانات تحوي كورسات او لا
        while($row = mysqli_fetch_array($result)) { //لوب يمر للمرور على كل كورس وعرض بياناته
            
        
            $course_title = mb_strtolower($row['title']);
            $course_image = "photo/it.jpg"; // الصورة الافتراضية العامة للـ IT

             //بحث ذكي يبجث عن هذه الكلمات في العنوان اذا موجودة يعرض صورة التخصص المطلوب
            if (strpos($course_title, 'قواعد') !== false || strpos($course_title, 'sql') !== false || strpos($course_title, 'database') !== false) {
                $course_image = "photo/Artboard_4-100.jpg"; // صورة قواعد البيانات
            } elseif (strpos($course_title, 'جرائم') !== false || strpos($course_title, 'أمن') !== false || strpos($course_title, 'cyber') !== false) {
                $course_image = "photo/it.jpg"; // صورة الجرائم المعلوماتية
            } elseif (strpos($course_title, 'وعي') !== false || strpos($course_title, 'معلومات') !== false) {
                $course_image = "photo/it2.jpg"; // صورة الوعي المعلوماتي
            }
    ?>
        
        <div class="offer-card">
            <div class="card-header">
                <a href="favorite.php?course_id=<?php echo $row['id']; ?>" class="favorite-icon">
                     ❤
                    </a> 
                <img src="<?php echo $course_image; ?>" alt="صورة الدورة">
            </div>

            <h3><?php echo $row['title']; ?></h3><!-- نطبع عنوان الكورس القادم من قاعدة البيانات -->
            <h6 class="description">
                <?php echo $row['description']; ?><!--نطبع وصف الكورس -->
            </h6>

           <div class="card-action">
    <a href="offer.php?id=<?php echo $row['id']; ?>" class="view-btn"><!-- ينقل المستخدم إلى صفحة تفاصيل الكورس -->
        عرض التفاصيل
    </a>
     </div>

    </div>

    <?php 
        } 
    } else {
        //رسالة تظهر اذا لم نقم باضافة كورسات لتقنية المعلومات من الادمن بعد 
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

<?php if(!isset($_SESSION['user_id'])) { ?>

<!-- سكريبت جافا للتحكم بالنافذة والمفضلة-->
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