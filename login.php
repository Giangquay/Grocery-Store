<?php
    include 'config.php';
    $email='';
    session_start();
    if(isset($_POST['submit']))
    {
        $email = htmlspecialchars($_POST['email'])??'';
        $pass = htmlspecialchars($_POST['pass']) ?? '';
        $pass=md5($pass);

        $select = $conn->prepare("SELECT * FROM users WHERE `email`= ? AND `password`= ?");
        $select->execute([$email,$pass]);
        $row = $select->fetch(PDO::FETCH_ASSOC);
        if($select->rowCount()>0){
            if($row['user_type']=='admin')
            {

                $_SESSION['admin_id']=$row['id'];
                header('location:admin_page.php');

            }else if($row['user_type']=='user'){

                $_SESSION['user_id']=$row['id'];
                header('location:home.php');
            }else{
                $messag[]='not user found';
            }
        }else{
            $messag[]='incorrect email or password!';
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
    <form action="" method="post">
        <h3>login now</h3>
         
        <input type="text" name="email" class="box" placeholder="enter your email" required value="<?php echo $email ?>"> 
        <input type="password" name="pass" class="box" placeholder="enter your password" required>
        <input type="submit" value="register now" class="btn" name="submit">
        <p>don't have an account? <a href="register.php">Login now</a></p>
    </form>
</section>
</body>
</html>