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

    <link rel="stylesheet" href="css/gallery.css">
    <link rel="stylesheet" href="css/screen.css">
    <!-- <link rel="stylesheet" href="css/sectionSize.css"> -->

</head>
<body>

    <div class="main-container">

        <section>
            <div class="grid-wrapper">
                <div class="img">
                    <img src="img/gallery/gallery1.png" alt="">
                </div>
                <div class="img">
                    <img src="img/gallery/gallery2.jpg" alt="">
                </div>
                <div class="img tall">
                    <img src="img/gallery/gallery3.jpg" alt="">
                </div>
                <div class="img wide">
                    <img src="img/gallery/gallery4.jpg" alt="">
                </div>
                <div class="img tall">
                    <img src="img/gallery/gallery5.jpg" alt="">
                </div>
                <div class="img">
                    <img src="img/gallery/gallery6.jpg" alt="">
                </div>
                <div class="img ">
                    <img src="img/gallery/gallery21.png" alt="">
                </div>
                <div class="img wide">
                    <img src="img/gallery/gallery22.jpg" alt="">
                </div>
                <div class="img big">
                    <img src="img/gallery/gallery13.jpg" alt="">
                </div>
                <div class="img ">
                    <img src="img/gallery/gallery26.jpg" alt="">
                </div>
                
                <div class="img ">
                    <img src="img/gallery/gallery10.jpg" alt="">
                </div>
                <div class="img ">
                    <img src="img/gallery/gallery8.jpg" alt="">
                </div>
                <div class="img ">
                    <img src="img/gallery/gallery15.jpg" alt=""> <!--malabo pa -->
                </div>
                <div class="img ">
                    <img src="img/gallery/gallery12.jpg" alt="">
                </div>
                <div class="img ">
                    <img src="img/gallery/gallery19.jpg" alt="">
                </div>
                <div class="img">
                    <img src="img/gallery/gallery14.jpg" alt="">
                </div>
                <div class="img big">
                    <img src="img/gallery/gallery16.jpg" alt="">
                </div>
                <div class="img wide">
                    <img src="img/gallery/gallery25.jpg" alt="">
                </div>
                <div class="img ">
                    <img src="img/gallery/gallery18.webp" alt="">
                </div>
                <div class="img wide">
                    <img src="img/gallery/gallery17.jpg" alt="">
                </div>
                <div class="img">
                    <img src="img/gallery/gallery11.jpg" alt="">
                </div>
                <div class="img wide">
                    <img src="img/gallery/gallery20.jpg" alt="">
                </div>
                <div class="img tall">
                    <img src="img/gallery/gallery23.jpg" alt="">
                </div>
                <div class="img">
                    <img src="img/gallery/gallery24.png" alt="">
                </div>
                <div class="img">
                    <img src="img/gallery/gallery27.jpg" alt="">
                </div>
                <div class="img">
                    <img src="img/gallery/gallery28.jpg" alt="">
                </div>
                
                <div class="lightbox" id="lightbox">
                    <span class="close" onclick="closeLightbox()">&times;</span>

                    <div class="inner-content">
                        <button class="prev" onclick="prevImage()"><i class="fas fa-chevron-left"></i></button>
                        <img class="lightbox-content" id="lightboxImg" src="" alt="">
                        <button class="next" onclick="nextImage()"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>

            </div>
        </section>
    </div>

    <?php include 'footer/footer.html'; ?>

    <script src = "js/gallery.js"></script>
</body>
</html>