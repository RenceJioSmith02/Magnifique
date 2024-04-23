<?php
        session_start();

        require("backend.php");
        $connect = new Connect_db();
        $query = new Queries($connect);

        if (isset($_SESSION['UID'])) {
          header("Location: ../index.php");
        }
        if (isset( $_GET["logout"])) {
          session_destroy();
          header("Location: ../index.php");
        }

        $query = new Queries($connect);

        $limit = 10;

        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

        $start = ($page - 1) * $limit;

        $tablename = "event";
        $tabletoUse_inQuery  = "eventreserve";

        $result = $query->Printing($start, $limit, $tablename);
        $rows = $result;

        $totalRows = $query->getTotalRows($tabletoUse_inQuery);
        $totalPages = ceil($totalRows / $limit);

        $prev = $page - 1;
        $next = $page + 1;

        $count = 0;
        $count += ($page - 1) * 10;

        $result = $query->updateSalesChart();
        $pending = $result['pending'];
        $declined = $result['declined'];
        $approved = $result['approved'];
      
        $total_catergory = $pending + $declined + $approved;

        $pending = ($pending / $total_catergory) * 100;
        $declined = ($declined / $total_catergory) * 100;
        $approved = ($approved / $total_catergory) * 100;

    ?>

<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/CodingLabYT-->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">

    <link rel="icon" type="image/x-icon" href="img/bg&icons/logo.png">
    <title>MAGNIFIQUE Events & Co.</title>
    <link rel="stylesheet" href="admin.css">

    <!-- Boxiocns CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

     <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <!-- ajax -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <!-- Include SweetAlert2 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

</head>
<body>

  <!-- Include SweetAlert2 library -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- sidebar-header -->
  <?php include 'sidebar-header.php'; ?>

  <section class="section-panel">
    <div class="section-content">
      
      <div class="box-container">

        <div class="box">
          <div class="box-label">
          </div>
          
          <div class="box-content">
            <div class="colors">
              <ul>
                <li class="color-label">
                  <div style="width: 10px; height: 10px; background: yellow;"></div>
                  <span>Pending</span>
                </li>
                <li class="color-label">
                  <div style="width: 10px; height: 10px; background: green;"></div>
                  <span>Approved</span>
                </li>
                <li class="color-label">
                  <div style="width: 10px; height: 10px; background: red;"></div>
                  <span>Declined</span>
                </li>
              </ul>
            </div>

            <div class="chart" 
            style="--pending: <?php echo $pending."%"; ?>; 
                    --approved: <?php echo $approved."%"; ?>; 
                    --declined: <?php echo $declined."%"; ?>;"
            >
             <div class="center-circle"></div> 
            </div>

          </div>

          <div class="box-label">
            <h3>Reservation  Status</h3>
          </div>
        </div>

        <div class="box">

          <div class="icon-box">
            <div class="box1">
              <span>1920</span>
              <h3>Users</h3>
            </div>
  
            <div class="box2">
              <ion-icon name="people-outline"></ion-icon>
            </div>
          </div>

        </div>

        <div class="box">

          <div class="icon-box">
            <div class="box1">
              <span>349,234</span>
              <h3>Earnings</h3>
            </div>
  
            <div class="box2">
              <ion-icon name="cash-outline"></ion-icon>
            </div>
          </div>

        </div>

      </div>

      <div class="box-container">
        <main class="table">
          <center><h3>Current Events</h3></center>
  
          <div class="table-body">
              <table>
                  <thead>
                      <tr>
                        <th>no.</th>
                        <th>Account Name</th>
                        <th>Customer Name</th>
                        <th>Phone Number</th>
                        <th>Event Type</th>
                        <th>Event Date</th>
                        <th>Event Time</th>
                        <th>Description</th>
                        <th>Venue</th>
                        <th>Package</th>
                        <th>Price</th>
                      </tr>
                  </thead>
                  <tbody id="results">
                    
                    <!-- ajax will puno this hehe -->
      
                  </tbody>
              </table>
              
        </div>
              <div class="pagination" style="top: 0%">
                      <?php if ($prev !== null): ?>
                          <a href="?page=<?php echo $prev; ?>">Previous</a>
                      <?php endif; ?>
                      
                      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                          <a <?php if ($i == $page) echo 'class="active"'; ?> href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                      <?php endfor; ?>

                      <?php if ($next !== null): ?>
                          <a href="?page=<?php echo $next; ?>">Next</a>
                      <?php endif; ?>
                  </div>
              </div>        
              
      </div>

      </main>
                    
      

    </div>
  </section>

    
  <!-- side bar and pop-ups script -->
  <script src="admin-pop.js"></script>
  
    <!-- ionicons -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  
</body>
</html>