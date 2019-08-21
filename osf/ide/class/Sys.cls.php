<?php
/*------------------------------------------------------------------------------+
 * Opendelight - A PHP based Rapid Web Application Development Framework        |
 * (c)Copyright Batoi Systems Pvt Ltd. All rights reserved.                     |
 * Author: Ashwini Kumar Rath - www.ashwinirath.com                             |
 * Website of Opendelight: http://www.batoi.com/opendelight                     |
 * Licensed under the terms of the GNU General Public License Version 2 or later|
 * (the "GPL"): http://www.gnu.org/licenses/gpl.html                            |
 * NOTE: The copyright notice like this on any of the distributed files         |
 *       (downloaded or obtained as the part of Opendelight) must NOT be        |
 *       removed or modified.                                                   |
 *------------------------------------------------------------------------------+
 */
class Sys
{
	/* CONSTRUCTOR */
	function __construct() 
	{
	    global $DB,$APP,$USER;
		$this->DB   = $DB;
		$this->APP  = $APP;	
		$this->USER = $USER;	
		return true;
	}
	
	/* List Application Settings */
	function listPage() 
	{
		$sSqlData = "SELECT sysid, appname, author, description, baseurl, ssodefaultroleid, logstatus, sysstatus FROM {$this->APP->TABLEPREFIX}od_sys WHERE sysid <> ''"; 
		$oStmt    = $this->DB->prepare($sSqlData);		
	    $oStmt->execute();		
		$aRowData = $oStmt->fetchAll();
		return $aRowData;		
	}    
	
	/* Add Application Settings - NOT USED ANY MORE */
	function addSys()
	{
	   //$sQry   =  "INSERT INTO {$this->APP->TABLEPREFIX}od_sys SET appname = :appname, author = :author, description = :description, sysstatus = :sysstatus";
	   //$oStmt  = $this->DB->prepare($sQry);
	   //$oStmt->bindParam(':appname', $_POST['txtAppName']);
	   //$oStmt->bindParam(':author', $_POST['txtAuthor']);
	   //$oStmt->bindParam(':description', $_POST['txtDescription']);
	   //$oStmt->bindParam(':sysstatus', $_POST['selStatus']);
	   //$oStmt->execute();	
	   return true;
	}
	
	/* Get details of Application Setting */
	function listEachSys($iRecID) 
	{
		$sSqlData = "SELECT sysid, appname, author, description, logstatus, sysstatus, baseurl, ssodefaultroleid FROM {$this->APP->TABLEPREFIX}od_sys WHERE sysid = :sysid"; 
		$oStmt    = $this->DB->prepare($sSqlData);		
		$oStmt->bindParam(':sysid', $iRecID);
	    $oStmt->execute();		
		$aRowData = $oStmt->fetchAll();
		return $aRowData;		
	}
	
	/* Edit Application Settings */
	function editSys($iRecID)
	{
	   $sQry   =  "UPDATE {$this->APP->TABLEPREFIX}od_sys SET appname = :appname, author = :author, description = :description, ssodefaultroleid = :ssodefaultroleid, logstatus = :logstatus, sysstatus = :sysstatus WHERE sysid = :sysid";
	   $oStmt  = $this->DB->prepare($sQry);
	   $oStmt->bindParam(':appname', $_POST['txtAppName']);
	   $oStmt->bindParam(':author', $_POST['txtAuthor']);
	   $oStmt->bindParam(':description', $_POST['taDescription']);
	   $oStmt->bindParam(':ssodefaultroleid', $_POST['ssodefaultroleid']);
	   $oStmt->bindParam(':logstatus', $_POST['radLog']);
	   $oStmt->bindParam(':sysstatus', $_POST['radStatus']);
	   $oStmt->bindParam(':sysid', $iRecID);
	   $oStmt->execute();
	   $_SESSION['ERROR_CODE'] = 2;
	   $sPath = $_SERVER['PHP_SELF'].'?ID=100';
	   header("Location: $sPath");
	   exit();
	   return true;;	
	}
	
	/* Delete Application Settings - NOT IN USE */
	function deleteSys($iRecID)
	{
		//$sQry = "DELETE from {$this->APP->TABLEPREFIX}od_sys WHERE sysid = :sysid";
		//$oStmt = $this->DB->prepare($sQry);
		//$oStmt->bindParam(':sysid', $iRecID);	
		//$oStmt->execute();	
		return true;	
	}
	
