<?php
session_start();
$_DELIGHT["CTRID"]  = 2;
include "./load.osf.php";
/* Move the control to the respective pages according to the Event ID */
switch($APP->ID)
{
    case 6: //Case for eventname "Default"
    if (isset($_POST['limit']) && isset($_POST['offset'])) {
      $limit = $_POST['limit'];
      $offset = $_POST['offset']+4;
    } else {
      $limit = 4;
      $offset = 0;
    }
    if (isset($_POST['limit']) && isset($_POST['offset'])) {
      $APP->VIEWPARTS = array('sort-articles.tpl.php');
    } else {
      $APP->VIEWPARTS = array('header-main.tpl.php', 'main.tpl.php', 'footer-main.tpl.php');
    }
    $APP->PAGEVARS[TITLE] = "Home";
    $APP->VIEWPARTS = array('header-main.tpl.php', 'main.tpl.php', 'footer-main.tpl.php');
    $APP->PAGEVARS[TITLE] = "Home";
    break;


    case 7: //Case for eventname "Logout"
    $URL=$APP->BASEURL;

		session_destroy();
		header("Location: ".$URL,301);
		exit();
    break;


    case 14: //Case for eventname "articleview"
    $APP->VIEWPARTS = array('header-main.tpl.php', 'view_article.tpl.php', 'footer-main.tpl.php');
    break;


    case 15: //Case for eventname "Registration"
    $APP->VIEWPARTS = array('header-sign.tpl.php', 'register.tpl.php', 'footer-sign.tpl.php');
    $APP->PAGEVARS[TITLE] = "Registration Page";
    break;


    case 17: //Case for eventname "xml"
    $APP->VIEWPARTS = array('header-main.tpl.php', 'xml.tpl.php', 'footer-main.tpl.php');
    break;


    case 19: //Case for eventname "scraping"
    $APP->VIEWPARTS = array('header-main.tpl.php', 'scrape.tpl.php', 'footer-main.tpl.php');
    break;

    default:
    break;
} //End of switch statement
include "./load.view.php";
?>
