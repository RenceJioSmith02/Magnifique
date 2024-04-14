<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/bg&icons/logo.png">
    <title>MAGNIFIQUE Events & Co.</title>
    

    <!-- css -->
    <link rel="stylesheet" href="css/homepage.css">
    <link rel="stylesheet" href="css/screen.css">

    <!-- <style>
        /* SECTION SIZE */
        @media screen and (max-width: 870px) {
            section {
                position: relative;
                left: 30px;
                width: calc(100% - 50px);
            }
        }
    </style> -->

</head>
<body>

    <div class="main-container">
        <header>
            <?php 
            include('login/login.php'); 
            include('nav/nav.html'); 
            ?>
        </header>

        <section class="view1">
            <div class="container1">
                <h1>EVENT BOOKING</h1>
                <p>
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Molestiae, nihil autem sunt, cupiditate voluptatum aut excepturi facilis voluptatem voluptate corrupti laudantium magni inventore saepe illum assumenda aperiam, voluptatibus adipisci voluptas.
                </p>
            </div>
        </section>

        <section id="view2" class="view" style="max-height: 2000px; height: fit-content;">
            <div class="view2">
                <!-- sticky image -->
                <div class="container1">    
                    <div class="img">
                        
                    </div>
                </div>
                    
                <div class="container2">
                    <div class="c2-text">
                        <p style="text-align:center;">
                            Have you ever envisioned stepping into a world where every celebration is a masterpiece? 
                        </p>
                        <h3>WELCOME TO</h3>
                        <div class="title">
                            <h2>MAGNIFIQUE</h2><span>Events & co.</span>
                        </div>
                        <p>
                            Your journey to the perfect event starts here, where enchantment and elegance converge to craft unforgettable moments. 
                            <br><br>
                            Discover our exclusive venues with tailored packages and reliable partners, we guarantee flawless execution of every event detail, allowing you to immerse yourself in the elegance and refined luxury of MAGNIFIQUE.
                        </p>
                    </div>

                    <div class="images">
                        <center><h3>Why Celerate with MAGNIFIQUE?</h3></center>
                        <div class="content">
                            <img src="img/home/1.png" alt="">
                            <div class="text">
                                <p>
                                    <strong>Offers Multiple Venues</strong>
                                    <br><br>
                                    Discover venue options customized suit to your preferred theme
                                </p>
                            </div>
                        </div>
                        <div class="content">
                            <img src="img/home/3.png" alt="">
                            <div class="text">
                                <p>
                                    <strong>Flexible Payment Terms</strong>
                                    <br><br>
                                    Manage your transaction effortlessly by offering adaptable payment options tailored to your convenience
                                </p>
                            </div>
                        </div>
                        <div class="content">
                            <img src="img/home/2.png" alt="">
                            <div class="text">
                                <p>
                                    <strong>Customized Packages</strong>
                                    <br><br>
                                    designed to reflect your style, ensuring an unforgettable event experience
                                </p>
                            </div>
                        </div>
                        <div class="content">
                            <img src="img/home/4.png" alt="">
                            <div class="text">
                                <p>
                                    <strong>Additional Offers</strong>
                                    <br><br>
                                    Elevate your event with quality services and products, guaranteeing smooth coordination                     
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="view3" class="view">
            <?php  include 'homepage-sections/section3.html'; ?>
        </section>
        
        <section id="view-4" class="view">
            <div class="view4">
                <div class="container-package1">
                    <div class="content">
                        <h2 class="pack-title" style="color: white;">
                            PACKAGES
                        </h2>
            
                        <div class="logo">
                            <img src="img/bg&icons/logo.png" alt="">
                            <p class="pack-text">
                                Bring your dreams to life
                            </p>
                        </div>
            
                        <div class="discover-btn">
                            <button onclick="window.location.href = 'eventPackages.php';">DISCOVER</button>

                        </div>
                    </div>
                </div>
        
                <div class="container-package2"align="center">
                    <div class="img1"></div>
                </div>
            </div>
        </section>

        <section id="view5" class="view">
            <div class="view4">
                <div class="container-package2"align="center">
                    <div class="img2"></div>
                </div>
                <div class="container-package1">
                    <div class="content">
                        <h2 class="pack-title" style="color: white;">
                            FACILITIES
                        </h2>
            
                        <div class="logo">
                            <img src="img/bg&icons/logo.png" alt="">
                            <p class="pack-text">
                                Craft the celebration of your dreams.
                            </p>
                        </div>
            
                        <div class="discover-btn">
                            <button onclick="window.location.href = 'facilities.php';">DISCOVER</button>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <section id="view6" class="view">
            <div class="view4">
                <div class="container-package1">
                    <div class="content">
                        <h2 class="pack-title" style="color: white;">
                            LOCATION
                        </h2>
            
                        <div class="logo">
                            <img src="img/bg&icons/logo.png" alt="">
                        </div>
            
                        <div class="discover-btn">
                            <p class="pack-text" align="center">
                                Ilaya St.br
                                <br>
                                Sofitel Manila, Philippines
                                <br>
                                Tel: 0911 340 5642 | 0922 448 6440
                                <br>
                                <a href="https://mail.google.com/mail/u/0/#inbox" style="color:white;">magnifique.events@gmail.com</a>
                            </p>
                        </div>
                    </div>
                </div>
        
                <div class="container-package2"align="center">
                    <div class="map">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3861.811294456849!2d120.97909027487175!3d14.552781285927928!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c94502eda71b%3A0x420f2afc29f8ed64!2sSofitel%20Philippine%20Plaza%20Manila!5e0!3m2!1sen!2sph!4v1713096477517!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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