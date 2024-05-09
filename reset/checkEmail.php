
<?php require_once("../includes/config.php");
require_once("../includes/classes/Account.php");


?>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST["send_link"])){
    $email = $_POST["email"];

    //Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function


require 'Mail/Exception.php';
require 'Mail/PHPMailer.php';
require 'Mail/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
                        //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'braudeflixwatch@gmail.com';                     //SMTP username
    $mail->Password   = 'uhny mkpx nozf myjg';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('braudeflixwatch@gmail.com', 'BraudeFlix');
    $mail->addAddress($email);     //Add a recipient

    $code = Account::generateRandomString();

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Password Reset';
    $mail->Body = 'To reset your password, click <a href="http://localhost/braudeflix/reset/resetPassword.php?code='.urlencode($code).'&email='.urlencode($email).'">here</a>.<br>Reset your password within a day.';




    $query = $con->prepare("SELECT * FROM users WHERE email=:email");
    $query->bindValue(":email",$email);
    $query->execute();

    if($query->rowCount() == 1){
        $codeQuery = $con->prepare("UPDATE users SET code=:code WHERE email = :email");
        $codeQuery->bindValue(":email",$email);
        $codeQuery->bindValue(":code",$code);
        $codeQuery->execute();
        $mail->send();
        $success = '<span style="width:100%,padding:10px;background-color:lightgreen;border-radius:30px">Message has been sent,Check your email!</span>';
    }else{
        $error =  "<span style='width:100%;background:red;padding:10px;border-radius:30px'>Message could not be sent.your email is not exist!</span>";
    }

} catch (Exception $e) {
    $error =  "<span style='width:100%;background:red;padding:10px;border-radius:30px'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</span>";
}

}else{
    
}



?>
<!DOCTYPE html>
<html>
    <head>
        <title>forgotPassword</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

        <link rel="stylesheet" type="text/css" href="../assets/style/style.css" />
    </head>
    <body>
        
        <div class="signInContainer">

            <div class="column">

                <div class="header">
                    <img src="../assets/images/logo.png" title="Logo" alt="Site logo" />
                    <h3>forgotPassword</h3>
                    <span>Click Your Email</span>
                </div>
                <!-- Message & error -->
                
                <form method="POST">
                    <?php if($success){echo $success;} ?>
                    <?php if($error){echo $error;} ?>
                    <input type="email" name="email" placeholder="Email" required>

                    <input type="submit" name="send_link" value="Send Link">

                </form>

                <a href="../login.php" class="signInMessage">LogIn</a>
            </div>

        </div>
    
    </body>
</html>