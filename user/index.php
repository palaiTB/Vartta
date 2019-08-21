<?php
session_start();
$_DELIGHT["CTRID"]  = 5;
include "../load.osf.php";
/* Move the control to the respective pages according to the Event ID */
switch($APP->ID)
{
    case 16: //Case for eventname "User Profile"
    if (isset($_POST['unmark'])) {
        $query=new artcls();
        $result=$query->unmark();

        echo json_encode($result);
        exit();
    }
    $APP->VIEWPARTS = array('header-main.tpl.php', 'profile.tpl.php', 'footer-main.tpl.php');
    $APP->PAGEVARS[TITLE] = "Profile";
    break;

    default:
    break;
} //End of switch statement
include "../load.view.php";
?>
