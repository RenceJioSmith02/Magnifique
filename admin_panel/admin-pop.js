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


// script for search pare

$(document).ready(function(){
    var initialData = "";
    var tablename = $('input[name="action"]').val(); 

    // Load initial data
    $.ajax({
        url: "table-data.php",
        method: "GET",
        data: { tablename: tablename },
        success: function(data) {
            initialData = data;
            $('#results').html(initialData);
        }
    });

    $('#searchEvent').on('input', function() {
        var searchEvent = $(this).val();
    
        if (searchEvent.trim() !== "") {
            $.ajax({
                url: "table-data.php",
                method: "GET",
                data: { searchEvent: searchEvent, 
                        tablename: tablename },
                success: function(data) {
                    $('#results').html(data);
                }
            });
        } else {
            $('#results').html(initialData);
        }
    });
});





    // Listen for input changes
    // $('#searchEvent').on('input', function() {
    //     var searchEvent = $(this).val();

    //     if (searchEvent.trim() !== "") {
    //         $.ajax({
    //             url: "table-data.php",
    //             method: "POST",
    //             data: { searchEvent: searchEvent },
    //             success: function(data) {
    //                 $('#results').html(data);
    //             }
    //         });
    //     } else {
    //         $('#results').html(initialData);
    //     }
    // });


