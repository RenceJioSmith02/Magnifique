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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/pop.css">
</head>
<body>
    
    <nav class="sidebar">
        <div class="top-bar">
            <div class="logo-menu">
                <img src="img/bg&icons/logo-white.png" style="max-width: 60px; min-width: 50px;" alt="logo">
            </div>
            <i class="fa-solid fa-bars toggle-btn"></i>
        </div>

        <ul class="list">

            <li class="list-items">
                <a href="index.php" class="nav-link">
                    <i class="fa-solid fa-house"></i>
                    <span class="link-name" style="--i:1">HOME</span>
                </a>
            </li>
            <li class="list-items">
                <a href="eventPackages.php" class="nav-link">
                    <i class="fa-solid fa-cube"></i>
                    <span class="link-name" style="--i:2"> EVENT PACKAGES</span>
                </a>
            </li>
            <li class="list-items">
                <a href="facilities.php" class="nav-link">
                    <i class="fa-solid fa-house-circle-check"></i>
                    <span class="link-name" style="--i:3">FACILITIES</span>
                </a>
            </li>
            <li class="list-items">
                <a href="gallery.php" class="nav-link">
                    <i class="fa-solid fa-image"></i>
                    <span class="link-name" style="--i:4">GALLERY</span>
                </a>
            </li>
            <li class="list-items">
                <a href="contact.php" class="nav-link">
                    <i class="fa-solid fa-phone"></i>
                    <span class="link-name" style="--i:5">CONTACT US</span>
                </a>
            </li>
            <center>
                <?php if (isset($_SESSION['UID'])) { ?>
                        
                    <button class="show-login-btn">
                        <ion-icon name='person-circle-outline'></ion-icon>
                        <p class='header-action-label'>Account</p>
                    </button>

                <?php } else {?>

                    <button id="show-login" class="show-login-btn">
                        <span class="text">Login</span>
                    </button>

                <?php } ?>
            </center>

        </ul>
    </nav>

    <script>
        const sidebar = document.querySelector('.sidebar');
        const toggleBtn = document.querySelector('.toggle-btn');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });

        function handleClick() {
            sidebar.classList.remove('active');
            setTimeout(() => {
                window.location.href = event.target.href;
            }, 500);
        }

        const navItems = document.querySelectorAll('.list-items');
        navItems.forEach(item => {
            item.addEventListener('click', (e) => {
                const currentActiveItem = document.querySelector('.nav-link.active');
                if (currentActiveItem) {
                currentActiveItem.classList.remove('active');
                }
                e.target.closest('li').classList.add('active');
                localStorage.setItem('lastPage', e.target.closest('a').getAttribute('href'));
            });
        });

        window.onload = function() {
        const currentActiveItem = document.querySelector('.nav-link.active');
            if (currentActiveItem) {
                currentActiveItem.classList.remove('active');
            }
            const lastPage = localStorage.getItem('lastPage');
            if (lastPage) {
                const link = document.querySelector(`a[href="${lastPage}"]`);
                if (link) {
                link.closest('li').classList.add('active');
                }
            }
        };
    </script>


      <!-- 
    - ionicon link
    -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>
</html>