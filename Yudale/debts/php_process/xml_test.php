<?php
/* INCLUDE php functions */ include "../../includes/php_process/php_functions.php";

$currTime = date('j.m.Y | H:i', time());
echo date('H:i', time());

//----------------------LOG-FILE FUNCTION--------------------------------
$xml = new DOMDocument();
$xml->preserveWhiteSpace = false;
$xml->load('../../users/logfiles/'.$_SESSION['username'].'.xml'); //LOAD DOC **DOC MUST HAVE ROOT <logfile></logfile>**
$xml->formatOutput = true; //PRINT IN READABLE NOT-1-LINE FORM

//<logfile>
$root = $xml->documentElement;
//-<debt>
$lf_debt = $xml->createElement("debt");
$root->appendChild($lf_debt);
//- -<action_user>
$lf_action_user = $xml->createElement("action_user", "???user???");
$lf_debt->appendChild($lf_action_user);
//- -<action>
$lf_action = $xml->createElement("action", "???action???");
$lf_debt->appendChild($lf_action);
//- -<user>
$lf_user = $xml->createElement("user", "???action???");
$lf_debt->appendChild($lf_user);
//- -<owe_to>
$lf_owe_to = $xml->createElement("owe_to", "???action???");
$lf_debt->appendChild($lf_owe_to);

//- -<date>
$lf_date = $xml->createElement("date");
$lf_debt->appendChild($lf_date);
//- - -<day>
$lf_day = $xml->createElement("day", "???");
$lf_date->appendChild($lf_day);
//- - -<month>
$lf_month = $xml->createElement("month", "???");
$lf_date->appendChild($lf_month);
//- - -<year>
$lf_year = $xml->createElement("year", "???");
$lf_date->appendChild($lf_year);
//- - -<time>
$lf_time = $xml->createElement("time", "???");
$lf_date->appendChild($lf_time);

//- -<details>
$lf_details = $xml->createElement("details");
$lf_debt->appendChild($lf_details);
//- - -<amount>
$lf_amount = $xml->createElement("amount", "???");
$lf_details->appendChild($lf_amount);
//- - -<currency>
$lf_currency = $xml->createElement("currency", "???");
$lf_details->appendChild($lf_currency);
//- - -<debt_date>
$lf_debt_date = $xml->createElement("debt_date", "???");
$lf_details->appendChild($lf_debt_date);
//- - -<debt_details>
$lf_debt_details = $xml->createElement("debt_details", "???");
$lf_details->appendChild($lf_debt_details);

//- -<old_details>
$lf_old_details = $xml->createElement("old_details");
$lf_debt->appendChild($lf_old_details);
//- - -<old_amount>
$lf_old_amount = $xml->createElement("old_amount", "???");
$lf_old_details->appendChild($lf_old_amount);
//- - -<old_currency>
$lf_old_currency = $xml->createElement("old_currency", "???");
$lf_old_details->appendChild($lf_old_currency);
//- - -<old_debt_date>
$lf_old_debt_date = $xml->createElement("old_debt_date", "???");
$lf_old_details->appendChild($lf_old_debt_date);
//- - -<old_debt_details>
$lf_old_debt_details = $xml->createElement("old_debt_details", "???");
$lf_old_details->appendChild($lf_old_debt_details);

//RESAVE
$xml->save('../../users/logfiles/'.$_SESSION['username'].'.xml');

?>