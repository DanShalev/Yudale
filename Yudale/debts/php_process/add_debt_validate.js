/*/////////////////VALIDATE FUNCTIONS///////////////////////*/
function checkNumber(text_input) {
    var letters = /^\d+$/;
    return (letters.test(text_input));
}
function isDateSelectedInFuture(input){ //TRUE IF IN FUTURE
    //TODAY DATE
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    //INPUT DATE
    var date_input = input.split("-");
    var d_input = date_input[2];
    var m_input = date_input[1];
    var yyyy_input = date_input[0];

    //CALCULATE IF FUTURE DATE
    return (yyyy_input>yyyy ||(yyyy_input==yyyy && m_input>mm) ||
        (yyyy_input==yyyy && m_input==mm && d_input>dd));
}
/*//////////////////VALIDATE FORM FUNCTION///////////////////////////*/
function validateForm() {
    var errorMsg_space = "&nbsp;&nbsp;&nbsp;";
    var form_submit = true;
    var amount=document.forms["add_debt_form"]["addDebt_amount_field"].value;
    var date=document.forms["add_debt_form"]["addDebt_date_field"].value;
    var details=document.forms["add_debt_form"]["addDebt_details_field"].value;
    /*========SET DEFULT STYLE AND TEXT==================*/
    $("#error_msg_addDebt").html(""); //#ERROR MSG
    //#DEBT OWNER
    $("#radio1_addDebt, #radio2_addDebt")
        .removeClass("ui-btn-c")
        .addClass("ui-btn-a");
    //#SELECT USER
    $("#select_user-button")
        .removeClass("ui-btn-c")
        .addClass("ui-btn-a");
    //#OTHER NAME FIELD
    if (document.getElementById("select_user").value == 'other') {
        $("#addDebt_other_name_field").parent()
            .removeClass("ui-body-c")
            .addClass("ui-body-a");
    }
    //#AMOUNT FIELD
    $("#addDebt_amount_field").parent()
        .removeClass("ui-body-c")
        .addClass("ui-body-a");
    //#CURRENCY FIELD
    $("#currency1_addDebt, #currency2_addDebt, #currency3_addDebt, #currency4_addDebt")
        .removeClass("ui-btn-c")
        .addClass("ui-btn-a");
    //#DATE
    $("#addDebt_date_field").parent()
        .removeClass("ui-body-c")
        .addClass("ui-body-a");
    //#DETAILS
    $("#addDebt_details_field").parent()
        .removeClass("ui-body-c")
        .addClass("ui-body-a");
    /*========VALIDATE FORM SCRIPT==================*/
    //#DEBT OWNER
    if (typeof $("input[name='radio_debtOwner']:checked").val() == 'undefined') {
        $("#radio1_addDebt, #radio2_addDebt")
            .removeClass("ui-btn-a")
            .addClass("ui-btn-c");
        $("#error_msg_addDebt").html(function(i,origText) {
            return origText + errorMsg_space + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                + " Debt owner must be selected.<br>";
        });
        form_submit = false;
    }
    //#SELECT USER
    if (document.getElementById("select_user").value == 'choose') {
        $("#select_user-button")
            .removeClass("ui-btn-a")
            .addClass("ui-btn-c");
        $("#error_msg_addDebt").html(function(i,origText) {
            return origText + errorMsg_space + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                + " User must be selected.<br>";
        });
        form_submit = false;
    }
   //#OTHER NAME FIELD
   if (document.getElementById("select_user").value == 'other') {
       var otherName_field=document.forms["add_debt_form"]["addDebt_other_name_field"].value;
       //IF OTH ER NAME IS EMPTY
       if (otherName_field==null || otherName_field=='') {
           $("#addDebt_other_name_field").parent()
               .removeClass("ui-body-a")
               .addClass("ui-body-c");
           $("#error_msg_addDebt").html(function(i,origText) {
               return origText + errorMsg_space + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                   + " Name field is empty.<br>";
           });
           form_submit = false;
       }
       //IF OTHER NAME IS NOT 1-20 CHARS:
       else if (otherName_field.length<2 || otherName_field.length>20) {
           $("#addDebt_other_name_field").parent()
               .removeClass("ui-body-a")
               .addClass("ui-body-c");
           $("#error_msg_addDebt").html(function(i,origText) {
               return origText + errorMsg_space + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                   + " Name must contain 1-20 characters.<br>";
           });
           form_submit = false;
       }
   }
    //#AMOUNT FIELD
        //IF AMOUNT IS EMPTY:
    if (amount==null || amount=='') {
        $("#addDebt_amount_field").parent()
            .removeClass("ui-body-a")
            .addClass("ui-body-c");
        $("#error_msg_addDebt").html(function(i,origText) {
            return origText + errorMsg_space + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                + " Amount field is empty.<br>";
        });
        form_submit = false;
    }
        //IF AMOUNT IS NOT 1-10 CHARS:
    else if (amount.length>10) {
        $("#addDebt_amount_field").parent()
            .removeClass("ui-body-a")
            .addClass("ui-body-c");
        $("#error_msg_addDebt").html(function(i,origText) {
            return origText + errorMsg_space + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                + " Amount must contain 1-10 characters.<br>";
        });
        form_submit = false;
    }
        //IF AMOUNT IS NOT NUMBERS
    else if (!checkNumber(amount)) {
        $("#addDebt_amount_field").parent()
            .removeClass("ui-body-a")
            .addClass("ui-body-c");
        $("#error_msg_addDebt").html(function(i,origText) {
            return origText + errorMsg_space + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                + " Amount can contain only numbers.<br>";
        });
        form_submit = false;
    }
    //#CURRENCY
    if (typeof $("input[name='addDebt_currencySelect_field']:checked").val() == 'undefined') {
        $("#currency1_addDebt, #currency2_addDebt, #currency3_addDebt, #currency4_addDebt")
            .removeClass("ui-btn-a")
            .addClass("ui-btn-c");
        $("#error_msg_addDebt").html(function(i,origText) {
            return origText + errorMsg_space + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                + " Currency must be selected.<br>";
        });
        form_submit = false;
    }
    //#DATE
    //IF DATE IS EMPTY:
    if (date==null || date=='') {
        $("#addDebt_date_field").parent()
            .removeClass("ui-body-a")
            .addClass("ui-body-c");
        $("#error_msg_addDebt").html(function(i,origText) {
            return origText + errorMsg_space + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                + " Date field is empty.<br>";
        });
        form_submit = false;
    } else if (isDateSelectedInFuture(date)==true) {
        $("#addDebt_date_field").parent()
            .removeClass("ui-body-a")
            .addClass("ui-body-c");
        $("#error_msg_addDebt").html(function(i,origText) {
            return origText + errorMsg_space + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                + " Debt date can't be in the future.<br>";
        });
        form_submit = false;
    }
    //#DETAILS FIELD
        //IF AMOUNT IS NOT > 50 CHARS:
    if (details.length>50) {
        $("#addDebt_details_field").parent()
            .removeClass("ui-body-a")
            .addClass("ui-body-c");
        $("#error_msg_addDebt").html(function(i,origText) {
            return origText + errorMsg_space + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                + " Details can't contain more then 50 characters.<br>";
        });
        form_submit = false;
    }
    return (form_submit); //form_submit == false
}