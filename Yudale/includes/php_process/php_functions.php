<?php
session_start();
//-------------------------GENERAL DATA----------------------------
header('Content-Type: text/html; charset=utf-8');
/*BASE HREF*/ $base_href = "//'website-domain'/";

//----------------------LOG-FILE FUNCTION--------------------------------
function printLogfile($SAVETO ,$fnc_action_user, $fnc_action, $fnc_user, $fnc_owe_to,
                      $fnc_amount, $fnc_currency, $fnc_debt_date, $fnc_debt_details,
    //IF ($fnc_old_amount == "null") - don't print <old_details>
                      $fnc_old_amount, $fnc_old_currency, $fnc_old_debt_date, $fnc_old_debt_details) {
    $xml = new DOMDocument();
    $xml->preserveWhiteSpace = false;
    $xml->load('../../users/logfiles/'.$SAVETO.'.xml'); //LOAD DOC **DOC MUST HAVE ROOT <logfile></logfile>**
    $xml->formatOutput = true; //PRINT IN READABLE NOT-1-LINE FORM

//<logfile>
    $root = $xml->documentElement;
//-<debt>
    $lf_debt = $xml->createElement("debt");
    $root->appendChild($lf_debt);
//- -<action_user>
    $lf_action_user = $xml->createElement("action_user", $fnc_action_user);
    $lf_debt->appendChild($lf_action_user);
//- -<action>
    $lf_action = $xml->createElement("action", $fnc_action);
    $lf_debt->appendChild($lf_action);
//- -<user>
    $lf_user = $xml->createElement("user", $fnc_user);
    $lf_debt->appendChild($lf_user);
//- -<owe_to>
    $lf_owe_to = $xml->createElement("owe_to", $fnc_owe_to);
    $lf_debt->appendChild($lf_owe_to);

//=========PRINT DATE & TIME===========
    //$currTime = date('j.m.Y | H:i', time());
//- -<date>
    $lf_date = $xml->createElement("date");
    $lf_debt->appendChild($lf_date);
//- - -<day>
    $lf_day = $xml->createElement("day", date('j', time()));
    $lf_date->appendChild($lf_day);
//- - -<month>
    $lf_month = $xml->createElement("month", date('m', time()));
    $lf_date->appendChild($lf_month);
//- - -<year>
    $lf_year = $xml->createElement("year", date('Y', time()));
    $lf_date->appendChild($lf_year);
//- - -<time>
    $lf_time = $xml->createElement("time", date('H:i', time()));
    $lf_date->appendChild($lf_time);

//- -<details>
    $lf_details = $xml->createElement("details");
    $lf_debt->appendChild($lf_details);
//- - -<amount>
    $lf_amount = $xml->createElement("amount", $fnc_amount);
    $lf_details->appendChild($lf_amount);
//- - -<currency>
    $lf_currency = $xml->createElement("currency", $fnc_currency);
    $lf_details->appendChild($lf_currency);
//- - -<debt_date>
    $lf_debt_date = $xml->createElement("debt_date", $fnc_debt_date);
    $lf_details->appendChild($lf_debt_date);
//- - -<debt_details>
    if ($fnc_debt_details != "") {
        $lf_debt_details = $xml->createElement("debt_details", $fnc_debt_details);
        $lf_details->appendChild($lf_debt_details);
    }

    if ($fnc_old_amount != "null") {
        //- -<old_details>
        $lf_old_details = $xml->createElement("old_details");
        $lf_debt->appendChild($lf_old_details);
        //- - -<old_amount>
        $lf_old_amount = $xml->createElement("old_amount", $fnc_old_amount);
        $lf_old_details->appendChild($lf_old_amount);
        //- - -<old_currency>
        $lf_old_currency = $xml->createElement("old_currency", $fnc_old_currency);
        $lf_old_details->appendChild($lf_old_currency);
        //- - -<old_debt_date>
        $lf_old_debt_date = $xml->createElement("old_debt_date", $fnc_old_debt_date);
        $lf_old_details->appendChild($lf_old_debt_date);
        //- - -<old_debt_details>
        if ($fnc_old_debt_details != "") {
            $lf_old_debt_details = $xml->createElement("old_debt_details", $fnc_old_debt_details);
            $lf_old_details->appendChild($lf_old_debt_details);
        }
    }

//RESAVE
    $xml->save('../../users/logfiles/'.$SAVETO.'.xml');
    return;
}

//----------------------CHECKS INPUT FUNCTION--------------------------------
function check_data($data, $con)
    //$con = connection to sql db
{
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    $data = mysqli_real_escape_string($con ,$data);
    return $data;
}


?>