
<?php
include 'db.php'; 
// بداية جزء ال edit
$edit_mode = false; // نشوف إذا الصفحة بوضع التعديل
$course_data = null; //تخزين بيانات الكورس المطلوب تعديله

if (isset($_GET['edit'])) { //يشوف اذا المستخدم ضغط زر Edit
    $edit_mode = true;
    // نشوف اي رقم كورس (id)
    $id = $_GET['edit'];
    $edit_query = mysqli_query($conn,
    
    //استعلام بيانات الكورس المطلوب تعديله
    "SELECT * FROM course WHERE id = $id"); 
    //حفظ البيانات داخل متغير عشان تنعرض بالفورم
    $course_data = mysqli_fetch_assoc($edit_query);
}

// كود الحذف Delete 
if (isset($_GET['delete'])) { //يشوف اذا المستخدم ضغط زر Delete
    //على حسب ال id يحذف الكورس من قاعدة البيانات
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM course WHERE id = $id");

    header("location: admin.php"); // تحديث الصفحة بعد الحذف
}

// كود حفظ البيانات
if (isset($_POST['save_course'])) {//يشوف اذا المستخدم ضغط زر save
   //حماية البيانات من الاختراق
$name = mysqli_real_escape_string($conn, $_POST['course_name']);
$desc = mysqli_real_escape_string($conn, $_POST['course_desc']);
    
//يختار رقم التخصص على حسب ال id
$major_id = $_POST['major_id'];

//بعد ما حفظنا ينضاف لقاعدة البيانات
$sql = "INSERT INTO course (title, description, major_id) VALUES ('$name', '$desc', '$major_id')";
    if (mysqli_query($conn, $sql)) {
        //اذا انحفظ تظهر رسالة النجاح 
        echo "<script>alert('Saved!'); window.location.href='admin.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

//كود ال update
if (isset($_POST['update_course'])) {//يشوف اذا المستخدم ضغط زر update
   //على حسب ال id يجيب الكورس
    $id = $_GET['edit'];
    // جلب الاسم والوصف الجديده الي عدلناها
    $name = mysqli_real_escape_string($conn,$_POST['course_name']);
    $desc = mysqli_real_escape_string($conn, $_POST['course_desc']);
    //نروح لقاعده البيانات ونعدل الكورس
    mysqli_query($conn,"UPDATE course SET title='$name', description='$desc'
    WHERE id=$id");
   // إعادة تحميل للصفحة بعد التعديل
    header("location: admin.php");
}

// سطر يجيب لنا كل تفاصيل الكورس
$result = mysqli_query($conn, "SELECT * FROM course ORDER BY id DESC");

// كود جلب عدد الكورسات يعني يجيب لنا ال id بس 
$count_res = mysqli_query($conn, "SELECT id FROM course");
//هنا نحسب كم كورس موجود عندنا
$total = mysqli_num_rows($count_res);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <link rel="stylesheet" href="style.css"> 
    <img src="photo/logo2.png" class="home-icon">
    
</head>
<body>
    <!--تضمين كود الهيدر والمنيو -->
<?php include 'header.php'; ?>
<?php include 'menu.php'; ?>
            <!--ينشئ بوكس يعرض احصائية لعدد الكورسات-->
       <div class="stats-box">
        <p>Total Courses</p><!--يعرض عنوان الاحصائية-->
        <h1><?php echo $total; ?></h1><!-- يعرض العدد الكلي للكورسات -->
    </div>
  
    <div class="form-box"><!--حاوية تحتوي على فورم الاضافة والتعديل -->
        <h2>Add New Course</h2>
        <form method="POST"><!-- نموذج لاضافة او تعديل الكورسات يرسل البيانات باستخدام بوست لاخفائها وحمايتها  -->
            <input type="text" name="course_name" 
            
            placeholder="Course Name"value="<?php 
            if($edit_mode){echo $course_data['title'];} //اذا الصفحة في وضع التعديل يكون الكورس اسم الكورس القديم جوا الحقل عشان نشوف البيانات القديمة ونعدلها
            ?>" required>
        <!--ننشئ قائمة منسدلة للتخصصات-->
            <select name="major_id" required style="width: 100%; padding: 10px; margin-bottom: 15px;">
    <option value="">-- Select Major --</option>
    <?php
    // استعلام لجلب جميع التخصصات من جدول التخصصات 
    $majors_query = mysqli_query($conn, "SELECT * FROM major");
    //لوب تطبع لي التخصصات داخل قائمة منسدلة
    while($m = mysqli_fetch_array($majors_query)) {
        echo "<option value='".$m['id']."'>".$m['title']."</option>";
    }
    ?>
</select>
           <textarea name="course_desc" placeholder="Course Description" required>
            <?php if($edit_mode){ echo $course_data['description']; }//حقل لكتابة وصف الكورس
?></textarea>
            <?php if($edit_mode){ ?>

<button type="submit" name="update_course"><!--اذا الصفحة في مود التعديل زر يرسل البيانات المدخلة لتحديث الكورسات-->
Update Course
</button>

<?php } else { ?>
<!--اذا ماكانت في وضع التعديل يعرض زر الحفظ-->
<button type="submit" name="save_course"><!--زر الحفظ يرسل البيانات لاضافة كورس جديد-->
Save Course
</button>

<?php } ?>
        </form>
    </div>
    <div class="table-container"><!--حاوية لعرض الكورسات في جدول-->
    <h2>Existing Courses</h2>
    <table>
        <thead>
         <!--اعمدة الجدول-->
            <tr>
                <th>ID</th>
                <th>Course Name</th>
                <th>Description</th>
                <th>Edit</th>
                <th>Delete</th>
                <th>Major ID</th>
            </tr>
        </thead><!--تحدد وين تظهر بيانات الكورسات-->
        <tbody>
        <!--لوب يمر على كل الكورسات المرسلة من قاعدة البيانات-->
            <?php while($row = mysqli_fetch_array($result)) { ?>
            <tr><!--انشاء صف لكل كورس وكل كورس يحتوي هذه الاشياء-->
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td>
                    
    <a href="admin.php?edit=<?php echo $row['id']; ?>"><!--لما نضغط عليه في الصفحة تتحمل وينقلنا لوضع التعديل لكورس معين عبر رقم الكورس-->
        Edit
    </a>
</td>
                <td>
                <!-- يرسل رقم الكورس الي نبغا نحذفه مع رسالة تأكيد--> 
    <a href="admin.php?delete=<?php echo $row['id']; ?>"
       onclick="return confirm('Are you sure?')" 
       style="color: red; text-decoration: none;">Delete</a>
</td>
<td><?php echo $row['major_id']; ?></td><!--عرض رقم التخصص المرتبط بالكورس-->
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</body>
<!--تضمين الفوتر-->
<?php include 'footer.php'; ?>
</html>