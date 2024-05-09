<?php
    require_once("../includes/classes/Account.php");
    require_once("../includes/config.php");
    if(isset($_GET["code"])){
        $code = $_GET["code"];
        $verifyQuery = $con->prepare("SELECT * FROM users WHERE code=:code
        AND updated_time >= NOW() - INTERVAL 1 DAY");
        $verifyQuery->bindValue(":code",$code);
        $verifyQuery->execute();
        if($verifyQuery->rowCount() == 0){
            header("Location: ../login.php");
            exit();
        }
        if(isset($_POST["chang"])){
            $password = $_POST["newPassword"];
            $password1 = $_POST["newPassword2"];
            $stmt = Account::validatePasswords2($password,$password1);
            if(!$stmt){
                $error = "<span style='width:100%,padding:10px;border-radius:30px,background-color:red;'>Your password is not match!!</span>";
                
            }else{
            $password = hash("sha512", $password);
            $changQuery = $con->prepare("UPDATE users SET password=:password WHERE email=:email");
            $changQuery->bindValue(":email",$email);
            $changQuery->bindValue(":password",$password);
            $changQuery->execute();
            header("Location: success.html");
            }
        }

    }


?>

<!DOCTYPE html>
<html>
    <head>
        <title>forgotPassword</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/style/style.css">
        <link rel="stylesheet" type="text/css" href="../assets/style/style.css" />
    </head>
    <body>
        
        <div class="signInContainer">

            <div class="column">

                <div class="header">
                    <img src="../assets/images/logo.png" title="Logo" alt="Site logo" />
                    <h3>forgotPassword</h3>
                    <span>Change Your Password</span>
                </div>
                <!-- Message & error -->
                <?php if($error){echo $error;} ?>
                <form method="POST">
                    <input type="password" name="newPassword" placeholder="Password" required>

                    <input type="password" name="newPassword2" placeholder="Confirm Password" required>
                    <input type="submit" name="chang" value="Reset">

                </form>

                
            </div>

        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    </body>
</html>