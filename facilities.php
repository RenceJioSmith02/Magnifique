<?php

    session_start();
    require_once "./admin_panel/backend.php";
    
    $connect = new Connect_db();
    $query = new Queries($connect);

    if (isset( $_GET["logout"])) {
        session_destroy();
        header("Location: index.php");
    }
    if (isset($_SESSION['UID']) && ($query->checkUserExist($_SESSION['UID']) <= 0)) {
        session_destroy();
        header("Location: index.php");
    }
    if (isset($_SESSION['type']) && $_SESSION['type'] == 'admin') {
        header("Location: ./admin_panel/admin.php");
    }
    
    include('nav/nav.php');
    include('login/login.php'); 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/bg&icons/logo.png">
    <title>MAGNIFIQUE Events & Co.</title>
    <link rel="stylesheet" href="css/facilities.css">
    <link rel="stylesheet" href="css/screen.css">
    <!-- <link rel="stylesheet" href="css/sectionSize.css"> -->

</head>
<body>
    
    <div class="main-container">

        <!-- top-img -->
        <section class="parallax-facility">
            <div class="parallax-inner">

            </div>
        </section>

        <!-- <section class="123"> -->
        <section id="one">
            <div class="facilities-container border">
            
                <div class="top-package-title">
                    <h2>Magnifique Gardens</h2>
                    <p>
                        Discover a variety of meticulously designed gardens at Magnifique, each with its own unique charm, perfect for setting the tone for your celebration. Choose the ideal ambiance to bring your envisioned event to life amidst our stunning garden settings.
                    </p>
                    <h2 class="details-text">Celebration Venues</h2>
                </div>

                <div class="box">
                    <div class="img">
                        <img src="img/venues/1.jpg" alt="image">
                    </div>
                    <div class="text">
                        <h2>01<br>Garden of Future</h2>
                        <i><p>Good for < 120 pax </p></i>
                        <br><br>
                        <p>
                            Our beautiful Garden of the future features a variety of plants and trees, along with the iconic arbor of flowers and foliage of Magnifique. The venue has already been naturally styled in our Garden.
                        </p>
                    </div>
                </div>
                <div class="box two">
                    <div class="img">
                        <img src="img/venues/2.jpg" alt="image">
                    </div>
                    <div class="text">
                        <h2>02<br>Garden of your Dreams</h2>
                        <i><p>Good for < 150 pax </p></i>
                        <br><br>
                        <p>
                            Our enchanting Garden of the Dreams is adorned with a diverse array of plants and trees, emphasizing coconut trees, lending a beach-like atmosphere. Enhanced by whimsical lights, the venue is naturally styled to captivate a magical setting for their celebration.
                        </p>
                    </div>
                </div>
        
            </div>
        </section>

        <section id="two">
            <div class="facilities-container border">

                <div class="box">
                    <div class="img">
                        <img src="img/venues/3.jpg" alt="image">
                    </div>
                    <div class="text">
                        <h2>03<br>Poolside</h2>
                        <i><p>Good for < 120 pax </p></i>
                        <br><br>
                        <p>
                            Indulge in luxury at our poolside venue, where elegance meets relaxation. Surrounded by refreshing and stylish lounging areas, it's the perfect setting for daytime leisure or evening gatherings.
                        </p>
                    </div>
                </div>
                <div class="box two">
                    <div class="img">
                        <img src="img/venues/4.jpg" alt="image">
                    </div>
                    <div class="text">
                        <h2>04<br>Poolside Oasis</h2>
                        <i><p>Good for < 150 pax </p></i>
                        <br><br>
                        <p>
                            Experience an idyllic retreat, where lush foliage and shimmering waters converge to offer a picturesque backdrop for your event. This serene space invites guests to bask in tranquility, surrounded by the natural allure of their surroundings.
                        </p>
                    </div>
                </div>
        
            </div>
        </section>

        <section id="three">
            <div class="facilities-container">

                <div class="box">
                    <div class="img">
                        <img src="img/venues/5.jpg" alt="image">
                    </div>
                    <div class="text">
                        <h2>05<br>Function Hall </h2>
                        <i><p>Good for < 120 pax </p></i>
                        <br><br>
                        <p>
                            Discover the epitome of elegance in our function hall. This versatile space offers a refined setting for a wide range of events, from weddings to corporate gatherings, ensuring every occasion is truly memorable.
                        </p>
                    </div>
                </div>
                <div class="box two">
                    <div class="img">
                        <img src="img/venues/6.jpg" alt="image">
                    </div>
                    <div class="text">
                        <h2>06<br>Banquet Hall</h2>
                        <i><p>Good for < 150 pax </p></i>
                        <br><br>
                        <p>
                            A luxurious venue designed to host elegant events with style and sophistication. Whether it's a wedding, corporate gala, or special celebration, our banquet hall offers a grand setting to make your occasion unforgettable.
                        </p>
                    </div>
                </div>
                <br><br>

                <div class="reserveBTN-container">
                    <button class="reservation-btn" onclick="location.href='contact.php'">Get in touch with us</button>
                </div>

            </div>
        </section>

    </div>

    <?php include 'footer/footer.html'; ?>

</body>
</html>