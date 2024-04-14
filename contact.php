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
        <header>
            <?php include 'nav/nav.html'; ?>
            <?php include 'login/login.php'; ?>
        </header>

        <section>
            <div class="contact-container">

                <div class="left">
                    <div class="top-text">
                        <h3>
                            Please fill out this form and we will get back to you shortly
                        </h3>
                    </div>

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
                            <input type="number" name="number" id="" required>
                        </div>

                        <div class="input">
                            <label for="message"><p>Type Your Message Here</p></label><br><br>
                            <div class="textarea-container">
                                <textarea name="" id="" cols="57" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="submit-btn">
                        <button type="submit" id="submit">Submit</button>
                    </div>
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

    <section class="footer">
        <?php include 'footer/footer.html'; ?>
    </section>

</body>
</html>