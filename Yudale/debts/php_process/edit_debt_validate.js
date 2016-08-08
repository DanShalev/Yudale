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
    var amount=document.forms["edit_debt_form"]["editDebt_amount_field"].value;
    var date=document.forms["edit_debt_form"]["editDebt_date_field"].value;
    var details=document.forms["edit_debt_form"]["editDebt_details_field"].value;
    /*========SET DEFULT STYLE AND TEXT==================*/
    $("#error_msg_editDebt").html(""); //#ERROR MSG
    //#AMOUNT FIELD
    $("#editDebt_amount_field").parent()
        .removeClass("ui-body-c")
        .addClass("ui-body-a");
    //#CURRENCY FIELD
    $("#currency1_editDebt, #currency2_editDebt, #currency3_editDebt, #currency4_editDebt")
        .removeClass("ui-btn-c")
        .addClass("ui-btn-a");
    //#DATE
    $("#editDebt_date_field").parent()
        .removeClass("ui-body-c")
        .addClass("ui-body-a");
    //#DETAILS
    $("#editDebt_details_field").parent()
        .removeClass("ui-body-c")
        .addClass("ui-body-a");
    /*========VALIDATE FORM SCRIPT==================*/
        //#AMOUNT FIELD
    //IF AMOUNT IS EMPTY:
    if (amount==null || amount=='') {
        $("#editDebt_amount_field").parent()
            .removeClass("ui-body-a")
            .addClass("ui-body-c");
        $("#error_msg_editDebt").html(function(i,origText) {
            return origText + errorMsg_space + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                + " Amount field is empty.<br>";
        });
        form_submit = false;
    }
    //IF AMOUNT IS NOT 1-10 CHARS:
    else if (amount.length>10) {
        $("#editDebt_amount_field").parent()
            .removeClass("ui-body-a")
            .addClass("ui-body-c");
        $("#error_msg_editDebt").html(function(i,origText) {
            return origText + errorMsg_space + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                + " Amount must contain 1-10 characters.<br>";
        });
        form_submit = false;
    }
    //IF AMOUNT IS NOT NUMBERS
    else if (!checkNumber(amount)) {
        $("#editDebt_amount_field").parent()
            .removeClass("ui-body-a")
            .addClass("ui-body-c");
        $("#error_msg_editDebt").html(function(i,origText) {
            return origText + errorMsg_space + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                + " Amount can contain only numbers.<br>";
        });
        form_submit = false;
    }
    //#CURRENCY
    if (typeof $("input[name='editDebt_currencySelect_field']:checked").val() == 'undefined') {
        $("#currency1_editDebt, #currency2_editDebt, #currency3_editDebt, #currency4_editDebt")
            .removeClass("ui-btn-a")
            .addClass("ui-btn-c");
        $("#error_msg_editDebt").html(function(i,origText) {
            return origText + errorMsg_space + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                + " Currency must be selected.<br>";
        });
        form_submit = false;
    }
    //#DATE
        //IF DATE IS EMPTY:
    if (date==null || date=='') {
        $("#editDebt_date_field").parent()
            .removeClass("ui-body-a")
            .addClass("ui-body-c");
        $("#error_msg_editDebt").html(function(i,origText) {
            return origText + errorMsg_space + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                + " Date field is empty.<br>";
        });
        form_submit = false;
    } else if (isDateSelectedInFuture(date)==true) {
        $("#editDebt_date_field").parent()
            .removeClass("ui-body-a")
            .addClass("ui-body-c");
        $("#error_msg_editDebt").html(function(i,origText) {
            return origText + errorMsg_space + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                + " Debt date can't be in the future.<br>";
        });
        form_submit = false;
    }
    //#DETAILS FIELD
    //IF AMOUNT IS NOT > 50 CHARS:
    if (details.length>50) {
        $("#editDebt_details_field").parent()
            .removeClass("ui-body-a")
            .addClass("ui-body-c");
        $("#error_msg_editDebt").html(function(i,origText) {
            return origText + errorMsg_space + "<img src='style/buttons/validate/error.png' alt='error_icon' class='error_icon'>"
                + " Details can't contain more then 50 characters.<br>";
        });
        form_submit = false;
    }
    return (form_submit); //form_submit == false
}