<?php
// الربط بقاعده البيانات 
include 'db.php'; 
// تضمين الهيدر و المينو
include 'header.php';     
include 'menu.php';       

// نتأككد من وجود رقم دوره و استقبالها من الرابط
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $course_id = $_GET['id'];

    // نجيب بيانات الدوره و نستخدم Prepared Statement لحمايه الموقع 
    $stmt = $conn->prepare("SELECT * FROM course WHERE id = ?");
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // نتحقق من وجود الدورة في قاعدة البيانات
    if ($result->num_rows > 0) {
        $course = $result->fetch_assoc();
        
    // تخزين بيانات الدورة مع حماية النصوص من XSS        
        $description = htmlspecialchars($course['description']);
        $level = htmlspecialchars($course['level']);
        $edraak_link = htmlspecialchars($course['link']); // رابط الدورة على موقع إدراك
        $image = htmlspecialchars($course['image']); // اسم الصورة
    // اذا كانت الدوره غير موجودة
        } else {
        echo "<div class='main-wrapper'><h2>عذراً، هذه الدورة غير متوفرة حالياً.</h2></div>";
        include 'footer.php';
        exit();
    }
    // اذا ما انرسل id في الرابط
} else {
    echo "<div class='main-wrapper'><h2>خطأ: لم يتم تحديد الدورة المطلوبة.</h2></div>";
    include 'footer.php';
    exit();
}
?>
<!-- بداية صفحة عرض الدورة -->
<div class="main-wrapper">
    <div class="form-card">
        
        <h1><?php echo $title; ?></h1>
        
        <span class="course-level">
            المستوى: <?php echo $level; ?>
        </span>

        <!-- عرض صورة الدورة إذا كانت موجودة -->
        <?php if(!empty($image)): ?>
            <div class="course-image-box">
                <img src="photo/<?php echo $image; ?>" alt="<?php echo $title; ?>">
            </div>
        <?php endif; ?>

        <div class="course-description">
            <h3>عن هذه الدورة التدريبية</h3>
            <p><?php echo $description; ?></p>
        </div>

        <a href="<?php echo $edraak_link; ?>" target="_blank" class="view-btn">
       ابدأ الدورة
       </a>

    </div>
</div>

<?php
//  تضمين الفوتر لإنهاء الصفحة 
include 'footer.php';
?>