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

      <div class="header-search mobile">

        <div class="desktop-search">
          <input type="text" id="searchEvent" name="search" placeholder="Search..." class="input-field" required>
          <input type="hidden" name="action" value="<?php if (isset($_GET['table'])) { echo $_GET['table']; } else { echo 'Event'; }?>"/>
          
          <button type="submit" name=searchBtn class="search-btn" aria-label="Search">
            <ion-icon name="search-outline"></ion-icon>
          </button>
        </div>

        <div class="mobile-search">
          <button type="submit" name=searchBtn class="search-btn" onclick="openSearch(true)">
            <ion-icon name="search-outline"></ion-icon>
          </button>
        </div>

      </div>
   
  </div>



  <script>
      function openSearch(open) {
        if (open = true) {
          document.querySelector('.desktop-search').classList.toggle("active");
        }
      }

      function logout() {
        Swal.fire({
              title: 'Are you sure?',
              text: "You will be logged out!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, logout!'
  
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.href='<?php echo "admin.php?logout=true";?>';
                //alert("Logout successful!"); // For demonstration, you can replace this with actual logout action
              }
        })
      }
  </script>



</body>
</html>