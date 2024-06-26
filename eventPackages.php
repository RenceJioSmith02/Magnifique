<?php
    
    session_start();
    require_once "./admin_panel/backend.php";

    $connect = new Connect_db();
    $query = new Queries($connect);

    // sessions

    if (isset( $_GET["logout"])) {
        session_destroy();
        header("Location: index.php");
    }
    if (isset($_SESSION['UID']) && ($query->checkUserExist($_SESSION['UID']) <= 0)) {
        session_destroy();
        header("Location: index.php");
    }
    include('nav/nav.php'); 
    include('login/login.php'); 

    if (isset($_SESSION[ 'UID' ])) {
        $accountID = $_SESSION[ 'UID' ];
    }

    if (isset($_POST['reserve'])) {
        $name = $_POST['name'];
        $phonenum = $_POST['phonenum'];
        $package = $_POST['package'];
        $eventdate= $_POST['eventdate'];
        $eventtime = $_POST['eventtime'];
        $venue = $_POST['venue'];
        $numofguest = $_POST['numofguest'];
        $description = $_POST['description'];
        $cardname = $_POST['cardname'];
        $cardtype = $_POST['cardtype'];
        $cardnumber = $_POST['cardnumber'];
        $dateofpayment = $_POST['paymentdate'];
        $paymenttype = $_POST['paymenttype'];
        $amount = $_POST['amount'];

        switch ($package) {
            case '1':
                $eventtype = "Wedding";
                break;
            case '2':
                $eventtype = "Wedding";
                break;
            case '3':
                $eventtype = "Anniversary";
                break;
            case '4':
                $eventtype = "Anniversary";
                break;
            case '5':
                $eventtype = "Birthday";
                break;
            case '6':
                $eventtype = "None";
                break;
            case '7':
                $eventtype = $_POST['eventtype'];
                break;
            
            default:
                
                break;
        }

        if ($query->checkDate($venue, $eventdate) ) {
            // echo '<script>alert("Venue already reserved on that day");</script>';
            Queries::swal2('Venue already reserved on that day', 'Oops!', 'error');
        }else {
            $query_insert = new Reservation($connect, $name, $phonenum, $package, $eventdate, $eventtime, $venue, $numofguest, $description, $cardname, $cardtype, $cardnumber, $paymenttype, $amount, $dateofpayment, $eventtype);

            if ($query_insert->insertReserve($accountID)) {
                // echo '<script>alert("Event Reservation  Successful!");</script>';
                Queries::swal2('Event Reservation  Successful!', 'Success!', 'success');
            }else {
                // echo '<script>alert("Event Reservation  Failed!");</script>';
                Queries::swal2('Event Reservation  Failed!', 'Oops!' ,'error');
            }
        }
    }


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/bg&icons/logo.png">
    <title>MAGNIFIQUE Events & Co.</title>

    <!-- css -->
    <link rel="stylesheet" href="css/eventPackages.css">
    <link rel="stylesheet" href="css/screen.css">
    <!-- <link rel="stylesheet" href="css/sectionSize.css"> -->
    <link rel="stylesheet" href="css/section1.css">
    <link rel="stylesheet" href="css/section23456.css">

</head>

