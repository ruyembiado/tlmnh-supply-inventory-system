$(document).ready(function () {
    $(".toggle-btn").click(function () {
        // Toggle sidebar and nav
        $("#sidebar").toggleClass("expand");
        $("nav").toggleClass("nav-collapse");

        // Toggle icons
        $(this).find(".icon-left").toggle();  // hide/show left icon
        $(this).find(".icon-right").toggle(); // hide/show right icon
    });

    // Initialize DataTable
    $("#dataTable1").DataTable();
});