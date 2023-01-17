<?php

use function PHPSTORM_META\elementType;

include 'config.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location:login.php');
}
if (isset($_POST['update_profile'])) {
    $name = htmlspecialchars($_POST['name']) ?? '';
    $email = htmlspecialchars($_POST['email']) ?? '';
    $update_profile = $conn->prepare("Update `users` set name = ? , email=? where id = ?");
    $update_profile->execute([$name, $email, $admin_id]);

    $permitted_extensions = ['png', 'jpg', 'jpeg', 'gif'];

    $image_name = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_extension = explode('.', $image_name);
    $image_extension = strtolower(end($image_extension));
    $image_folder = "uploads_img/" . $image_name;

    $old_img = htmlspecialchars($_POST['old_image']);
    if (!empty($image_name)) {
        if (in_array($image_extension, $permitted_extensions)) {
            if ($image_size > 2000000) {
                $messag[] = 'file size is too large';
            } else {
                $update_image = $conn->prepare("Update `users` set image = ?  where id = ?");
                $update_image->execute([$image_name, $admin_id]);
                if ($update_image) {
                    move_uploaded_file($image_tmp_name, $image_folder);
                    unlink('uploads_img/'.$old_img);
                    $messag[]='file uploaded successfully';
                }
            }
        }
    }
    $old_pass = htmlspecialchars($_POST['old_pass']);
    $update_pass = htmlspecialchars($_POST['update_pass']);
    $update_pass = md5($update_pass);
    $new_pass = htmlspecialchars($_POST['new_pass']);
    $new_pass = md5($new_pass);
    $confirm_pass = htmlspecialchars($_POST['confirm_pass']);
    $confirm_pass = md5($confirm_pass);

    if(!empty($update_pass) AND !empty($new_pass) AND !empty($confirm_pass))
    {
        if($update_pass != $old_pass)
        {
            $messag[]='old password is not match';
        }else if($new_pass!=$confirm_pass)
        {
            $messag[]='new password is not match';
        }else{
            $update_password = $conn->prepare("Update `users` set password = ?  where id = ?");
            $update_password->execute([$confirm_pass, $admin_id]);
            $messag[]='password is updated successfully';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/components.css">
</head>

<body>
    <?php include 'admin_header.php' ?>
    <section class="update-profile">
        <h1 class="title">update profile</h1>
        <?php
        $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
        $select_profile->execute([$admin_id]);
        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <img src="uploads_img/<?= $fetch_profile['image']; ?>" alt="">
            <div class="flex">
                <div class="inputBox">
                    <span>username</span>
                    <input type="text" name="name" value="<?= $fetch_profile['name'] ?>" id="" placeholder="update username ..." class="box" >
                    <span>email</span>
                    <input type="text" name="email" value="<?= $fetch_profile['email'] ?>" id="" placeholder="update email ..." class="box" >
                    <span>update pic</span>
                    <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" id="" class="box" >
                </div>
                <div class="inputBox">
                    <input type="hidden" name="old_pass" value="<?= $fetch_profile['password'] ?>">
                    <input type="hidden" name="old_image" value="<?= $fetch_profile['image'] ?>">
                    <span>old password</span>
                    <input type="password" name="update_pass" placeholder="enter previous password" class="box" >
                    <span>new password</span>
                    <input type="password" name="new_pass" placeholder="enter new pass " class="box" >
                    <span>confirm password</span>
                    <input type="password" name="confirm_pass" placeholder="enter cofirm pass " class="box" >
                </div>
            </div>
            <div class="flex-btn">
                <input type="submit" value="update profile" name="update_profile" class="btn">
                <a href="admin_page.php" class="option-btn">go back</a>
            </div>
        </form>
    </section>






















    <script src="./assets/js/script.js"></script>
</body>

</html>