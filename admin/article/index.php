<?php
session_start(); 
$_DELIGHT["CTRID"]  = 4;
include "../../load.osf.php";
/* Move the control to the respective pages according to the Event ID */
switch($APP->ID)
{ 
    case 9: //Case for eventname "Article_list"
    $APP->VIEWPARTS = array('header-main.tpl.php', 'article.tpl.php', 'footer-main.tpl.php');
    break;


    case 10: //Case for eventname "Add_article"
    $APP->VIEWPARTS = array('header-main.tpl.php', 'new_article.tpl.php', 'footer-main.tpl.php');
    break;


    case 11: //Case for eventname "View"
    $APP->VIEWPARTS = array('header-main.tpl.php', 'view_article.tpl.php', 'footer-main.tpl.php');
    break;


    case 12: //Case for eventname "update"
    $APP->VIEWPARTS = array('header-main.tpl.php', 'update_article.tpl.php', 'footer-main.tpl.php');
    break;


    case 13: //Case for eventname "Delete"
    $APP->VIEWPARTS = array('header-main.tpl.php', 'delete.tpl.php', 'footer-main.tpl.php');
    break;

    default:
    break;
} //End of switch statement
include "../../load.view.php";
?>
