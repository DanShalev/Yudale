/*/////////////////VALIDATE Alphanumeric///////////////////////*/
function checkAlphanumeric(text_input) {
    var letters = /^[0-9a-zA-Z]+$/;
    return (letters.test(text_input));
}
/*//////////////////VALIDATE FORM FUNCTION///////////////////////////*/
function validateForm() {
    var form_submit = true;
    var password_Alphanumeric = false;
    var newPass_empty = false;
    var currPassword_value=document.forms["account_settings_form"]["field_currPassword"].value;
    var newPassword_value=document.forms["account_settings_form"]["field_newPassword"].value;
    var newPassword2_value=document.forms["account_settings_form"]["field_newPassword2"].value;
    /*========SET DEFULT STYLE AND TEXT==================*/
    $("#error_msg").html("");
    $("#field_currPassword").parent()
        .removeClass("ui-body-c")
        .addClass("ui-body-a");
    $("#field_newPassword").parent()
        .removeClass("ui-body-c")
        .addClass("ui-body-a");
    $("#field_newPassword2").parent()
        .removeClass("ui-body-c")
        .addClass("ui-body-a");
    /*========VALIDATE FORM SCRIPT==================*/
    //IF currPassword IS EMPTY:
    if (currPassword_value==null || currPassword_value=='') {
        $("#field_currPassword").parent()
            .removeClass("ui-body-a")
            .addClass("ui-body-c");
        $("#error_msg").html(function(i,origText) {
            return origText + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                + " Current password field is empty.<br>";
        });
        form_submit = false;
    }
    //IF currPassword IS NOT 3-10 CHARS:
    else if (currPassword_value.length<3 || currPassword_value.length>10) {
        $("#field_currPassword").parent()
            .removeClass("ui-body-a")
            .addClass("ui-body-c");
        $("#error_msg").html(function(i,origText) {
            return origText + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                + " Password must contain 3-10 characters.<br>";
        });
        form_submit = false;
    }
    //IF currPassword IS NOT NUMBERS AND LETTERS:
    else if (!checkAlphanumeric(currPassword_value)) {
        $("#field_currPassword").parent()
            .removeClass("ui-body-a")
            .addClass("ui-body-c");
        $("#error_msg").html(function(i,origText) {
            return origText + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                + " Password can contain only letters and numbers.<br>";
        });
        password_Alphanumeric = true;
        form_submit = false;
    }


    //IF newPassword IS EMPTY:
    if (newPassword_value==null || newPassword_value=='') {
        $("#field_newPassword").parent()
            .removeClass("ui-body-a")
            .addClass("ui-body-c");
        $("#error_msg").html(function(i,origText) {
            return origText + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                + " New password field is empty.<br>";
        });
        form_submit = false;
        newPass_empty = true;
    }
    //IF newPassword IS NOT 3-10 CHARS:
    else if (newPassword_value.length<3 || newPassword_value.length>10) {
        $("#field_newPassword").parent()
            .removeClass("ui-body-a")
            .addClass("ui-body-c");
        $("#error_msg").html(function(i,origText) {
            return origText + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                + " New password must contain 3-10 characters.<br>";
        });
        form_submit = false;
    }
    //IF newPassword IS NOT NUMBERS AND LETTERS:
    else if (!checkAlphanumeric(newPassword_value)) {
        $("#field_newPassword").parent()
            .removeClass("ui-body-a")
            .addClass("ui-body-c");
        if(password_Alphanumeric == false) {
            $("#error_msg").html(function(i,origText) {
                return origText + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                    + " Password can contain only letters and numbers.<br>";
            });
            password_Alphanumeric = true;
        }
        form_submit = false;
    }


    //IF newPassword2 IS EMPTY:
    if (newPassword2_value==null || newPassword2_value=='') {
        $("#field_newPassword2").parent()
            .removeClass("ui-body-a")
            .addClass("ui-body-c");
        $("#error_msg").html(function(i,origText) {
            return origText + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                + " Retype new password field is empty.<br>";
        });
        form_submit = false;
        newPass_empty = true;
    }
    //IF newPassword2 IS NOT 3-10 CHARS:
    else if (newPassword2_value.length<3 || newPassword2_value.length>10) {
        $("#field_newPassword2").parent()
            .removeClass("ui-body-a")
            .addClass("ui-body-c");
        $("#error_msg").html(function(i,origText) {
            return origText + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                + " Retyped new password must contain 3-10 characters.<br>";
        });
        form_submit = false;
    }
    //IF newPassword2 IS NOT NUMBERS AND LETTERS:
    else if (!checkAlphanumeric(newPassword2_value)) {
        $("#field_newPassword2").parent()
            .removeClass("ui-body-a")
            .addClass("ui-body-c");
        if(password_Alphanumeric == false) {
            $("#error_msg").html(function(i,origText) {
                return origText + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                    + " Password can contain only letters and numbers.<br>";
            });
            password_Alphanumeric = true;
        }
        form_submit = false;
    }

    //IF newPassword == newPassword2
    if ((newPass_empty == false) && (newPassword_value != newPassword2_value)) {
        $("#field_newPassword").parent()
            .removeClass("ui-body-a")
            .addClass("ui-body-c");
        $("#field_newPassword2").parent()
            .removeClass("ui-body-a")
            .addClass("ui-body-c");
        $("#error_msg").html(function(i,origText) {
            return origText + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                + " New Passwords do not match.<br>";
        });
        form_submit = false;
    }
    return (form_submit); //form_submit == false
}

/*//////////////////VALIDATE LOGIN DETAILS VIA DB (PHP)///////////////////////////*/
//IF DETAILS ARE INCORRECT
$(document).ready(function() {
    if (wrong_currPassword == true) {
        $("#field_currPassword").parent()
            .removeClass("ui-body-a")
            .addClass("ui-body-c");
        $("#error_msg").html(function(i,origText) {
            return origText + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                + " The current password you entered is incorrect.<br>";
        });
    }
});

//IF PASSWORD HAS BEEN CHANGED
if (passwordChanged == true) { //NOT WAITING FOR PAGE LOAD, THERE IS TIMING SCRIPT IN IT
    $(document).on('pageshow', function() {
        setTimeout(function () {
            $('#successPopup').popup('open');
        }, 100); // delay above zero
    });
}
