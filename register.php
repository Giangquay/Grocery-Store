<?php
https://github.com/Giangquay/PHP-grocery_store-.git
include 'config.php';
 $name="";
 $email="";
if (isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['name']) ?? '';
    $email = htmlspecialchars($_POST['email']) ?? '';
    $pass = htmlspecialchars($_POST['pass']) ?? '';
    $pass=md5($pass);
    $cpass = htmlspecialchars($_POST['cpass']) ?? '';
    $cpass=md5($cpass);
    //File uploads_img
    $permitted_extensions=['png', 'jpg', 'jpeg', 'gif'];

    $image_name = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_extension=explode('.',$image_name);
    $image_extension=strtolower(end($image_extension));
    $image_folder = "uploads_img/".$image_name;
    //tester input
    $select = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select->execute([$email]);
    if ($select->rowCount() > 0) {
        $messag[] = 'user email already exists!';
    } else {
        if ($pass != $cpass) {
            $messag[] = 'confirm password not matched !';
        }else{
            //insert `users`
            $insert = $conn->prepare("Insert into `users`(name,email,password,image)
            values(?,?,?,?)");
            $insert->execute([$name,$email,$pass,$image_name]);
            if($insert)
            {
                if(in_array($image_extension,$permitted_extensions))
                {
                    if($image_size<1000000)
                    {
                        move_uploaded_file($image_tmp_name,$image_folder);
                        $messag[]='registed successfully';
                    }else{
                        $messag[]='File name is too big';
                    }
                }
            }
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
    <title>register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/components.css">
</head>

<body>

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
    <section class="form-container">
        <form action="" enctype="multipart/form-data" method="post">
            <h3>register now</h3>
             
            <input type="text" name="name" class="box" placeholder="enter your name" required value="<?php echo $name;?>">
            <input type="email" name="email" class="box" placeholder="enter your email" required>
            <input type="password" name="pass" class="box" placeholder="enter your password" required>
            <input type="password" name="cpass" class="box" placeholder="confirm your password" required>
            <input type="file" name="image" class="box" required accept="image/jpg, image/ipeg, image/png">
            <input type="submit" value="register now" class="btn" name="submit">
            <p>already have an account? <a href="login.php">login now</a></p>
        </form>
    </section>
</body>

</html>