<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- كود الهيدر -->

   <header class="navbar"> <!-- كلاس حطيناه في CSS عشان التنسيق -->
    
    <div class="logo-box"> <!-- هنا قسم اللوقو فيه صورة ونص -->
        
        <img src="photo/logo2.png" class="logo-img">

        <span class="logo-text"> <!-- نص جنب اللوقو -->

            <span class="part1">Devora</span>
            <span class="part2">course</span>

        </span>
    </div>

    <!-- قسم البحث -->

    <div class="search-box">

        <form action="Home.php" method="GET"
        style="display: flex; align-items: center; width: 100%; height: 100%;">

            <img src="photo/search1.png" class="search-icon">

            <input
                type="text"
                name="search"
                placeholder="Search for courses..."
                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
            >

            <button type="submit" class="search-button">
                Search
            </button>

        </form>
    </div>

    <div class="nav-left">

        <span class="home-pos">

            <!-- زر الهوم -->

            <a href="Home.php" class="nav-home">
                <img src="photo/HOME2.png" class="home-icon">
            </a>

            <a href="Home.php" class="nav-home">
                <span class="nav-item">Home</span>
            </a>

        </span>

        <!-- فاصل بين زر الهوم والبروفايل -->

        <span class="divider"></span>

        <!-- قسم البروفايل -->

       <span id="profileBtn" class="Profile"
     <?php if(isset($_SESSION['user_id'])) { ?>
    onclick="window.location.href='my-account.php'"
    <?php } ?>
>
    <img src="photo/profile1.png" class="profile-icon">
    <span class="nav-item">Profile</span>
    </span>

    </div>

</header>

