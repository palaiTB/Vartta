<?php
/*------------------------------------------------------------------------------+
 * Batoi Open Source Framework for Apps and Microservices                       |
 * (c)Copyright Batoi Systems Pvt Ltd. All rights reserved.                     |
 * Author: Ashwini Kumar Rath                                                   |
 * Website of Opendelight: https://www.batoi.com/osf                            |
 * Licensed under the terms of the GNU General Public License Version 2 or later|
 * (the "GPL"): http://www.gnu.org/licenses/gpl.html                            |
 * NOTE: The copyright notice like this on any of the distributed files         |
 *       (downloaded or obtained as the part of Batoi OSF) must NOT be          |
 *       removed or modified.                                                   |
 *------------------------------------------------------------------------------+
 */
error_reporting(E_ALL);
ini_set('display_errors','On');
date_default_timezone_set('Greenwich');
session_start();
if(isset($_GET['ID'])) $iID = $_GET['ID'];
else $iID = 1;
/* Autoload function for class */
function __autoload($sClassName)
{
	require_once (dirname(dirname(__FILE__)).'/ide/class/'.$sClassName . '.cls.php');
	if (!class_exists($sClassName, false)) trigger_error("Unable to load class: $sClassName", E_USER_WARNING);
}
switch($iID)
{
    case 1:
    		$APP->VIEWPARTS[]            = 'header.install.tpl.php';
			$APP->VIEWPARTS[]            = 'setup.application.tpl.php';
			$APP->VIEWPARTS[]            = 'footer.install.tpl.php';
    		$APP->PAGEVARS['title']      = 'Setup Application';
    		$APP->PAGEVARS['headertext'] = 'Setup Application';      		
    break;
    case 2:
           if(isset($_POST['hidInstallStatus']))
           {
               $oInstall = new Install();
               $sMessage = $oInstall->createApplication();
               if($sMessage == '')
               {
                  $sPath = $_SERVER['PHP_SELF'].'?ID=3';	
				  header("Location: $sPath");
				  exit();
               }
               else
               {
                  $sPath = $_SERVER['PHP_SELF'].'?ID=4';	
				  header("Location: $sPath");
				  exit();
               }
           }
		    $APP->VIEWPARTS[]            = 'header.install.tpl.php';
			$APP->VIEWPARTS[]            = 'setup.app-standalone.form.tpl.php';
			$APP->VIEWPARTS[]            = 'footer.install.tpl.php';
    		$APP->PAGEVARS['title']      = 'Define Application';
    		$APP->PAGEVARS['headertext'] = 'Define Application';      		
    break;
    case 3:
            include '../../sys.inc.php';
            include '../ide/script/dal.inc.php';
            $APP             = new APP();
            $IDE             = new IDE();
		    $aAppDetails     = $IDE->getAppDetails();
    		$APP->VIEWPARTS         = array('header.install.tpl.php', 'setup.app-standalone.success.tpl.php', 'footer.install.tpl.php');
    		$APP->PAGEVARS['title'] = 'Success!';
    		$APP->PAGEVARS['headertext'] = 'Success!';      		
    break;
    case 4:
            include '../../sys.inc.php';
            include '../ide/script/dal.inc.php';
            $APP             = new APP();
            $IDE             = new IDE();
		    $aAppDetails     = $IDE->getAppDetails();
    		$APP->VIEWPARTS         = array('header.install.tpl.php', 'error.tpl.php', 'footer.install.tpl.php');
    		$APP->PAGEVARS['title'] = 'Error!';
    		$APP->PAGEVARS['headertext'] = 'Error!';      		
    break;
}
if(!empty($APP->VIEWPARTS)) 
{
	foreach($APP->VIEWPARTS as $sViewPart) include(dirname(dirname(__FILE__)).'/ide/html/'.$sViewPart);
}
?>
