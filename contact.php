<?php
    
    session_start();
    include('nav/nav.php'); 
    include('login/login.php'); 

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require 'vendor/autoload.php';

    function Send_contactus($name, $email, $phonenum, $message){
        $mail = new PHPMailer(true);

        $mail->isSMTP();                                                                
        $mail->SMTPAuth   = true;   

        $mail->Host       = 'smtp.gmail.com'; 
        $mail->Username   = 'magnifiqueeventsandco@gmail.com';                    
        $mail->Password   = 'imtyvdctjwkvlisv'; 
        
        $mail->SMTPSecure = "tls";            
        $mail->Port       = 587;

        $mail->setFrom('magnifiqueeventsandco@gmail.com', $name);
        $mail->addAddress('magnifiqueeventsandco@gmail.com');

        $mail->isHTML(true);
        $mail->Subject = "From: " .$email;

        $email_template = "Name: $name<br>
                        Contact Number: $phonenum<br>
                        Message: $message
        ";

        $mail->Body = $email_template;
        $mail->send();
        if($mail) {
            return true;
        }else {
            return false;
        }
    }


    if (isset($_POST['sendcontact'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phonenum = $_POST['phonenum'];
        $message = $_POST['message'];
        
        if (Send_contactus($name, $email, $phonenum, $message)) {
            echo '<script>alert("Your Message has been Sent!");</script>';
        }else {
            echo '<script>alert("Failed to Send Message!");</script>';
        }

    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/bg&icons/logo.png">
    <title>MAGNIFIQUE Events & Co.</title>

    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- css -->
    <link rel="stylesheet" href="css/contact.css">
    <link rel="stylesheet" href="css/screen.css">
    <!-- <link rel="stylesheet" href="css/sectionSize.css"> -->

</head>
<body>
    
    <div class="main-container">

        <section>
            <div class="contact-container">

                <div class="left">
                    <div class="top-text">
                        <h3>
                            Please fill out this form and we will get back to you shortly
                        </h3>
                    </div>

                    <form action="contact.php" method="post">

                        <div class="inputs-container">
                            <div class="input">
                                <label for="name"><p>Name</p></label><br>
                                <input type="text" id="name" name="name" required>
                            </div>
                            <div class="input">
                                <label for="email"><p>Email</p></label><br>
                                <input type="text" id="email" name="email" required>
                            </div>

                            <div class="input">    
                                <label for="number"><p>Contact Number</p></label><br>
                                <input type="number" name="phonenum" id="" required>
                            </div>

                            <div class="input">
                                <label for="message"><p>Type Your Message Here</p></label><br><br>
                                <div class="textarea-container">
                                    <textarea name="message" id="" cols="57" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                            <div class="submit-btn">
                                <button type="submit" name="sendcontact" id="submit">Submit</button>
                            </div>
                    </form>
                </div>

                <div class="right">

                    <div class="content">
                        <h2 style="color: white;">CONTACT US</h2>

                        <div class="logo">
                            <div class="img">
                                <img src="img/bg&icons/logo.png" alt="">
                            </div>
                            <p>
                                Turn your dream events into a reality.
                            </p>
                        </div>

                        <div class="soc-icons">
                            <i class="fa-brands fa-facebook-f" style="color: #ffffff;""></i>
                            <i class="fa-brands fa-instagram" style="color: #ffffff;"></i>
                            <i class="fa-regular fa-envelope" style="color: #ffffff;"></i>
                        </div>
                    </div>

                </div>

            </div>
        </section>
    
    </div>

    <?php include 'footer/footer.html'; ?>

</body>
</html>