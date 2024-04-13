<?php
if (isset($_GET['logout'])) {
  session_destroy();
  header( "location: ../index.php" );
}
?>


<div class="sidebar close">
    <div class="logo-details">
      <div class="img">
        <img src="../img/bg&icons/logo.png" width="30px" alt="">
      </div>
      <span class="logo_name">Magnifique</span>
    </div>
      <ul class="nav-links">

        <li>
          <a href="admin.php">
            <i class='bx bxs-dashboard'></i>
            <span class="link_name">Dashboard</span>
          </a>
          <ul class="sub-menu blank">
            <li><a class="link_name" href="admin.php">Dashboard</a></li>
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
          <a href="table.php?table=Event">
            <i class='bx bx-receipt'></i>
            <span class="link_name">Event Packages</span>
          </a>
          <ul class="sub-menu blank">
            <li><a class="link_name" href="table.php?table=Event">Event Packages</a></li>
          </ul>
        </li>

        <li>
          <a href="table.php?table=Users">
            <i class='bx bxs-user-detail'></i>
            <span class="link_name">User</span>
          </a>
          <ul class="sub-menu blank">
            <li><a class="link_name" href="table.php?table=Users">User</a></li>
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
            <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
              <button type="submit" name="logout" value="1">
                <i class='bx bx-log-out'></i>
              </button>
            </form>
          </div>
      </li>
    </ul>
  </div>


  <div class="admin-header">
    <i class='bx bx-menu' ></i>
    <span class="text">Dashboard</span>
  </div>