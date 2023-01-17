<?php

if (isset($messag)) {
    foreach ($messag as $message) {
        echo '
            <div class="message">
                <span>'.$message.'</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
            ';
    }
}
?>

<header class="header">
    <div class="flex">
        <a href="admin_page.php" class="logo">Admin <span>Panel</span></a>
        <nav class="navbar">
            <a href="admin_page.php">home</a>
            <a href="admin_product.php">product</a>
            <a href="admin_order.php">order</a>
            <a href="admin_users.php">users</a>
            <a href="admin_contact.php">contact</a>

        </nav>
        <div class="icons">
            <div id="menu_btn" class="fas fa-bars"></div>
            <div id="user_btn" class="fas fa-user"></div>
        </div>
        <div class="profile">
            <?php
                $select_profile = $conn->prepare('select * from `users` where id = ?');
                $select_profile->execute([$admin_id]);
                $fetch_profile= $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
            <img src="uploads_img/<?= $fetch_profile['image']; ?>" alt="">
            <p><?=$fetch_profile['name']; ?></p>
            <a href="admin_update_profile.php" class="btn">update profile</a>
            <a href="logout.php" class="delete-btn">logout</a>
            <div class="flex-btn">
                <a href="login.php" class="option-btn">login now</a>
                <a href="register.php" class="option-btn">register now</a>
            </div>
        </div>
    </div>
</header>