window.onload = function() {
    var form = document.getElementById('registrationForm');

    if (form) {
        form.onsubmit = function(event) {
            // تفريغ الرسائل عند كل محاوله جديده 
            var userError = document.getElementById('userError');
            var emailError = document.getElementById('emailError');
            var passError = document.getElementById('passError');
        

            // تفريغ النصوص القديمة
            userError.innerText = "";
            emailError.innerText = "";
            passError.innerText = "";
            

            // 2. اجيب القيم التي كتبها المستخدم
            var user = document.getElementById('fullname').value;
            var email = document.getElementById('email').value;
            var pass = document.getElementById('password').value;
            

            var isValid = true; // متغير لحالة النموذج

            // 3. التحقق من اسم المستخدم
            if (user.trim() === "") {
                userError.innerText = "Please enter a username.";
                isValid = false;
            }

            // التحقق من البريد الإلكتروني
            if (email.indexOf("@") === -1 || email.indexOf(".") === -1) {
                emailError.innerText = "Incorrect email address.";
                isValid = false;
            }

            // التحقق من كلمة المرور
            if (pass.length !== 8) {
                passError.innerText = "The password must be exactly 8 characters long.";
                isValid = false;
            }
         
    

    
            if (!isValid) {
                // ما نرسل  إذا فيه خطأ
                event.preventDefault();
           } else {
        // نخلي الفورم ينرسل للـ PHP عشان يحفظ في قاعدة البيانات
         return true;
      }
        };
    }
};

// دالة إغلاق النافذة  
function closeModal() {
    document.getElementById('successModal').style.display = 'none';
    window.location.href = "Home.php"; // التوجه للرئيسية بعد النجاح
}
