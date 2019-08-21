<?php
/*------------------------------------------------------------------------------+
 * Opendelight - A PHP based Rapid Web Application Development Framework        |
 * (c)Copyright ADII Research & Applications (P) Limited. All rights reserved.  |
 * Author: Ashwini Kumar Rath                                                   |
 * Website of Opendelight: http://www.adiipl.com/opendelight                    |
 * Licensed under the terms of the GNU General Public License Version 2 or later|
 * (the "GPL"): http://www.gnu.org/licenses/gpl.html                            |
 * NOTE: The copyright notice like this on any of the distributed files         |
 *       (downloaded or obtained as the part of Opendelight) must NOT be        |
 *       removed or modified.                                                   |
 *------------------------------------------------------------------------------+
 */
date_default_timezone_set('Greenwich');
session_start();
$_ISPUBLIC = false;
/*-------------------------------------------------------------
 * Inclusion of delight self codebase
 *-------------------------------------------------------------*/
if(!file_exists('../../sys.inc.php')) //Check for System Configuration
{
	header("Location: ../install/");
	exit();
}
require_once '../../sys.inc.php'; //Include configuration file
if(!count($_DELIGHT))
{
	header("Location: ../install/");
	exit();
}
include './script/dal.inc.php';
/* Autoload function for class */
function __autoload($sClassName)
{
	require_once (dirname(__FILE__).'/class/'.$sClassName . '.cls.php');
	if (!class_exists($sClassName, false)) trigger_error("Unable to load class: $sClassName", E_USER_WARNING);
}
$APP   = new APP();
$USER  = new USER();
$IDE   = new IDE();
$aAppDetails = $IDE->getAppDetails();
/* Move the control to the respective pages according to the "$APP->ID" */
switch($APP->ID)
{
	case '1': // Dashboard
	    $aLatestEvents = $IDE->getLatestEvents();
	    $aLatestClasses= $IDE->getLatestClasses();
	    $oFeedItems = $IDE->getFeedContent();
		$APP->VIEWPARTS  = array('header.main', 'dashboard', 'footer.main');
	    $APP->PAGEVARS['title'] = 'Dashboard | OSF IDE';    	
	    $APP->PAGEVARS['headertext'] = 'OSF IDE Dashboard';
	    $APP->PAGEVARS['breadcrumb'] = '';
    break;   
	case '20': // List of Controllers
		$oControllers   = new Controllers();
		$aCtrlDetails   = $oControllers->listPage();	
		$APP->VIEWPARTS = array('header.main', 'controllers', 'footer.main');
		$APP->PAGEVARS['title'] = 'List of Controllers | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'List of Controllers';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
	break;
	case '21': // List of Events
		$oEvent    = new Event();
		$aEventDetails   = $oEvent->listEventPage($_GET['CtrID']);
		$aCtrDetails     = $oEvent->getController($_GET['CtrID']);
		$APP->VIEWPARTS  = array('header.main', 'events', 'footer.main');
		$APP->PAGEVARS['title'] = 'List of Events for '.stripslashes($aCtrDetails[0]['ctrname']).' | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'List of Events for <em>'.stripslashes($aCtrDetails[0]['ctrname']).'</em>';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=20&CtrID='.$_GET['CtrID'].'">Controllers</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
	break;
	case '22': // Add Controller
		$oControllers    = new Controllers();
		$aMsg = $oControllers->addController();
		$iRecID = 0;
		$aPublicControllers = $oControllers->getPublicControllers($iRecID);
		$APP->VIEWPARTS = array('header.main', 'controller-add', 'footer.main');
		$APP->PAGEVARS['title'] = 'Add Controller | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'Add Controller';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=20">List of Controllers</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
    break;
    case '23': // Edit Controller
	    $iRecID              = $_GET['RecID'];
		$oControllers        = new Controllers();
		$aMsg = $oControllers->editController($iRecID);
		$aEachCtrDetails    = $oControllers->listEachController($iRecID);
		$aPublicControllers = $oControllers->getPublicControllers($iRecID);
		$APP->VIEWPARTS = array('header.main', 'controller-edit', 'footer.main');
		$APP->PAGEVARS['title'] = 'Edit Controller | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'Edit Controller: <em>'.$APP->BASEURL.'/'.$aEachCtrDetails[0]['ctrname'].' (CTRID = '.$iRecID.')</em>';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=20">List of Controllers</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
	break;
	case '24': // Add Event to a Controller
		$oEvent    = new Event();          	  	
		$aMsg = $oEvent->addEvent();
		$aCtrDetails     = $oEvent->getController($_GET['CtrID']);   	 
		$aPageVarDetails = $oEvent->getPagevars(); 
		$APP->VIEWPARTS  = array('header.main', 'events-add', 'footer.main');
	    $APP->PAGEVARS['title'] = 'Add Event for Controller '.stripslashes($aCtrDetails[0]['ctrname']).' | OSF IDE';    	
	    $APP->PAGEVARS['headertext'] = 'Add Event for Controller <em>'.stripslashes($aCtrDetails[0]['ctrname']).'</em>';	
	    $APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=20&CtrID='.$_GET['CtrID'].'">Controllers</a></li><li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=21&CtrID='.$_GET['CtrID'].'">List of Events for Controller <em>'.stripslashes($aCtrDetails[0]['ctrname']).'</em></a></li><li class="active">Add Event</li>';
    break;
    case '25': // Edit Event
		$iRecID = $_GET['RecID'];
		$oEvent = new Event();             
		$aMsg   = $oEvent->editEvent($iRecID);
		$aEachEventDetails      = $oEvent->listEachEvent($iRecID);
		$aCtrDetails            = $oEvent->getController($_GET['CtrID']);	
		$aPageVarDetails 		= $oEvent->getPagevars();	
		$APP->VIEWPARTS         = array('header.main', 'events-edit', 'footer.main');
		$APP->PAGEVARS['title'] = 'Edit Event '.stripslashes($aEachEventDetails[0]['eventname']).' | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'Edit Event: <em>'.stripslashes($aEachEventDetails[0]['eventname']).' ($APP->ID = '.stripslashes($aEachEventDetails[0]['eventid']).')</em>';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=20&CtrID='.$_GET['CtrID'].'">Controllers</a></li><li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=21&CtrID='.$_GET['CtrID'].'">List of Events for '.stripslashes($aCtrDetails[0]['ctrname']).'</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
	break;	
	case '26':	// Delete Event	
		$iRecID = $_GET['RecID'];		
		$oEvent = new Event();      		
		$oEvent->deleteEvent($iRecID);
	break;
	case '27': // Sort Controllers
		$oControllers    = new Controllers();          
		$aMsg = $oControllers->sortController();
	    $aSortedCtrlList   = $oControllers->getCtrlSortList();
		$APP->VIEWPARTS = array('header.main', 'controllers-arrange', 'footer.main');
		$APP->PAGEVARS['title'] = 'Arrange Controllers | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'Arrange Controllers';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=20">List of Controllers</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
	break;
	case '28': // Delete Controller
		$iRecID = $_GET['RecID'];	
		$oControllers    = new Controllers();      		
		$aMsg = $oControllers->deleteController($iRecID);
	break;
	case '29': // Sort events
		$oEvent    = new Event();          
		$aMsg = $oEvent->sortEvent();	
	    $aSortedEventList   = $oEvent->getEventSortList($_GET['CtrID']);	
	    $aCtrDetails        = $oEvent->getController($_GET['CtrID']);	
	    $APP->VIEWPARTS     = array('header.main', 'events-arrange', 'footer.main');	
		$APP->PAGEVARS['title'] = 'Arrange Events | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'Arrange Events for <em>'.stripslashes($aCtrDetails[0]['ctrname']).'</em>';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=20&CtrID='.$_GET['CtrID'].'">Controllers</a></li><li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=21&CtrID='.$_GET['CtrID'].'">Manage Events for '.stripslashes($aCtrDetails[0]['ctrname']).'</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
	break;
	case '30': // List Application Classes
		$oModel             = new Model();      	  		
		$aAppClassDetails   = $oModel->listAppClass();
		$aMsg               = $oModel->getListPageMessage();
		$APP->VIEWPARTS = array('header.main', 'appclass', 'footer.main');
		$APP->PAGEVARS['title'] = 'List of Application Classes | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'List of Application Classes';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li clas="active">'.$APP->PAGEVARS['headertext'].'</li>';
	break;	
	case '31':	// Add Model Class	  
		$oModel = new Model();
		$aMsg = $oModel->addClassName();
		$APP->VIEWPARTS = array('header.main', 'appclass-add', 'footer.main');
		$APP->PAGEVARS['title'] = 'Add Application Class | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'Add Application Class';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=30">List of Application Classes</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
    break;
    case '32': // Edit Model Class
		$sClass      = $_GET['Class'];
		$oModel      = new Model();
		$aMsg = $oModel->editAppClass();
		$sClassContent = $oModel->listEachClass($sClass);
		$APP->VIEWPARTS = array('header.main', 'appclass-edit', 'footer.main');
		$APP->PAGEVARS['title'] = 'Edit Application Class - '.$sClass.' | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'Edit Application Class - <em>'.$sClass.'</em>';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=30">List of Application Classes</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
	break;
	case '33': // Delete Model Class
		$sClass = $_GET['Class'];
		$oModel = new Model();   
		$aMsg = $oModel->deleteAppClass($sClass);
	break;
	case '35': // List Script Includes
		$oModelScript             = new ModelScript();      	  		
		$aAppSIDetails   = $oModelScript->listScriptIncludes();
		$aMsg               = $oModelScript->getListPageMessage();
		$APP->VIEWPARTS = array('header.main', 'scriptincludes', 'footer.main');
		$APP->PAGEVARS['title'] = 'List of Script Includes | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'List of Script Includes';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
	break;	
	case '36':	// Add Script Includes	  
		$oModelScript = new ModelScript();
		$aMsg = $oModelScript->addSIName();
		$APP->VIEWPARTS = array('header.main', 'scriptincludes-add', 'footer.main');
		$APP->PAGEVARS['title'] = 'Add Script Include | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'Add Script Include';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=35">List of Script Includes</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
    break;
    case '37': // Edit Script Includes
		$sFile      = $_GET['File'];
		$oModelScript      = new ModelScript();
		$aMsg = $oModelScript->editSIFile();
		$sClassContent = $oModelScript->listEachFile($sFile);
		$APP->VIEWPARTS = array('header.main', 'scriptincludes-edit', 'footer.main');
		$APP->PAGEVARS['title'] = 'Edit Script Include File - '.$sFile.' | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'Edit Script Include File - <em>'.$sFile.'</em>';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=35">List of Script Includes</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
	break;
	case '38': // Delete Script Includes
		$sFile = $_GET['File'];
		$oModelScript = new ModelScript();   
		$aMsg = $oModelScript->deleteSIFile($sFile);
	break;
	case '40': // View UI Files
		$oView             = new View();
		$sFileTypeTexts = $oView->getFileTypeTexts();
		$aViewFileDetails   = $oView->listViewFiles();
		$aMsg               = $oView->getListPageMessage();
		$APP->VIEWPARTS = array('header.main', 'viewfiles', 'footer.main');
		$APP->PAGEVARS['title'] = 'List of '.$sFileTypeTexts.'s | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'List of '.$sFileTypeTexts.'s';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
	break;
	case '41':	// Add View File	  
		$oView = new View();
		$sFileTypeTexts = $oView->getFileTypeTexts();
		$aMsg = $oView->addViewFile();
		$APP->VIEWPARTS = array('header.main', 'viewfiles-add', 'footer.main');
		$APP->PAGEVARS['title'] = 'Add '.$sFileTypeTexts.' | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'Add '.$sFileTypeTexts;
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=40&VFT='.$_GET['VFT'].'">List of '.$sFileTypeTexts.'s</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
    break;
    case '42': // Edit View File
		$sFile      = $_GET['File'];
		$oView      = new View();
		$sFileTypeTexts = $oView->getFileTypeTexts();
		$aMsg = $oView->editViewFile();
		$sFileContent = $oView->listEachFile($sFile);
		$APP->VIEWPARTS = array('header.main', 'viewfiles-edit', 'footer.main');
		$APP->PAGEVARS['title'] = 'Edit '.$sFileTypeTexts.' | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'Edit '.$sFileTypeTexts.': <em>'.$_GET['File'].'</em>';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=40&VFT='.$_GET['VFT'].'">List of '.$sFileTypeTexts.'s</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
	break;
	case '43': // Delete View File
		$sFile = $_GET['File'];
		$oView = new View();
		$sFileTypeTexts = $oView->getFileTypeTexts();
		$aMsg = $oView->deleteViewfile($sFile);
	break;
    case '50': // List Configuration Variables
		$oConfiguration = new Configuration();          	  		
		$aConfigDetails = $oConfiguration->getConfigSortList();
		$APP->VIEWPARTS = array('header.main', 'configurations', 'footer.main');
		$APP->PAGEVARS['title'] = 'List of Configuration Variables | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'List of Configuration Variables';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
	break;	
	case '51': // Add Configuration Variable
		$oConfiguration = new Configuration();
		if(isset($_POST['hidAddStatus']) && $_POST['hidAddStatus'] == '1')
		{
			$aMsg = $oConfiguration->addConfiguration();
		}
		else
		{
			$aMsg[0] = "Please fill up the following form to create a new configuration variable. The variable name must be unique.";
			$aMsg[1] = "ui-state-highlight ui-corner-all ui-message-box";
			$aMsg[2] = "ui-icon ui-icon-info";
		}
		$APP->VIEWPARTS = array('header.main', 'configuration-add', 'footer.main');
		$APP->PAGEVARS['title'] = 'Add Configuration Variable | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'Add Configuration Variable';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=50">Manage Configuration</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
	break;
	case '52': // Edit Configuration Variable
		$iRecID              = $_GET['RecID'];
		$oConfiguration      = new Configuration();      
		if(isset($_POST['hidEditStatus']))
		{		
			$oConfiguration->editConfiguration($iRecID);				 
		}
		else
		{
			$aMsg[0] = "Please edit the details of the configuration variable in the form below. You cannot edit the Variable Name";
			$aMsg[1] = "ui-state-highlight ui-corner-all ui-message-box";
			$aMsg[2] = "ui-icon ui-icon-info";
		}
		$aEachConfigDetails   = $oConfiguration->listEachConfiguration($iRecID);
		$APP->VIEWPARTS = array('header.main', 'configuration-edit', 'footer.main');
		$APP->PAGEVARS['title'] = 'Edit Configuration Variable | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'Edit Configuration Variable';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=50">Manage Configuration</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
	break;	
	case '53': // Delete Application Configuration Variable
		$iRecID = $_GET['RecID'];		
		if($iRecID)
		{
			$oConfiguration      = new Configuration();      		
			$oConfiguration->deleteConfiguration($iRecID);						 
		}		
	break;
	case '54': // Sort the display of Configuration Variables
		$oConfiguration      = new Configuration();      		
		if($_POST['hidArrStatus'])
		{
			$oConfiguration->sortConfiguration();	
		}
		else
		{
			$aMsg[0] = "Please use up and down arrows to sort the display order of configuration variables. This has no other utility except having a display order on IDE.";
			$aMsg[1] = "ui-state-highlight ui-corner-all ui-message-box";
			$aMsg[2] = "ui-icon ui-icon-info";
		}
	    $aSortedConfigList   = $oConfiguration->getConfigSortList();		
		$APP->VIEWPARTS = array('header.main', 'configuration-arrange', 'footer.main');
		$APP->PAGEVARS['title'] = 'Sort Display Order of Configuration Variables | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'Sort Display Order of Configuration Variables';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=50">Manage Configuration</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
	break;
    case '60': 
        $APP->VIEWPARTS = array('header.main', 'users', 'footer.main');
	    $APP->PAGEVARS['title'] = 'USERS | OSF IDE';    				
	break; 
    case '61': 
    	$oUsers = new Users();          	  		
		$oUsers->display();		
	break;	
	case '62': 
    	$oUsers = new Users();      	  		
		$oUsers->execute();		
	break;	
	 case '63': 
		$oUsers          = new Users();          	  		
		$aUsersDetails   = $oUsers->listPage();
		$APP->VIEWPARTS  = array('header.main', 'users', 'footer.main');
	    $APP->PAGEVARS['title'] = 'List of Users | OSF IDE'; 
	    $APP->PAGEVARS['headertext'] = 'List of Users';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';   	
    break;	
    case '64': // Add User
		$oUsers          = new Users();
		if(isset($_POST['hidAddStatus']))
		{			      
			$aMsg = $oUsers->addUser();
		}
		else
		{
			$aMsg[0] = "Please fill up the following form to create a new user. The <strong>username</strong> and <strong>email</strong> must be unique.";
			$aMsg[1] = "ui-state-highlight ui-corner-all ui-message-box";
			$aMsg[2] = "ui-icon ui-icon-info";
		}
		$APP->VIEWPARTS  = array('header.main', 'users-add', 'footer.main');
	    $APP->PAGEVARS['title'] = 'Add User | OSF IDE';    
	    $APP->PAGEVARS['headertext'] = 'Add User';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=63">List of Users</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
    break;
    case '65': // Edit User
		$iRecID = $_GET['RecID'];
		$oUsers = new Users();
		if(isset($_POST['hidEditStatus']))
		{		
			$aMsg = $oUsers->editUser($iRecID);				 
		}
		else
		{
			$aMsg[0] = "Please use the following form to edit user details. The <strong>username</strong> and <strong>email</strong> must be unique.";
			$aMsg[1] = "ui-state-highlight ui-corner-all ui-message-box";
			$aMsg[2] = "ui-icon ui-icon-info";
		}
		$aEachUsersDetails   = $oUsers->listEachUser($iRecID);		
		$APP->VIEWPARTS = array('header.main', 'users-edit', 'footer.main');
		$APP->PAGEVARS['title'] = 'Edit User | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'Edit User - <em>'.stripslashes($aEachUsersDetails[0]['username']).'</em>';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=63">List of Users</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
	break;
	case '66': // Delete User
	    $oUsers = new Users(); 	    		
		$iRecID = $_GET['RecID'];
		$aEachUsersDetails   = $oUsers->listEachUser($iRecID);			
		$aMsg = $oUsers->deleteUser($iRecID);
	break;
	case '67': // Sort Users
		$oUsers = new Users();        		
		if($_POST['hidArrStatus'])
		{
			if($oUsers->sortUsers()) 
			{
				$sPath = $_SERVER['PHP_SELF'].'?ID=63';	
				header("Location: $sPath");
				exit();
			}	
		}		
	    $aSortedUsersList   = $oUsers->getUsersSortList();		
		$APP->VIEWPARTS = array('header.main', 'users-arrange', 'footer.main');
		$APP->PAGEVARS['title'] = 'Arrange Users | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'Arrange Users';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=63">Users</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
	break;
   case '70': // List User Roles
		$oRoles         = new Roles();          	  		
		$aRolesDetails  = $oRoles->listPage();	
		$APP->VIEWPARTS = array('header.main', 'roles', 'footer.main');
		$APP->PAGEVARS['title'] = 'List of User Roles | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'List of User Roles';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
	break;		
	case '71': // Add User Role
		$oRoles      = new Roles();
		if(isset($_POST['hidAddStatus']))
		{			      
			$aMsg = $oRoles->addRole();
		}
		else
		{
			$aMsg[0] = "Please fill up the following form to add an user role.";
			$aMsg[1] = "ui-state-highlight ui-corner-all ui-message-box";
			$aMsg[2] = "ui-icon ui-icon-info";
		}
		$APP->VIEWPARTS = array('header.main', 'role-add', 'footer.main');
		$APP->PAGEVARS['title'] = 'Add User Role | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'Add User Role';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=70">List of User Roles</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
	break;
	case '72': // Edit User Role
		$iRecID = $_GET['RecID'];
		$oRoles      = new Roles();      
		if(isset($_POST['hidEditStatus']))
		{		
			$aMsg = $oRoles->editRole($iRecID);				 
		}
		else
		{
			$aMsg[0] = "Please use the following form to edit role details. The <strong>Role Name</strong> must be unique.";
			$aMsg[1] = "ui-state-highlight ui-corner-all ui-message-box";
			$aMsg[2] = "ui-icon ui-icon-info";
		}
		$aEachRoleDetails = $oRoles->listEachRole($iRecID);
		$APP->VIEWPARTS = array('header.main', 'role-edit', 'footer.main');
		$APP->PAGEVARS['title'] = 'Edit User Role | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'Edit User Role - '.$aEachRoleDetails[0]['rolename'];
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=70">List of User Roles</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
	break;
	case '73': // Delete User Role
		$iRecID = $_GET['RecID'];
		$oRoles         = new Roles();
		$aMsg = $oRoles->deleteRole($iRecID);
	break;
	case '74': // Sort Display Order of User Roles
		$oRoles      = new Roles();
		if($_POST['hidArrStatus'])
		{
			$oRoles->sortRoles();
		}
		else
		{
			$aMsg[0] = "Please use up and down arrows to sort the display order of user roles. This has no other utility except having a display order on IDE.";
			$aMsg[1] = "ui-state-highlight ui-corner-all ui-message-box";
			$aMsg[2] = "ui-icon ui-icon-info";
		}		
	    $aSortedRolesList   = $oRoles->getRolesSortList();		
		$APP->VIEWPARTS = array('header.main', 'roles-arrange', 'footer.main');
		$APP->PAGEVARS['title'] = 'Sort Display Order of User Roles | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'Sort Display Order of User Roles';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=70">List of User Roles</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
	break;
	case '80': // Lifestream listing
		$oLifestream = new Lifestream();
		$aListofFiles = $oLifestream->listLogFiles();
		$aMsg = $oLifestream->getListPageMessage();
	    $APP->VIEWPARTS = array('header.main', 'lifestream', 'footer.main');
		$APP->PAGEVARS['title'] = 'Lifestream | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'Lifestream';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
	break;
	case '81': // View Lifestream History Log
		$sFile = $_GET['File'];
		$oLifestream = new Lifestream();   
		$sFileContent = $oLifestream->ViewLogFile($sFile);
		$APP->VIEWPARTS = array('header.main', 'lifestream-view', 'footer.main');
		$APP->PAGEVARS['title'] = 'View Lifestream Log - '.$sFile.' | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'View Lifestream Log - <em>'.$sFile.'</em>';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=80">List of Lifestream Log Files</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
	break;
	case '82': // Remove Lifestream Log of A Day
		$sFile = $_GET['File'];
		$oLifestream = new Lifestream();   
		$aMsg = $oLifestream->deleteLog($sFile);
	break;
	case '83': // Remove Lifestream History
		$oLifestream = new Lifestream();   
		$aMsg = $oLifestream->deleteHistory();
	break;
	case '90':// List View Page Variables	
		$oPagevars       = new Pagevars();	
		$aPagevarDetails = $oPagevars->listPage();
		$APP->VIEWPARTS  = array('header.main', 'pagevars', 'footer.main');
		$APP->PAGEVARS['title'] = 'View Page Variables | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'View Page Variables';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
	break;	
	case '91': // Add View Page Variable
		$oPagevars      = new Pagevars();
		if(isset($_POST['hidAddStatus']))
		{			 
		    $aMsg = $oPagevars->addPagevars();
		}
		else
		{
			$aMsg[0] = "Please fill up the following form to create a new configuration variable. The variable name must be unique.";
			$aMsg[1] = "ui-state-highlight ui-corner-all ui-message-box";
			$aMsg[2] = "ui-icon ui-icon-info";
		}
		$APP->VIEWPARTS = array('header.main', 'pagevars-add', 'footer.main');
		$APP->PAGEVARS['title'] = 'Add Page Variable | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'Add Page Variables';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=90">View Page Variables</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
	break;
	case '92':// Edit View Page Variables (NOT in operation now)
		$iRecID 	 = $_GET['RecID'];
		$oPagevars   = new Pagevars();      
		if($_POST['hidEditStatus'])
		{		
			$aMsg = $oPagevars->editPagevars($iRecID);				 
		}
		else
		{
			$aMsg[0] = "Please edit the Page Variable Key with the form below. The variable name must be unique.";
			$aMsg[1] = "ui-state-highlight ui-corner-all ui-message-box";
			$aMsg[2] = "ui-icon ui-icon-info";
		}
		$aEachPagevarDetails   = $oPagevars->listEachPagevars($iRecID);
		$APP->VIEWPARTS = array('header.main', 'pagevars-edit', 'footer.main');
		$APP->PAGEVARS['title'] = 'Edit Page Variables | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'Edit Page Variables';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=90">View Page Variables</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
	break;
	case '93': // Delete View Page Variable
		$iRecID = $_GET['RecID'];
		if($iRecID)
		{
			$oPagevars   = new Pagevars();
			$oPagevars->deletePagevars($iRecID);
		}
	break;
	case '100': // Application Settings View Page
		$oSys            = new Sys();
		$aSysDetails     = $oSys->listPage();
		$APP->VIEWPARTS  = array('header.main', 'sys', 'footer.main');
		$APP->PAGEVARS['title'] = 'Application Settings | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'Application Settings';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
	break;	
	case '101': // Add Application [ NOT TO BE USED]
		$oSys            = new Sys();
		if($_POST['hidAddStatus'])
		{			      
			if($oSys->addSys()) 
			{
				$sPath = $_SERVER['PHP_SELF'].'?ID=100';	
				header("Location: $sPath");
				exit();
			}		 
		}   	
		$APP->VIEWPARTS = array('header.main', 'sys-add', 'footer.main');
		$APP->PAGEVARS['title'] = 'Add Settings | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'Add Settings';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=90">Application Settings</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
	break;
	case '102': // Edit Application Settings
		$iRecID 	 = $_GET['RecID'];
		$oSys        = new Sys();      
		if($_POST['hidEditStatus'])
		{		
			$oSys->editSys($iRecID);
		}
		else
		{
			$aMsg[0] = "Please edit the application settings with the form below. Please be very careful as it may affect the working of application.";
			$aMsg[1] = "ui-state-highlight ui-corner-all ui-message-box";
			$aMsg[2] = "ui-icon ui-icon-info";
		}
		$aEachSysDetails   = $oSys->listEachSys($iRecID);
		$oUsers = new Users();
		$APP->VIEWPARTS = array('header.main', 'sys-edit', 'footer.main');
		$APP->PAGEVARS['title'] = 'Edit Application Settings | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'Edit Application Settings';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=100">Application Settings</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
	break;
	case '103':	 // Delete Application [ NOT TO BE USED]
		$iRecID = $_GET['RecID'];
		if($iRecID)
		{
			$oSys        = new Sys();
			if($oSys->deleteSys($iRecID))
			{
				$sPath = $_SERVER['PHP_SELF'].'?ID=100';
				header("Location: $sPath");
				exit();
			}
		}
	break;
	case '104': // Change Password
	    $oProfile = new Profile();
		if(isset($_POST['hidPwd']))
		{
			$aMsg = $oProfile->changePassword($USER->ID);
		}
		else
		{
			if (isset($_GET['PF']) && $_GET['PF'] == '1')
			{
				$aMsg[0] = '2';
				$aMsg[1] = "Your password has been changed successfully.";
			}
			else
			{
				$aMsg[0] = '0';
				$aMsg[1] = "Change your password with the form below.";
			}
		}
		$APP->VIEWPARTS = array('header.main', 'change-password', 'footer.main');
		$APP->PAGEVARS['title'] = 'Change Password | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'Change Password';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
	break;
	case '105': // Case for "Select Events in Role Page" 
	    $sSelectEvent = '';
	    if ($_POST['requestctrlid'])
		{   
		    $oControllers    = new Controllers();
		    $aEventDetails   = $oControllers->listEventPage($_POST['requestctrlid']);
	    }
	    $APP->VIEWPARTS = array('role-eventselect');
	break;
	case '106':
	    if ($_POST['requestctrlid'])
		{ 
		    $oControllers    = new Controllers();
		    $sExecute = $oControllers->changeStatus($_POST['requeststatus'], $_POST['requestctrlid']);
		    if($sExecute) print '1';
		    else  print '2';
		}
	break;
	case '107':
	    if ($_POST['requestctrlid'])
		{ 
		    $oControllers    = new Controllers();
		    $sExecute = $oControllers->changePublic($_POST['requestpublic'], $_POST['requestctrlid']);
		    if($sExecute) print '1';
		    else  print '2';
		}
	break;
	case '108':
	    if ($_POST['requesteventid'])
		{ 
		    $oControllers    = new Controllers();
		    $sExecute = $oControllers->changeEventStatus($_POST['requeststatus'], $_POST['requesteventid']);
		    if($sExecute) print '1';
		    else  print '2';
		}
	break;
	case '109': // Change User Status
	    if ($_POST['requestuserid'])
		{ 
		    $oUsers          = new Users();
		    $oUsers->changeStatus($_POST['requeststatus'], $_POST['requestuserid']);
		}
	break;
	case '110': // SSO Setup
		$iRecID 	 = $_GET['RecID'];
		$oSys        = new Sys();      
		if($_POST['hidEditStatus'])
		{		
			$oSys->editSSO($iRecID);
			$_SESSION['ERROR_CODE'] = '2';
			$_SESSION['ERROR_MSG'] = 'The SSO settings have successfully been edited.';
		}
		else $_SESSION['ERROR_CODE'] = '0';
		$aSSOSettings   = $oSys->listSSOSettings();
		$APP->VIEWPARTS = array('header.main', 'sso', 'footer.main');
		$APP->PAGEVARS['title'] = 'SSO Settings | OSF IDE';
		$APP->PAGEVARS['headertext'] = 'SSO Settings';
		$APP->PAGEVARS['breadcrumb'] = '<li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=1">Dashboard</a></li><li><a href="'.$APP->BASEURL.'/osf/ide/index.php?ID=100">Application Settings</a></li><li class="active">'.$APP->PAGEVARS['headertext'].'</li>';
	break;
	default:
		//
	break;
} //End of switch statement
if(!empty($APP->VIEWPARTS)) 
{
	foreach($APP->VIEWPARTS as $sViewPart) include(dirname(__FILE__).'/html/'.$sViewPart.'.tpl.php');
}
?>