// <!-- side bar script -->

    let arrow = document.querySelectorAll(".arrow");
    for (var i = 0; i < arrow.length; i++) {
    arrow[i].addEventListener("click", (e)=>{
    let arrowParent = e.target.parentElement.parentElement;//selecting main parent of arrow
    arrowParent.classList.toggle("showMenu");
    });
    }
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".bx-menu");
    console.log(sidebarBtn);
    sidebarBtn.addEventListener("click", ()=>{
    sidebar.classList.toggle("close");
    });

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
                window.location.href='<?php echo "../index.php?logout=true"?>';
                //alert("Logout successful!"); // For demonstration, you can replace this with actual logout action
              }
        })
      }


//   // Search script
//   $(document).ready(function(){
//     var initialData = "";

//     // onload to pre
//     $.ajax({
//         url:"table-data.php",
//         method:"GET",
//         success:function(data){
//             initialData = data;
//             $('#results').html(initialData);
//         }
//     });

//       document.getElementById("searchEvent").addEventListener("input", function() {
//         var searchEvent = $(this).val();

//         if (searchEvent != "") {
//             // If searching, clear the initial data
//             $('#results').html("");

//             $.ajax({
//                 url:"table-data.php",
//                 method:"POST",
//                 data:{ searchEvent:searchEvent },
//                 success:function(data)
//                 {
//                     $('#results').html(data);
//                 }
//             });
//         } else {
//             $('#results').html(initialData);
//         }
//       });
      
// });


$(document).ready(function(){
    var initialData = "";

    // Load initial data
    $.ajax({
        url: "table-data.php",
        method: "GET",
        success: function(data) {
            initialData = data;
            $('#results').html(initialData);
        }
    });

    // Listen for input changes
    $('#searchEvent').on('input', function() {
        var searchEvent = $(this).val();

        if (searchEvent.trim() !== "") {
            $.ajax({
                url: "table-data.php",
                method: "POST",
                data: { searchEvent: searchEvent },
                success: function(data) {
                    $('#results').html(data);
                }
            });
        } else {
            $('#results').html(initialData);
        }
    });
});

