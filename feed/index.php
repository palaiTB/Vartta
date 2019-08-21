<?php
session_start();
$_DELIGHT["CTRID"]  = 7;
include "../load.osf.php";
/* Move the control to the respective pages according to the Event ID */
switch($APP->ID)
{
    case 18: //Case for eventname "xmlfeed"
    $xml = new SimpleXMLElement('<recents/>');
    $object_main= new viewarticle();
    $result=$object_main->view2(4,0);
    $ctgry=new category();


    foreach ($result as $key => $value) {
      $article = $xml->addChild('article');
      $article->addChild('id', $value['id']);
      $name = base64_decode($value['name']);
      $article->addChild('Name', mb_convert_encoding($name, "UTF8"));// mb_convert_encoding is used to convert in utf-8 encoding
      $cat_val=$ctgry->fetch_category($value['category']);
      $article->addChild('category', $cat_val['category']);
      $article->addChild('publishdate', date("d F Y, H:i A", $value['createdat']));
      $article->addChild('article_encode', $value['article']);
    }

    Header('Content-type: text/xml');
    print($xml->asXML());
    break;

    default:
    break;
} //End of switch statement
include "../load.view.php";
?>
