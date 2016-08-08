$(function() { // Update the contents of the toolbars
    //$( "[data-role='navbar']" ).navbar();
    $( "[data-role='header'], [data-role='footer']" ).toolbar();
});
$( document ).on( "pageshow", "[data-role='page']", function() {
    //Checks page id
    var current = $(this).attr("id");
    // Remove active class from nav buttons
    $( "[data-role='navbar'] a.ui-btn-active" ).removeClass( "ui-btn-active" );
    // Add active class to current nav button
    $( "[data-role='navbar'] a" ).each(function() {
        if ( $( this ).attr("id") === current ) {
            $( this ).addClass( "ui-btn-active" );
        }
    });
});