<body>
    <div class="main-container">

        <!-- top-img -->
        <section class="parallax-event">
        <div class="parallax-inner">

            </div>
        </section>

        <!-- EVENT PACKAGES SECTION 1 -->
        <section>
            <div class="card-container">
                <div class="top-package-title">
                    <h2 >Event Packages</h2>
                    <p>
                        Explore the flexibility and exceptional value offered by our packages at Magnifique. Browse through our selection to discover the perfect package tailored for you!
                    </p>
                    <h2 class="details-text">Details about the packages:</h2>
                </div>

                <div class="card">
                    <div class="img">
                        <img src="img/gallery/wedding.jpg" alt="">
                    </div>
                    <div class="top-text">
                        <div class="title">
                            Unifying LOVE: Wedding Package 
                        </div>
                    </div>
                    <div class="bottom-text">
                        <p>
                            Elevate your wedding preparations with the Unifying Love Wedding Package offered by Magnifique Event Co. Access a carefully curated list of reliable suppliers, guaranteeing a smooth and hassle-free journey towards your dream wedding.
                        </p>
                    </div>
                    <div class="card-btn">
                        <button onclick="openModal('UnifyingLove')">Read more</button>
                    </div>
                </div>

                <div class="card">
                    <div class="img">
                        <img src="img/gallery/ANNIVERSARY.jpg" alt="">
                    </div>
                    <div class="top-text">
                        <div class="title">
                            Eternal Bliss: Anniversary Package 
                        </div>
                    </div>
                    <div class="bottom-text">
                        <p>
                            Simplify your anniversary preparations with Magnifique Event Co.'s Eternal Bliss Anniversary Package, featuring thoughtfully curated suppliers to elevate your celebration of enduring love.
                        </p>
                    </div>
                    <div class="card-btn">
                        <button onclick="openModal('EternalBliss')">Read more</button>
                    </div>
                </div>
        
                <div class="card">
                    <div class="img">
                        <img src="img/gallery/tranding1.PNG" alt="">
                    </div>
                    <div class="top-text">
                        <div class="title">
                            Azure Skies: Birthday Package
                        </div>
                    </div>
                    <div class="bottom-text">
                        <p>
                            Transform your birthday celebration through Magnifique Event Co., offering a unique and unforgettable experience under the Azure Skies. Tailored to your desires, it promises to make your special day truly remarkable.
                        </p>
                    </div>
                    <div class="card-btn">
                        <button onclick="openModal('AzureSkies')">Read more</button>
                    </div>
                </div>
                
                <div class="card">
                    <div class="img">
                        <img src="img/gallery/venue.jpg" alt="">
                    </div>
                    <div class="top-text">
                        <div class="title">
                            Venue Rental Only
                        </div>
                    </div>
                    <div class="bottom-text">
                        <p>
                            Craft your ideal gatherings in our expansive and environmentally sustainable venues.
                        </p>
                    </div>
                    <div class="card-btn">
                        <button onclick="openModal('VenueRental')">Read more</button>
                    </div>
                </div>
                
                        <?php if (isset($_SESSION['UID'])) { ?>
                            <div class="reserveBTN-container">
                                <button class="reservation-btn" onclick="openModal('reserve')">Reserve Now!</button>
                            </div>
                        <?php } else {?>
                            <div class="reserveBTN-container">
                                <button class="reservation-btn" onclick="poplogin()">Reserve Now!</button>
                            </div>
                        <?php } ?>
            </div>
        </section>

        <!-- Modal 1: UnifyingLove Modal -->
        <div id="UnifyingLove" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('UnifyingLove')">&times;</span>
                <div class="package-container">

                <div class="package-title">
                    <h2>UNIFYING LOVE: Wedding Package SET  w/ Ceremony </h2><br><br>
                    
                    
                    </div>
                    
                    <div class="pack">
                    <br>
                        <h3>Venue</h3>
                        <ul>
                            <li>
                                Two (2) choices of facilities
                            </li>
                            <li>
                                Expansive parking space for up to 80 cars
                            </li>
                            <li>
                                Use of house for preparation on the day of the event
                            </li>
                            <li>
                                Overnight stay for 16 persons on the day of the event
                            </li>
                        </ul>
                        <br>
                        <h3>Photo and Video Coverage</h3>
                        <ul>
                            <li>
                                2 Photographers, 3 Videographers
                            </li>
                            <li>
                                Same Day Edit Video (5-10 minutes)
                            </li>
                            <li>
                                Full Photo and Video Documentation of the Event
                            </li>
                            <li>
                                (Preps - Ceremony - Reception)
                            </li>
                            <li>
                                200-300 Edited Wedding Photos
                            </li>
                            <li>
                                20 Pages 10 x 8 Premium Leather Album
                            </li>
                            <li>
                                12 x 18 Photo in Frame
                            </li>
                            <li>
                                16gb Wooden USB Flash Drive
                            </li>
                        </ul>
                        <br>
                    </div>
                    <div class="pack">
                        <br>
                        <h3>Flowers for the Entourage</h3>
                        <ul>
                            <li>
                                Bridal Bouquet
                            </li>
                            <li>
                                Mini Bouquets for 2 mothers and 3 bridesmaids
                            </li>
                            <li>
                                Flower baskets for 2 flower girls
                            </li>
                            <li>
                                Boutonnieres for groom, 2 fathers & 3 groomsmen
                            </li>
                        </ul>
                        <br>
                        <h3>Hair and Make Up Artist​</h3>
                        <ul>
                            <li>
                                Prenup
                                <ul>
                                    <li>
                                        Airbrush for Bride
                                    </li>
                                    <li>
                                        rooming for Groom
                                    </li>
                                    <li>
                                        Unli Retouch
                                    </li>
                                    <li>
                                        3-4 Looks
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <br>
                    </div>

                </div>
                <div class="package-container">

                    <div class="pack">  
                        <br>  
                        <h3>Delightful Dining Experience with Elegant Arrangements</h3>
                        <ul>
                            <li>
                                Your choice of buffet menu (1 soup, 2 vegetable, 1 pork or beef, 1 chicken, 1 fish, 1 pasta, 1 dessert, rice, flowing iced tea, and coffee)
                            </li>
                            <li>
                                Customer-oriented wait staff to assist and serve your guests
                            </li>
                            <li>
                                Complete and elegant buffet set-up
                            </li>
                            <li>
                                Elevated platform with thematic backdrop and couch for the couple
                            </li>
                            <li>
                                Linen covered round tables and gold- hued tiffany chairs
                            </li>
                            <li>
                                Presidential table set-up for the principal sponsors (up to 10 pairs)
                            </li>
                            <li>
                                Thematic centerpieces on each table
                            </li>
                        </ul>
                        <br>
                        <h3>Ceremony Set-up</h3>
                        <ul>
                            <li>
                                Altar table with couple's bench, podium and kneeler, and 3 candleholders
                            </li>
                            <li>
                                Decorated altar backdrop
                            </li>
                            <li>
                                Decorated curtain for bride reveal
                            </li>
                            <li>
                                Burlap Carpet
                            </li>
                            <li>
                                Vases with artificial flowers
                            </li>
                            <li>
                                White folding chairs
                            </li>
                            <li>
                                5 pairs of floral arrangements for the aisles
                            </li>
                        </ul>
                        <br>
                    </div>
                    <div class="pack">  
                        <br>                  
                        <h3>Lights and Sounds</h3>
                        <ul>
                            <li>Sounds Setup</li>
                                <ul>
                                    <li>
                                        2 Powered Speakers with Stand
                                    </li>
                                    <li>
                                        2 Wireless Microphones
                                    </li>
                                    <li>
                                        1 Wired Back Up Microphones and for Ceremony Area
                                    </li>
                                    <li>
                                        1 Digital Mixer with Analog Mixer Backup
                                    </li>
                                    <li>
                                        1 Laptop Audio Source Player
                                    </li>
                                </ul>
                            <li>Lights Set-Up</li>
                                <ul>
                                    <li>
                                        4 Pcs Uplights Full Color RGB for Stage Area
                                    </li>
                                    <li>
                                        8 Pcs Amber White Frontal Lights
                                    </li>
                                    <li>
                                        2 Pcs Full Color RGB Frontal Lights
                                    </li>
                                    <li>
                                        2 Light stands
                                    </li>
                                    <li>
                                        1 DMX Lights Controller
                                    </li>
                                </ul>
                            <li>Video Presentation Set-Up</li>
                                <ul>
                                    <li>
                                        1 3200 Lumens Full HD 1080p Projector
                                    </li>
                                    <li>
                                        1 Projector Screen Tripod Type 6x8 Size
                                    </li>
                                    <li>
                                        1 Laptop for video playback
                                    </li>
                                </ul>
                        </ul>
                        <br>
                    </div>

                </div>
                <h3 style="text-align: right;">Total price: 300,000</h3>
                
                <div class="package-container">
                    <br>
                    <div class="package-title">
                        <h2>UNIFYING LOVE: Wedding Package SET  w/o Ceremony</h2><br>
                    
                    </div>
                    <div class="pack">
                        <br>
                        <h3>Delightful Dining Experience with Elegant Arrangements</h3>
                        <ul>
                            <li>Your choice of buffet menu (1 soup, 2 vegetable, 1 pork or beef, 1 chicken, 1 fish, 1 pasta, 1 dessert, rice, flowing iced tea, and coffee)</li>
                            <li>Customer-oriented wait staff to assist and serve your guests</li>
                            <li>Complete and elegant buffet set-up</li>
                            <li>Elevated platform with thematic backdrop and couch for the couple</li>
                            <li>Linen covered round tables and gold- hued tiffany chairs</li>
                            <li>Presidential table set-up for the principal sponsors (up to 10 pairs)</li>
                            <li>Thematic centerpieces on each table</li>
                        </ul>
                        <br>
                        <h3>Venue</h3>
                        <ul>
                            <li>Two (2) choices of facilities</li>
                            <li>Expansive parking space for up to 80 cars</li>
                            <li>Use of house for preparation on the day of the event</li>
                            <li>Overnight stay for 16 persons on the day of the event</li>
                        </ul>
                        <br>
                    </div>

                    <div class="pack">
                        <br>
                        <h3>Photo and Video Coverage</h3>
                        <ul>
                            <li>2 Photographers</li>
                            <li>3 Videographers</li>
                            <li>Same Day Edit Video (5-10 minutes)</li>
                            <li>Full Photo and Video Documentation of the Event</li>
                            <li>200-300 Edited Wedding Photos</li>
                            <li>20 Pages 10 x 8 Premium Leather Album</li>
                            <li>12 x 18 Photo in Frame</li>
                            <li>16gb Wooden USB Flash Drive</li>
                        </ul>
                        <br>
                    </div>

                </div>
                <div class="package-container">

                    <div class="pack">
                        <br>
                        <h3>Lights and Sounds</h3>
                        <ul>
                            <li>Sounds Setup 
                                <ul>
                                    <li>2 Powered Speakers with Stand</li>
                                    <li>2  Wireless Microphones</li>
                                    <li>1 Wired Back Up Microphones and for Ceremony Area</li>
                                    <li>1 Digital Mixer with Analog Mixer Backup</li>
                                    <li>1 Laptop Audio Source Player</li>
                                </ul>
                            </li>
                        
                            <li>Lights Set-Up
                                <ul>
                                    <li>4 Pcs Uplights Full Color RGB for Stage Area</li>
                                    <li>8 Pcs Amber White Frontal Lights</li>
                                    <li>2 Pcs Full Color RGB Frontal Lights</li>
                                    <li>2 Light stands</li>
                                    <li>1 DMX Lights Controller</li>
                                </ul>
                        
                            </li>
                        
                            <li>Video Presentation Set-Up
                                <ul>
                                    <li>1 3200 Lumens Full HD 1080p Projector</li>
                                    <li>1 Projector Screen Tripod Type 6x8 Size</li>
                                    <li>1 Laptop for video playback</li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                    <div class="pack">
                        <h3>Freebies</h3>
                        <ul>
                            <li>Free use of venue as prenuptial photo shoot location</li>
                            <li>Use of Barrel for the wedding cake</li>
                            <li>Display rack for giveaways</li>
                            <li>Decorated Registration Table</li>
                            <li>Use of “Unplugged Wedding” Signage</li>
                            <li>Acoustic Area
                                <ul>
                                    <li>1 Keyboard Stand</li>
                                    <li>1 Lyrics Stand</li>
                                    <li>2 Wired Microphone</li>
                                    <li> 2 Microphone Stand</li>
                                    <li>1 Smoke Machine or Bubble Machine</li>
                                </ul>
                            </li>
                        </ul>
                    </div>
