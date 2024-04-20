<?php
// if (isset($_GET['logout'])) {
//   session_destroy();
//   header( "location: ../index.php" );
// }
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <!-- custom css -->
  <link rel="stylesheet" href="admin.css">

</head>
<body>

  
<div class="sidebar close">
    <div class="logo-details">
      <div class="img">
        <img src="../img/bg&icons/logo.png" width="30px" alt="">
      </div>
      <span class="logo_name">Magnifiques</span>
    </div>
      <ul class="nav-links">

        <li>
          <a href="admin.php?table=Event">
            <i class='bx bxs-dashboard'></i>
            <span class="link_name">Dashboard</span>
          </a>
          <ul class="sub-menu blank">
            <li><a class="link_name" href="admin.php?table=Event">Dashboard</a></li>
          </ul>
        </li>

        <li>
          <div class="iocn-link">
            <a href="table.php?table=Reservation">
              <i class='bx bx-store'></i>
              <span class="link_name">Reservation</span>
            </a>
            <ul class="sub-menu blank">
              <li><a class="link_name" href="table.php?table=Reservation">Reservation</a></li>
            </ul>
          </div>
        </li>

        <li>
          <a href="table.php?table=Users">
            <i class='bx bxs-user-detail'></i>
            <span class="link_name">User</span>
          </a>
          <ul class="sub-menu blank">
            <li><a class="link_name" href="table.php?table=Users">Users</a></li>
          </ul>
        </li>

      <li>
          <div class="profile-details">
          <div class="profile-content">
              <!--<img src="image/profile.jpg" alt="profileImg">-->
          </div>
          <div class="name-job">
              <div class="profile_name">ADMINISTRATOR</div>
          </div>
            <button onclick="logout()">
              <i class='bx bx-log-out'></i>
            </button>
          </div>
      </li>
    </ul>
  </div>


  <div class="admin-header">
    <div class="left-box">
      <i class='bx bx-menu' ></i>
      <span class="text">Dashboard</span>
    </div>

      <div class="header-search">
        <form action="admin.php" method="GET" enctype="multipart/form-data" class="form">

          <input type="text" id="searchEvent" name="search" placeholder="Search..." class="input-field" required>
          <input type="hidden" name="action" value="<?php if (isset($_GET['table'])) echo $_GET['table']; ?>"/>
          
          <button type="submit" name=searchBtn class="search-btn" aria-label="Search">
            <ion-icon name="search-outline"></ion-icon>
          </button>

        </form>
      </div>


    <!-- <?php if (isset($_GET['table']) && $_GET['table'] == 'Event') { ?>

    <?php } elseif (isset($_GET['table']) && $_GET['table'] == 'Reservation') { ?>
            search 2
    <?php } elseif (isset($_GET['table']) && $_GET['table'] == 'Users') { ?>
            search 3
    <?php } ?> -->
   
  </div>



</body>
</html>