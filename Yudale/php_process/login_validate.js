/*/////////////////VALIDATE Alphanumeric///////////////////////*/
function checkAlphanumeric(text_input) {
    var letters = /^[0-9a-zA-Z]+$/;
    return (letters.test(text_input));
}
/*//////////////////VALIDATE FORM FUNCTION///////////////////////////*/
function validateForm() {
    var form_submit = true;
    var username_value=document.forms["login_form"]["field_username"].value;
    var password_value=document.forms["login_form"]["field_password"].value;
    /*========SET DEFULT STYLE AND TEXT==================*/
    $("#error_msg_login").html("");
    $("#field_username").parent()
        .removeClass("ui-body-c")
        .addClass("ui-body-a");
    $("#field_password").parent()
        .removeClass("ui-body-c")
        .addClass("ui-body-a");
    /*========VALIDATE FORM SCRIPT==================*/
    //IF USERNAME IS EMPTY:
    if (username_value==null || username_value=='') {
        $("#field_username").parent()
            .removeClass("ui-body-a")
            .addClass("ui-body-c");
        $("#error_msg_login").html(function(i,origText) {
            return origText + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                + " Username field is empty.<br>";
        });
        form_submit = false;
    }
    //IF USERNAME IS NOT 3-15 CHARS:
    else if (username_value.length<3 || username_value.length>15) {
        $("#field_username").parent()
            .removeClass("ui-body-a")
            .addClass("ui-body-c");
        $("#error_msg_login").html(function(i,origText) {
            return origText + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                + " Username must contain 3-15 characters.<br>";
        });
        form_submit = false;
    }
    //IF USERNAME IS NOT NUMBERS AND LETTERS:
    else if (!checkAlphanumeric(username_value)) {
        $("#field_username").parent()
            .removeClass("ui-body-a")
            .addClass("ui-body-c");
        $("#error_msg_login").html(function(i,origText) {
            return origText + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                + " Username can contain only letters and numbers.<br>";
        });
        form_submit = false;
    }


    //IF PASSWORD IS EMPTY:
    if (password_value==null || password_value=='') {
        $("#field_password").parent()
            .removeClass("ui-body-a")
            .addClass("ui-body-c");
        $("#error_msg_login").html(function(i,origText) {
            return origText + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                + " Password field is empty.<br>";
        });
        form_submit = false;
    }
    //IF PASSWORD IS NOT 3-10 CHARS:
    else if (password_value.length<3 || password_value.length>10) {
        $("#field_password").parent()
            .removeClass("ui-body-a")
            .addClass("ui-body-c");
        $("#error_msg_login").html(function(i,origText) {
            return origText + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                + " Password must contain 3-10 characters.<br>";
        });
        form_submit = false;
    }
    //IF PASSWORD IS NOT NUMBERS AND LETTERS:
    else if (!checkAlphanumeric(password_value)) {
        $("#field_password").parent()
            .removeClass("ui-body-a")
            .addClass("ui-body-c");
        $("#error_msg_login").html(function(i,origText) {
            return origText + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                + " Password can contain only letters and numbers.<br>";
        });
        form_submit = false;
    }
    return (form_submit); //form_submit == false
}

/*//////////////////VALIDATE LOGIN DETAILS VIA DB (PHP)///////////////////////////*/
//IF DETAILS ARE INCORRECT
$(document).ready(function() {
    if (wrong_password == true) {
        $("#field_username").parent()
            .removeClass("ui-body-a")
            .addClass("ui-body-c");
        $("#field_password").parent()
            .removeClass("ui-body-a")
            .addClass("ui-body-c");
        $("#error_msg_login").html(function(i,origText) {
            return origText + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                + " The username or password you entered is incorrect.<br>";
        });
    }
 });