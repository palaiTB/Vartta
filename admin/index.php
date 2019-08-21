<?php
session_start();
$_DELIGHT["CTRID"]  = 3;
include "../load.osf.php";
/* Move the control to the respective pages according to the Event ID */
switch($APP->ID)
{
    case 8: //Case for eventname "Dashboard"
    $APP->VIEWPARTS = array('header-main.tpl.php', 'list.tpl.php', 'footer-main.tpl.php');
    $APP->PAGEVARS[TITLE] = "Dashboard";
    break;

    default:
    break;
} //End of switch statement
include "../load.view.php";
?>
