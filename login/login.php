
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- css -->
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/pop.css">
</head>
<body>    
    <div class="pop-up login">

        <div class="container" id="container">
            <div class="close-btn"><span>&times</span></div>
            <div class="form-container sign-up">
                <div class="logo-title">
                    <img src="img/bg&icons/logo.png" alt="logo">
                    <div class="title">
                        <h2>MAGNIFIQUE</h2>
                        <span>
                            EVENTS & CO.
                        </span>
                    </div>
                </div>
                    <?php if (!isset($_POST['signup'])) {  ?>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                            <h1>Create account</h1>
                            <span>
                                <!-- or use your email for registration -->
                            </span> 
                            <input type="text" name="name" placeholder="Name" required />
                            <input type="email" name="email" placeholder="Email" required />
                            <input type="password" name="password" placeholder="Password" required/>
                            <span class="error-container">
                                <?php if(isset($_GET['error'])) echo $_GET['error']; ?>
                            </span> 
                            <button type="submit" name="signup">Sign Up</button>
                        </form>
                    <?php } else{?>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                            <h1>Create account</h1>
                            <span>
                                verify  your account by entering the code sent to your email.
                            </span> 
                            <input type="text" name="user_code" placeholder="code" required />
                            
                            <button type="submit" name="verify">Verify</button>
                        </form>
                    <?php } ?>
            </div>
    
            <div class="form-container sign-in">
                <div class="logo-title">
                    <img src="img/bg&icons/logo.png" alt="logo">
                    <div class="title">
                        <h2>MAGNIFIQUE</h2>
                        <span>
                            EVENTS & CO.
                        </span>
                    </div>
                </div>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <h1>Sign In</h1>
                    <span>
                        <!-- or use your email paswword -->
                    </span> 
                    <input type="email" name="email" placeholder="Email" required value="<?php if(isset($_SESSION['email'])) echo $_SESSION['email']?>"/>
                    <input type="password" name="password" placeholder="Password" required value="<?php if(isset($_SESSION['password'])) echo $_SESSION['password']?>"/>
                    <span class="error-container">
                        <?php if(isset($_GET['error'])) echo $_GET['error']; ?>
                    </span> 
                    <button type="submit" name="signin">Sign In</button>
                </form>
            </div>
    
            <div class="toggle-container">
                <div class="toggle">
    
                    <div class="toggle-panel toggle-left">
                        <h1>Welcome Back!</h1>
                        <p>
                            Already have an account?
                        </p>
                        <button class="hidden" id="login">Sign In</button>
                    </div>
    
                    <div class="toggle-panel toggle-right">
                        <h1>New Here?</h1>
                        <p>
                            Sign up and discover a great amount of opportunities.
                        </p>
                        <button class="hidden" id="register">Sign Up</button>
                    </div>
    
                </div>
            </div>
        </div>
        
    </div>

    <script src="js/script.js"></script>


</body>
</html>