</div><h3 style="text-align: right;">Total price: 200,000</h3>
                </div>

            
        </div>
        
        <!-- Modal 2: EternalBliss Modal -->
        <div id="EternalBliss" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('EternalBliss')">&times;</span>

                <div class="package-container">

                    <div class="package-title">
                        <h2>ETERNAL BLISS: Anniversary Package (Couples only)</h2><br>
                        
                    </div>

                    <div class="pack">
                        <br>
                        <h3>Venue</h3>
                        <ul>
                            <li>Romantic and cozy venue of your choice</li>
                            <li>Private garden or terrace for the celebration</li>
                            <li>Beautifully decorated space with flowers and candles</li>
                        </ul>
                        <br>
                        <h3>Dining Experience</h3>
                        <ul>
                            <li>Customized anniversary dinner menu</li>
                            <li>Personalized service by a dedicated waiter/waitress</li>
                            <li>Elegant table setup with candles and romantic decor</li>
                            <li>Complimentary bottle of champagne or wine</li>
                        </ul>
                        <br>
                        <h3>Additional Services</h3>
                        <ul>
                            <li>Anniversary cake or dessert platter</li>
                            <li>Personalized anniversary gift or keepsake</li>
                            <li>Special anniversary toast or message</li>
                        </ul>
                    </div>

                    <div class="pack">
                        <br>
                        <h3>Entertainment</h3>
                        <ul>
                            <li>Live music or a musician to serenade the couple</li>
                            <li>Romantic playlist for background music</li>
                        </ul>
                        <br>
                        <h3>Photo and Video Coverage</h3>
                        <ul>
                            <li>Professional photographer to capture the special moments</li>
                            <li>A small photo album or digital photo frame with selected photos from the event</li>
                        </ul>
                        <br>
                        <h3>Freebies</h3>
                        <ul>
                            <li>Complimentary anniversary gift from the venue</li>
                            <li>Special discounts or offers for future visits</li>
                        </ul>
                        <br><h3 style="text-align: right;">Total price: 150,000</h3>
                    </div>
                    
                </div>
                <div class="package-container">

                    <div class="package-title">
                        
                        <h2>ETERNAL BLISS: Anniversary Package w/ Guests</h2><br>
                        
                    </div>

                    <div class="pack">
                    <br>
                        <h3>Venue</h3>
                        <ul>
                            <li>Romantic and cozy venue of your choice</li>
                            <li>Private garden or terrace for the celebration</li>
                            <li>Beautifully decorated space with flowers and candles</li>
                            <li>Overnight stay for the couple on the day of the event</li>
                        </ul>
                        <br>
                        <h3>Dining Experience</h3>
                        <ul>
                            <li>Your choice of buffet menu (1 soup, 2 vegetable, 1 pork or beef, 1 chicken, 1 fish, 1 pasta, 1 dessert, rice, flowing iced tea, and coffee)</li>
                            <li>Customer-oriented wait staff to assist and serve your guests</li>
                            <li>Complete and elegant buffet set-up</li>
                            <li>Elevated platform with thematic backdrop and couch for the couple</li>
                            <li>Linen covered round tables and tiffany chairs</li>
                            <li>Elegant table setup with candles and romantic decor</li>
                        </ul>
                    </div>

                    <div class="pack">
                        <br>
                        <h3>Entertainment</h3>
                        <ul>
                            <li>Live music or a musician to serenade the couple</li>
                            <li>Romantic playlist for background music</li>
                            <li>Engaging and charismatic host to guide the evening's festivities, interact with guests, and keep the energy high throughout the event</li>
                        </ul>
                        
                        <ul>Photo and Video Coverage
                            <li>Professional photographer to capture the special moments</li>
                            <li>Professional photographer to capture the special moments</li>
                            <li>Full Photo and Video Documentation of the Event</li>
                            <li>200-300 Edited Wedding Photos</li>
                            <li>20 Pages 10 x 8 Premium Leather Album</li>
                            <li>12 x 18 Photo in Frame</li>
                            <li>16gb Wooden USB Flash Drive</li>
                        </ul>
                        
                    </div>

                    </div>

                    <div class="package-container">

                    <div class="pack">
                        <br>
                        <h3>Lights and Sounds</h3>
                        <ul>
                            <li>Sounds Setup
                                <ul>
                                    <li>2 Powered Speakers with Stand</li>
                                    <li>2 Wireless Microphones</li>
                                    <li>1 Wired Back Up Microphones and for Ceremony Area</li>
                                    <li>1 Digital Mixer with Analog Mixer Backup</li>
                                    <li>1 Laptop Audio Source Player</li>
                                </ul>
                            </li>

                            <li>Lights Set-Up
                                <ul>
                                    <li>4 Pcs Uplights Full Color RGB for Stage Area</li>
                                    <li>8 Pcs Amber White Frontal Lights</li>
                                    <li>2 Pcs Full Color RGB Frontal Lights</li>
                                    <li>2 Light stands</li>
                                    <li>1 DMX Lights Controller</li>
                                </ul>
                            </li>

                            <li>Video Presentation Set-Up
                                <ul>
                                    <li>1 3200 Lumens Full HD 1080p Projector</li>
                                    <li>1 Projector Screen Tripod Type 6x8 Size</li>
                                    <li>1 Laptop for video playback</li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                    <div class="pack">
                        <br>
                        <h3>Freebies</h3>
                        <ul>
                            <li>Complimentary anniversary gift from the venue</li>
                            <li>Special discounts or offers for future visits</li>
                        </ul>
                        <br>
                        <h3>Additional Services</h3>
                        <ul>
                            <li>Anniversary cake or dessert platter</li>
                            <li>Personalized anniversary gift or keepsake</li>
                            <li>Special anniversary toast or message</li>
                        </ul>
                    </div>
                </div>
                <h3 style="text-align: right;">Total price: 200,000</h3>
            </div>
        </div>

        <!-- Modal 3: AzureSkies Modal -->
        <div id="AzureSkies" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('AzureSkies')">&times;</span>

                <div class="package-container">

                    <div class="package-title">
                        <h2>Azure Skies: Birthday Package</h2><br>
                        
                    </div>

                    <div class="pack">
                        <br>
                        <h3>Venue</h3>
                        <ul>
                            <li>Vibrant Birthday Bash Venue</li>
                            <li>Exclusive Use of the Venue for the Celebration</li>
                            <li>Themed Decorations and Personalized Signage</li>
                            <li>Access to Outdoor Areas for Games or Activities</li>
                        </ul>
                        <br>
                        <h3>Decorations</h3>
                        <ul>
                            <li>Customized Birthday Banner or Backdrop</li>
                            <li>Table Centerpieces with Fresh Flowers or Themed Decorations</li>
                            <li>LED Lighting to Create a Festive Atmosphere</li>
                        </ul>
                        <br>
                        <h3>Freebies</h3>
                        <ul>
                            <li>Complimentary Birthday Cake or Dessert for the Celebrant</li>
                            <li>Discounted Room Rates for Guests Who Wish to Stay Overnight</li>
                        </ul>
                    </div>

                    <div class="pack">
                        <br>
                        <h3>Dining Experience</h3>
                        <ul>
                            <li>Customizable Menu Options including Appetizers, Main Courses, and Desserts</li>
                            <li>Signature Birthday Cocktail or Mocktail</li>
                            <li>Interactive Food Stations or Dessert Tables</li>
                        </ul>
                        <br>
                        <h3>Entertainment</h3>
                        <ul>
                            <li>DIY craft station for guests to create personalized keepsakes</li>
                            <li>Temporary tattoo booth or face painting for guests</li>
                            <li>Karaoke setup for guests to showcase their singing talents</li>
                            <li>Professional DJ or Live Band for Music and Dancing</li>
                            <li>Magician or Clown to entertain the kids</li>
                        </ul>
                    </div>
                          

                </div>
                <h3 style="text-align: right;">Total price: 150,000</h3>
            </div>
        </div>

        <!-- Modal 4: VenueRental Modal -->
        <div id="VenueRental" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('VenueRental')">&times;</span>

                <div class="package-container">

                    <div class="package-title">
                        <h2>Venue Rental Only</h2><br>
                        

                    </div>

                    <div class="pack-last">
                        <ul>
                            <li >One choice of facility</li>
                            <li>Built-in string lights in the main reception</li>
                            <li>Expansive parking space for up to 80 cars</li>
                            <li>Use of house for preparation on the day of the event</li>
                            <li>Overnight stay for 16 persons on the day of the event</li>
                            <li>Event planning and coordination services </li>
                            <li>Audiovisual equipment rental (e.g., sound system, projector, screen)</li>
                            <li>Decorations and floral arrangements</li>
                            <li>Exclusive use of the venue for a specified number of hours</li>
                            <li>Basic setup of tables and chairs according to the client's specifications</li>
                        </ul>
                    </div>

                </div><br>
                <h3 style="text-align: right;">Total price: 100,000</h3>
            </div>
            
        </div>

        <!-- reservation form -->
        <div id="reserve" class="modal">
            <div class="modal-content" style="padding: 10px 20px;">
                <span class="close" onclick="closeModal('reserve')">&times;</span>
                
                <div class="reserve-form-container">
                    <form action="eventPackages.php" method="post">

                    <h3 class="title" style="text-align: center; padding: 5px 0;">PAYMENT</h3>
                        <div class="row">
                            <div class="col">

                                <div class="inputBox">
                                    <span>Name :</span>
                                    <input type="text" name="name" placeholder="full Name">
                                </div>
                                
                                <div class="inputBox">
                                    <span>Contact number :</span>
                                    <input type="number" name="phonenum" placeholder="9999-999-9999">
                                </div>

                                <div class="inputBox">
                                    <span>Event Package:</span>
                                    <select id="packageSelect" name="package" onchange="showInput()" required>
                                        <option value="">Select Package</option>
                                        <option value="1">Unifying Love: Wedding Package SET w/ Ceremony</option>
                                        <option value="2">Unifying Love: Wedding Package SET Without Ceremony</option>
                                        <option value="3">Eternal Bliss: Anniversary Package (Couples only)</option>
                                        <option value="4">Eternal Bliss: Anniversary Package w/ Guests</option>
                                        <option value="5">Azure Skies: Birthday Package</option>
                                        <option value="6">Venue Rental Only</option>
                                        <option value="7">None</option>
                                    </select>
                                </div>

                                <div id="otherInput" class="inputBox" style="display: none;">
                                    <span>Event Type:</span>
                                    <select id="eventTypeSelect" name="eventtype" >
                                        <option value="">Select Event Type</option>
                                        <option value="Wedding">Wedding</option>
                                        <option value="Birthday Party">Birthday Party</option>
                                        <option value="Anniversary">Anniversary</option>
                                        <option value="Corporate Event">Corporate Event</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>





                                <div class="inputBox">
                                    <span>Event Date :</span>
                                    <input type="Date" name="eventdate" placeholder="">
                                </div>

                                <div class="inputBox">
                                    <span>Event Time :</span>
                                    <input type="time" id="eventtime" name="eventtime" min="09:00" max="18:00" required>
                                </div>

                                

                                <div class="inputBox">
                                    <span>Venue: </span>
                                    <select name="venue" id="">
                                        <option value="">Select venue</option>
                                        <option value="1">Garden of Future</option>
                                        <option value="2">Garden of your Dreams</option>
                                        <option value="3">Poolside</option>
                                        <option value="4">Poolside Oasis</option>
                                        <option value="5">Function Hall</option>
                                        <option value="6">Banquet Hall</option>
                                    </select>
                                </div>

                                <div class="inputBox">
                                    <span>Number of Guests :</span>
                                    <input type="number" name="numofguest" placeholder="">
                                </div>


                                <div class="inputBox">
                                    <span>Brief Description of Event :</span>
                                    <div class="textarea-container">
                                        <textarea name="description" cols="57" rows="4"></textarea>
                                    </div>
                                </div>

                                

                            </div>

                            <div class="col">

                                <h3 class="title">payment</h3>

                                <div class="inputBox">
                                    <span>Cards Accepted :</span>
                                    <img src="./img/bg&icons/card_img.png" alt="">
                                </div>

                                <div class="inputBox">
                                    <span>Account Name :</span>
                                    <input type="text" name="cardname" placeholder="Rence Jio Bal-ot">
                                </div>

                                <div class="inputBox">
                                    <span>Type of Credit Card:</span>
                                    <select name="cardtype">
                                        <option value="">Select card</option>
                                        <option value="Visa">Visa</option>
                                        <option value="Master">Master</option>
                                        <option value="American">American</option>
                                        <option value="Paypal">Paypal</option>
                                    </select>
                                </div>

                                <div class="inputBox">
                                    <span>Credit Card Number :</span>
                                    <input type="number" name="cardnumber" placeholder="1111-2222-3333-4444">
                                </div>

                                <div class="inputBox">
                                    <span>Date of Payment :</span>
                                    <input type="Date" name="paymentdate" placeholder="">
                                </div>

                                <div class="inputBox">
                                    <span>Payment Type:</span>
                                    <select name="paymenttype" id="">
                                        <option value="">Select....</option>
                                        <option value="Initial">Initial Payment</option>
                                        <option value="Full">Full Payment</option>
                                    </select>
                                </div>

                                <div class="inputBox">
                                    <span>Amount:</span>
                                    <input type="number" name="amount" placeholder="">
                                </div>
                                

                            </div>

                        </div>
                                <!-- reserve-btn -->
                                <div class="inputBox">
                                    <div class="reserveBTN-container" style="padding-top: 20px">
                                    <?php if (isset($_SESSION['UID'])) {?>
                                        <button  class="reservation-btn" type="submit" name="reserve" onclick="return confirmreserve();">Reserve</button>
                                    <?php } ?>
                                    </div>
                                </div>
                        
                    </form>
                </div>

            
            </div>
        </div>
    </div>

    
    <?php include 'footer/footer.html'; ?>

    
        <script>
            function showInput() {
                var select = document.getElementById("packageSelect");
                var otherInput = document.getElementById("otherInput");

                if (select.value === "7") { // Check for "None" option
                    otherInput.style.display = "block";
                } else {
                    otherInput.style.display = "none";
                }
            }

            function confirmreserve(){
                return confirm("are you sure to the details you provided?");    
            }
        </script>




        <script>
            // script.js
            function openModal(modalId) {
            var modal = document.getElementById(modalId);
            modal.style.display = "block";
            }

            function closeModal(modalId) {
            var modal = document.getElementById(modalId);
            modal.style.display = "none";
            }
        </script>

</body>

</html>