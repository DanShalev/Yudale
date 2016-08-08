$(document).bind("pageshow", function( event, ui ){ //LOAD SCRIPT ON PAGE CHANGE
    $( document ).ready(function() {
        $("a[data-ajax=false]").click(handleClick);
        function handleClick(e) {
            //HIDE DIVS
            $("[data-role=listview]").hide();
            $("#edit_button, #delete_button, #confirm_button_div, #submit_addDebt").hide();
            //PREVENT CLICKS
            var target = $(e.target).closest('a');
            if( target ) {
                e.preventDefault();
                window.location = target.attr('href');
            }
        }
    });
});