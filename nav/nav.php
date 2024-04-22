<?php
    require_once "./admin_panel/backend.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require 'vendor/autoload.php';

    function Send_email_verify($name, $email, $verification_code){
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
                    } else {
                        header("Location: index.php?error=registration_failed");
                    }
            }
            }else {
                header("Location: facilities.php?error=wrong_verification_code");
            }
        }

        if (isset($_POST['signin'])) {
            $_SESSION['email'] = $_POST["email"];
            $_SESSION['password'] = $_POST["password"];
    
            $query = new AccountLogin($connect, $_SESSION['email'], $_SESSION['password']);
            $result = $query->loginAccount();
    
            if ($result) {
                $row = $result;
                $_SESSION['email'] = $row['email'];
                $role = $row['role'];
    
                if ($role === 0) {
                    $_SESSION['type'] = "admin";
                    unset($_SESSION['email']);
                    unset($_SESSION['password']);
                    header("Location: ./admin_panel/admin.php");
                }else{
                    $_SESSION['type'] = 'user';
                    $_SESSION['UID'] = $row['accountID'];
                    $_SESSION['login_email'] = $row['email'];
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

    <!-- Boxiocns CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/pop.css">
    
    <!-- ajax -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Include SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

</head>
<body>

  <!-- Include SweetAlert2 library -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <header>
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

                <?php if (isset($_SESSION['UID'])) { ?> 
                    <li class="list-items mobile">
                        <a href="#" class="nav-link"onclick="openPopup('reservation')">
                            <i class="fa-solid fa-list"></i>
                            <span class="link-name" style="--i:6">RESERVATION</span>
                        </a>
                    </li>
                    <li class="list-items mobile">
                        <a href="#" class="nav-link" onclick="openPopup('logout')">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span class="link-name" style="--i:7">LOGOUT</span>
                        </a>
                    </li>
                <?php } ?>

                <!-- desktop buttons -->
                <li class="header-btn-container">
                    <?php if (isset($_SESSION['UID'])) { ?>                   
                        <button class="header-btn account" onclick="openPopup('accountSetting')">
                            <ion-icon name='person-circle-outline'></ion-icon>                      
                        </button>
                        <span class="header-btn account">Account</span>
                    <?php } else {?>
                        <button id="show-login" class="header-btn login">
                            <span class="text">Login</span>
                        </button>
                    <?php } ?>

                    <div class="account-option"  id="accountOption"> 
                        <div class="account-btn">
                            <button onclick="openPopup('reservation')"><i class='bx bx-receipt'></i>Reserved</button>
                        </div>
                        <div class="account-btn">
                            <button onclick="openPopup('logout')"><i class='bx bx-log-out'></i>Logout</button>
                        </div>
                    </div>
                </li>

            </ul>
        </nav>

        <?php
            if (isset($_SESSION['UID'])) {
                $result = $query->selectALLreservation($_SESSION['UID']);
        ?>

        <div id="popup-reservation" class="popup-reservation">

            <center><h2>reservations</h2></center>

            <ul class="reservation-container">
                <?php 
                $count = 0;
                while ($row = mysqli_fetch_assoc($result)) { ?>

                    <a href="#" class="more-info-trigger" data-rid="<?php echo $row['RID']; ?>">
                        <li class="reservation-list">
                            <ul class="list-info-container">
                                <li><?php echo ++$count; ?></li>
                                <li><?php echo $row['customername'];?></li>
                                <li><?php echo $row['packagename'];?></li>
                                <li><?php echo $row['bookingdate'];?></li>
                                <li>
                                <?php
                                    if (isset($row['reservationstatus']) && $row['reservationstatus'] == 'pending') {
                                        echo "pending";
                                    } else {
                                        echo "Approved";
                                    }
                                ?>
                                </li>
                            </ul>
                        </li>
                    </a>

                <?php } ?>
            </ul>
            <div class="reservation-close">
                <button onclick="closePopup()">Close</button>
            </div>
        </div>

        <?php } ?>

        <div id="overlay" class="overlay"></div>

    </header>

    <script>
        function openSearch(open) {
            if (open = true) {
                document.querySelector('.header-search.mobile').classList.toggle("active");
            }
        }

        function openPopup(action) {
            var title, content;
            if (action === 'reservation') {        
                document.getElementById('popup-reservation').style.display = 'block';
                document.getElementById('overlay').style.display = 'block';

            } else if (action === 'logout') {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You will be logged out!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, logout!'

                }).then((result) => {
                    if (result.isConfirmed) {
                    window.location.href='<?php echo "index.php?logout=true"?>';
                    //alert("Logout successful!"); // For demonstration, you can replace this with actual logout action
                    }
                })
            } else if (action = 'accountSetting') {
                document.getElementById('accountOption').classList.toggle("active");
            } 
        }

        function closePopup() {
            document.getElementById('popup-reservation').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }
    </script>

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

    <!-- ionicon link -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>
</html>