<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- css -->
    <link rel="stylesheet" href="css/homepage.css">
    <link rel="stylesheet" href="css/screen.css">

    <style>
        /* SECTION SIZE */
        @media screen and (max-width: 870px) {
            section {
                position: relative;
                left: 50px;
                width: calc(100% - 50px);
            }
        }
    </style>

</head>
<body>

    <div class="main-container">
        <header>
            <?php include 'nav/nav.html'; ?>
            <?php include 'login/login.php'; ?>
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
            <?php include 'homepage-sections/section2.html'; ?>
        </section>

        <section id="view3" class="view">
            <?php  include 'homepage-sections/section3.html'; ?>
        </section>
        
        <section id="view-4" class="view">
            <?php include 'homepage-sections/section4.html'; ?>
        </section>

        <section id="view5" class="view">
            <?php include 'homepage-sections/section5.html'; ?>
        </section>

        <section id="view6" class="view">
            <?php include 'homepage-sections/section6.html'; ?>
        </section>

    </div>

    
    <section class="footer">
        <?php include 'footer/footer.html'; ?>
    </section>


</body>
</html>