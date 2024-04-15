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
                <?php if (isset($_SESSION['type'])) { ?>
                        
                    <button>
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