	/* Edit SSO Settings */
	function editSSO($iRecID)
	{
		//print_r($_POST);
		$aYahoo = array();
		if( isset($_POST['ssoyahoo']) && ($_POST['ssoyahoo'] == 'yahoo') )
		{
			$aYahoo['key'] = trim($_POST['txtYahooClientID']);
			$aYahoo['secret'] = trim($_POST['txtYahooClientSecret']);
		}
		else{
			$aYahoo['key'] = '';
			$aYahoo['secret'] = '';
		}
		$aGoogle = array();
		if( isset($_POST['ssogoogle']) && ($_POST['ssogoogle'] == 'google') )
		{
			$aGoogle['key'] = trim($_POST['txtGoogleClientID']);
			$aGoogle['secret'] = trim($_POST['txtGoogleClientSecret']);
		}
		else{
			$aGoogle['key'] = '';
			$aGoogle['secret'] = '';
		}
		
		$aFacebook = array();
		if( isset($_POST['ssofacebook']) && ($_POST['ssofacebook'] == 'facebook') )
		{
			$aFacebook['key'] = trim($_POST['txtFacebookClientID']);
			$aFacebook['secret'] = trim($_POST['txtFacebookClientSecret']);
		}
		else{
			$aFacebook['key'] = '';
			$aFacebook['secret'] = '';
		}
		
		$aTwitter = array();
		if( isset($_POST['ssotwitter']) && ($_POST['ssotwitter'] == 'twitter') )
		{
			$aTwitter['key'] = trim($_POST['txtTwitterClientID']);
			$aTwitter['secret'] = trim($_POST['txtTwitterClientSecret']);
		}
		else{
			$aTwitter['key'] = '';
			$aTwitter['secret'] = '';
		}
		
		$aLive = array();
		if( isset($_POST['ssolive']) && ($_POST['ssolive'] == 'live') )
		{
			$aLive['key'] = trim($_POST['txtLiveClientID']);
			$aLive['secret'] = trim($_POST['txtLiveClientSecret']);
		}
		else{
			$aLive['key'] = '';
			$aLive['secret'] = '';
		}
		$sAuthConfigFileContent = <<< AUTHCONFIG
<?php

/**
 * HybridAuth
 * http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
 * (c) 2009-2015, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
 */
// ----------------------------------------------------------------------------------------
//	HybridAuth Config file: http://hybridauth.sourceforge.net/userguide/Configuration.html
// ----------------------------------------------------------------------------------------

return
		array(
			"base_url" => "{$this->APP->BASEURL}/osf/lib/hybridauth/",
			"providers" => array(
				// openid providers
				"OpenID" => array(
					"enabled" => true
				),
				"Yahoo" => array(
					"enabled" => true,
					"keys" => array("key" => "{$aYahoo['key']}", "secret" => "{$aYahoo['secret']}"),
				),
				"Google" => array(
					"enabled" => true,
					"keys" => array("id" => "{$aGoogle['key']}", "secret" => "{$aGoogle['secret']}"),
				),
				"Facebook" => array(
					"enabled" => true,
					"keys" => array("id" => "{$aFacebook['key']}", "secret" => "{$aFacebook['secret']}"),
					"trustForwarded" => false
				),
				"Twitter" => array(
					"enabled" => true,
					"keys" => array("key" => "{$aTwitter['key']}", "secret" => "{$aTwitter['secret']}"),
					"includeEmail" => false
				),
				// windows live
				"Live" => array(
					"enabled" => true,
					"keys" => array("id" => "{$aLive['key']}", "secret" => "{$aLive['secret']}")
				),
			),
			// If you want to enable logging, set 'debug_mode' to true.
			// You can also set it to
			// - "error" To log only error messages. Useful in production
			// - "info" To log info and error messages (ignore debug messages)
			"debug_mode" => false,
			// Path to file writable by the web server. Required if 'debug_mode' is not false
			"debug_file" => "",
);
?>
AUTHCONFIG;
		$sAuthConfigFile = dirname(dirname(realpath(dirname(__FILE__)))) . "/lib/hybridauth/config.php";
		file_put_contents($sAuthConfigFile, $sAuthConfigFileContent);
	   $_SESSION['ERROR_CODE'] = 2;
	   $sPath = $_SERVER['PHP_SELF'].'?ID=110';
	   header("Location: $sPath");
	   exit();
	   return true;;	
   }
   
   /* Get SSO Settings */
	function listSSOSettings()
	{
		$sAuthConfigFile = dirname(dirname(realpath(dirname(__FILE__)))) . "/lib/hybridauth/config.php";
		$aSSOSettings = include $sAuthConfigFile;
		//print_r($sAuthConfigFileContent);exit();
		return $aSSOSettings;
	}
	
} //END OF CLASS
?>