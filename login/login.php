<?php
    require_once "./admin_panel/backend.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require 'vendor/autoload.php';

    function Send_email_verify($name, $email,  $verification_code){
        $mail = new PHPMailer(true);

        $mail->isSMTP();                                                                
        $mail->SMTPAuth   = true;   

        $mail->Host       = 'smtp.gmail.com'; 
        $mail->Username   = 'magnifiqueeventsandco@gmail.com';                    
        $mail->Password   = 'imtyvdctjwkvlisv'; 
        
        $mail->SMTPSecure = "tls";            
        $mail->Port       = 587;

        $mail->setFrom('magnifiqueeventsandco@gmail.com', $name);
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = "Email Verification from  Magnifique Events & Co.";

        $email_template = "
            <h2>You have Registered with Magnifique Events & Co.</h2>
            <h5>Here is your Verification code:</h5> <h4>$verification_code</h4>
        ";

        $mail->Body = $email_template;
        $mail->send();
        // if($mail) {
        //     return true;
        // }else {
        //     return false;
        // }
    }

    $connect = new Connect_db();
    $query = new Queries($connect);

    // sa kwan to e sign up
        if (isset($_POST['signup'])) {
            $name = $_POST["name"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $verification_code = substr(bin2hex(random_bytes(3)), 0, 6);

            Send_email_verify("$name", "$email",  "$verification_code");

            $_SESSION['verification'] = $verification_code;
            $_SESSION['name'] = $name ;
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;

        }

        if (isset($_POST['verify'])) {
            $usercode = $_POST['user_code'];
            
            if ($usercode === $_SESSION['verification']) {

                $query = new Accounts($connect,$_SESSION['name'], $_SESSION['email'], $_SESSION['password']);

                if ($query->checkIfUserExists()) {
                    header("Location: facilities.php?error=email_exist");
                }
                else {
                    if ($query->createAccount() ) {
                        unset($_SESSION['name']);
                        unset($_SESSION['email']);
                        unset($_SESSION['password']);
                        unset($_SESSION['verification']);
                        header("Location: index.php?success=account_created");
                    }else {
                        header("Location: index.php?error=registration_failed");
                    }
            }
            }else {
                header("Location: facilities.php?error=wrong_verification_code");
            }
        }

        if (isset($_POST['signin'])) {
            $email = $_POST["email"];
            $password = $_POST["password"];
    
            $query = new AccountLogin($connect, $email, $password);
            $result = $query->loginAccount();
    
            if ($result) {
                $row = $result;
                $_SESSION['email'] = $row['email'];
                $role = $row['role'];
    
                if ($role === 0) {
                $_SESSION['type'] = "admin";
                    header("Location: ./admin_panel/admin.php");
                }else{
                    $_SESSION['type'] = 'user';
                    $_SESSION['UID'] = $row['accountID'];
                    header("Location: index.php?success=logged_in");
                }
                
            }else {
                header("Location: index.php?error=invalid_email_or_password");
            }
        }

        
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- css -->
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/pop.css">
</head>
<body>    
    <div class="pop-up login">

        <div class="container" id="container">
            <div class="close-btn"><span>&times</span></div>
            <div class="form-container sign-up">
                <div class="logo-title">
                    <img src="img/bg&icons/logo.png" alt="logo">
                    <div class="title">
                        <h2>MAGNIFIQUE</h2>
                        <span>
                            EVENTS & CO.
                        </span>
                    </div>
                </div>
                    <?php if (!isset($_POST['signup'])) {  ?>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                            <h1>Create account</h1>
                            <div class="social-icons">
                                <a href="">
                                    <i class="fa-brands fa-google"></i>
                                </a>
                                <a href="">
                                    <i class="fa-brands fa-facebook"></i>
                                </a>
                                <a href="">
                                    <i class="fa-brands fa-github-alt"></i>
                                </a>
                            </div>
                            <span>
                                or use your email for registration
                            </span> 
                            <input type="text" name="name" placeholder="Name" required />
                            <input type="email" name="email" placeholder="Email" required />
                            <input type="password" name="password" placeholder="Password" required/>
                            <button type="submit" name="signup">Sign Up</button>
                        </form>
                    <?php } else{?>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                            <h1>Create account</h1>
                            <div class="social-icons">
                                <a href="">
                                    <i class="fa-brands fa-google"></i>
                                </a>
                                <a href="">
                                    <i class="fa-brands fa-facebook"></i>
                                </a>
                                <a href="">
                                    <i class="fa-brands fa-github-alt"></i>
                                </a>
                            </div>
                            <span>
                                verify  your account by entering the code sent to your email.
                            </span> 
                            <input type="text" name="user_code" placeholder="code" required />
                            
                            <button type="submit" name="verify">Verify</button>
                        </form>
                    <?php } ?>
            </div>
    
            <div class="form-container sign-in">
                <div class="logo-title">
                    <img src="img/bg&icons/logo.png" alt="logo">
                    <div class="title">
                        <h2>MAGNIFIQUE</h2>
                        <span>
                            EVENTS & CO.
                        </span>
                    </div>
                </div>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <h1>Sign In</h1>
                    <div class="social-icons">
                        <a href="">
                            <i class="fa-brands fa-google"></i>
                        </a>
                        <a href="">
                            <i class="fa-brands fa-facebook"></i>
                        </a>
                        <a href="">
                            <i class="fa-brands fa-github-alt"></i>
                        </a>
                    </div>
                    <span>
                        or use your email paswword
                    </span> 
                    <input type="email" name="email" placeholder="Email" required />
                    <input type="password" name="password" placeholder="Password" required/>
                    <a href="">
                        forgot your password?
                    </a>
                    <button type="submit" name="signin">Sign In</button>
                </form>
            </div>
    
            <div class="toggle-container">
                <div class="toggle">
    
                    <div class="toggle-panel toggle-left">
                        <h1>Welcome Back!</h1>
                        <p>
                            Already have an account?
                        </p>
                        <button class="hidden" id="login">Sign In</button>
                    </div>
    
                    <div class="toggle-panel toggle-right">
                        <h1>New Here?</h1>
                        <p>
                            Sign up and discover a great amount of opportunities.
                        </p>
                        <button class="hidden" id="register">Sign Up</button>
                    </div>
    
                </div>
            </div>
        </div>
        
    </div>

    <script src="js/script.js"></script>


</body>
</html>