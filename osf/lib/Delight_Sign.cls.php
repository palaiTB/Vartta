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
class Delight_Sign
{
	public $sLoginToken;

	/* CONSTRUCTOR */
	public function __construct()
	{
		global $DB,$APP,$USER;
		$this->DB  = $DB;
		$this->APP = $APP;
		$sToken                  = md5(rand());
		$_SESSION['SigninToken'] = $sToken;
		$this->sLoginToken       = $sToken;
		return true;
	}

	/* Validate */
	public function signin($aForm, $sToken)
	{
		if(!($_SESSION['SigninToken'] == $sToken))
		{
			header("Location: $_SERVER[PHP_SELF]");
			exit();
		}
		$sUsername     = $aForm['txtUsername']['sanitized_field_value'];
		$sPassword     = md5($aForm['txtPassword']['sanitized_field_value']);
		$sQryUser      = "SELECT userid, idverifier, roleid FROM {$this->APP->TABLEPREFIX}od_user WHERE username = :username AND password = :password AND userstatus = '1'";
		$oStmt    	   = $this->DB->prepare($sQryUser);
		$oStmt->bindParam(':username',$sUsername);
		$oStmt->bindParam(':password',$sPassword);
		$oStmt->execute();
		$iRecordNumber  = $oStmt->rowCount();
		if($iRecordNumber == 1)
		{
		    $aRows  	= $oStmt->fetchAll();
		    foreach($aRows as $aRow)
			{
			    $this->iRole      = stripslashes($aRow['roleid']);
			    $sQry  = "SELECT roles FROM {$this->APP->TABLEPREFIX}od_event WHERE eventid = :eventid";
		   	    $oStmt = $this->DB->prepare($sQry);
				$oStmt->bindParam(':eventid', $this->APP->ID);
				$oStmt->execute();
				$iNumRows  = $oStmt->rowCount();

				if($iNumRows == 1)
			    {
			        $aNumRows    	   = $oStmt->fetchAll();
			        foreach($aNumRows as $aNumRow)
					{
					    $sRoles   = stripslashes($aNumRow['roles']);
					}
					$aRoles = explode(',', $sRoles);
					if (!in_array($this->iRole, $aRoles)) $bAllowAccess  = false;
			        else
	                {
					    $sErrMsg = '';
			            $_SESSION['USERID'] = stripslashes($aRow['userid']);
			            $_SESSION['IDVERIFIER'] = stripslashes($aRow['idverifier']);
					    $bAllowAccess  = true;
	                }
			    }
			    else $bAllowAccess  = false;

			}
		}
		else $bAllowAccess  = false;
		//print_r($_SESSION);exit();
		if($bAllowAccess)
		{
			if($_SESSION['REQUESTURL'])
		{
			if ($this->iRole == '5') {
				 $sRedirectPath = $this->APP->BASEURL;
			} else {
				 $sRedirectPath = $_SESSION['REQUESTURL'];
			}
			   header ("Location:{$sRedirectPath}");
			   exit();
			}
		    else
			{
				$sQry  = "SELECT defaultctrid, defaulteventid FROM {$this->APP->TABLEPREFIX}od_role WHERE roleid = :roleid";
		   	    $oStmt = $this->DB->prepare($sQry);
				$oStmt->bindParam(':roleid', $this->iRole);
				$oStmt->execute();
                $aRows = $oStmt->fetchAll();
                foreach($aRows as $aRow)
				{
					$iDefaultCtrID   = stripslashes($aRow['defaultctrid']);
					$iDefaultEventID = stripslashes($aRow['defaulteventid']);
				}
				$sQry  = "SELECT ctrname FROM {$this->APP->TABLEPREFIX}od_controller WHERE ctrid = :ctrid";
			   	$oStmt = $this->DB->prepare($sQry);
				$oStmt->bindParam(':ctrid', $iDefaultCtrID);
				$oStmt->execute();
				$aRows = $oStmt->fetchAll();
			    foreach($aRows as $aRow)
				{
				    $sDefaultCtrlName   = stripslashes($aRow['ctrname']);
				}
				$sRedirectPath = $this->APP->BASEURL.'/'.$sDefaultCtrlName.'?ID='.$iDefaultEventID;
				//print $sRedirectPath;exit();
			    header("Location: $sRedirectPath");
			    exit();
			}
		}
		else
		{
		    $sErrMsg = 'Username/ Password NOT correct!';
			return $sErrMsg;
		}
	}

	/* Signin by 3rd party IDP */
	public function signinIDP()
	{
		$sUsername     = $_SESSION['USERNAME'];
		$sPassword     = md5($_SESSION['IDP']);
		$sQryUser      = "SELECT userid, idverifier, roleid FROM {$this->APP->TABLEPREFIX}od_user WHERE username = :username AND idprovider = :idprovider AND idverifier = :idverifier AND userstatus = '1'";
		$oStmt    	   = $this->DB->prepare($sQryUser);
		$oStmt->bindParam(':username',$sUsername);
		$oStmt->bindParam(':idprovider',$_SESSION['IDP']);
		$oStmt->bindParam(':idverifier',$_SESSION['IDVERIFIER']);
		$oStmt->execute();
		$iRecordNumber  = $oStmt->rowCount();
		//print '$iRecordNumber = '.$iRecordNumber;exit();
		if($iRecordNumber == 1)
		{
		    $aRows  	= $oStmt->fetchAll();
		    foreach($aRows as $aRow)
			{
			    $this->iRole      = stripslashes($aRow['roleid']);
			    $sQry  = "SELECT roles FROM {$this->APP->TABLEPREFIX}od_event WHERE eventid = :eventid";
		   	    $oStmt = $this->DB->prepare($sQry);
				$oStmt->bindParam(':eventid', $this->APP->ID);
				$oStmt->execute();
				$iNumRows  = $oStmt->rowCount();

				if($iNumRows == 1)
			    {
			        $aNumRows    	   = $oStmt->fetchAll();
			        foreach($aNumRows as $aNumRow)
					{
					    $sRoles   = stripslashes($aNumRow['roles']);
					}
					$aRoles = explode(',', $sRoles);
					if (!in_array($this->iRole, $aRoles)) $bAllowAccess  = false;
			        else
	                {
					    $sErrMsg = '';
			            $_SESSION['USERID'] = stripslashes($aRow['userid']);
			            $_SESSION['IDVERIFIER'] = stripslashes($aRow['idverifier']);
					    $bAllowAccess  = true;
	                }
			    }
			    else $bAllowAccess  = false;

			}
		}
		else $bAllowAccess  = false;
		//print_r($_SESSION);exit();
		if($bAllowAccess)
		{
		    if($_SESSION['REQUESTURL'])
			{
			   //print_r($_SESSION);exit();
			   //$sRedirectPath = $this->APP->BASEURL.$_SESSION['REQUESTURL'];
			   $sRedirectPath = $_SESSION['REQUESTURL'];
			   //print $sRedirectPath;exit();
			   header ("Location:{$sRedirectPath}");
			   exit();
			}
		    else
			{
				$sQry  = "SELECT defaultctrid, defaulteventid FROM {$this->APP->TABLEPREFIX}od_role WHERE roleid = :roleid";
		   	    $oStmt = $this->DB->prepare($sQry);
				$oStmt->bindParam(':roleid', $this->iRole);
				$oStmt->execute();
                $aRows = $oStmt->fetchAll();
                foreach($aRows as $aRow)
				{
					$iDefaultCtrID   = stripslashes($aRow['defaultctrid']);
					$iDefaultEventID = stripslashes($aRow['defaulteventid']);
				}
				$sQry  = "SELECT ctrname FROM {$this->APP->TABLEPREFIX}od_controller WHERE ctrid = :ctrid";
			   	$oStmt = $this->DB->prepare($sQry);
				$oStmt->bindParam(':ctrid', $iDefaultCtrID);
				$oStmt->execute();
				$aRows = $oStmt->fetchAll();
			    foreach($aRows as $aRow)
				{
				    $sDefaultCtrlName   = stripslashes($aRow['ctrname']);
				}
				$sRedirectPath = $this->APP->BASEURL.'/'.$sDefaultCtrlName.'?ID='.$iDefaultEventID;
				//print $sRedirectPath;exit();
			    header("Location: $sRedirectPath");
			    exit();
			}
		}
		else
		{
		    $sLastLogin  = gmdate("Y-m-d H:i:s");
			$sIDProvider = $_SESSION['IDP'];
			$sUserToken  = $_SESSION['IDVERIFIER'];
			$sPasswordTemp = md5($_SESSION['IDP']);
			if(trim($_SESSION['LASTNAME']) == '') $_SESSION['LASTNAME'] = ' ';
			$iUserStatus = '1';
			$sQry  =  "INSERT INTO {$this->APP->TABLEPREFIX}od_user (idprovider, idverifier, username, password, email, firstname, lastname, userstatus, roleid, lastlogin) VALUES (:idprovider, :idverifier, :username, :password, :email, :firstname, :lastname, :userstatus, :roleid, :lastlogin)";
			$oStmt = $this->DB->prepare($sQry);
			$oStmt->bindParam(':idprovider', $sIDProvider);
			$oStmt->bindParam(':idverifier', $sUserToken);
			$oStmt->bindParam(':username', $_SESSION['USERNAME']);
			$oStmt->bindParam(':password', $sPasswordTemp);
			$oStmt->bindParam(':email', $_SESSION['USERNAME']);
			$oStmt->bindParam(':firstname', $_SESSION['FIRSTNAME']);
			$oStmt->bindParam(':lastname', $_SESSION['LASTNAME']);
			$oStmt->bindParam(':userstatus', $iUserStatus);
			$oStmt->bindParam(':roleid', $this->APP->iSSODefaultRole);
			$oStmt->bindParam(':lastlogin', $sLastLogin);
			$oStmt->execute();
			//echo $oStmt->debugDumpParams();
			//echo var_export($oStmt->errorInfo());exit();
			$sQry  = "SELECT defaultctrid, defaulteventid FROM {$this->APP->TABLEPREFIX}od_role WHERE roleid = :roleid";
		   	$oStmt = $this->DB->prepare($sQry);
			$oStmt->bindParam(':roleid', $this->APP->iSSODefaultRole);
			$oStmt->execute();
            $aRows = $oStmt->fetchAll();
            foreach($aRows as $aRow)
			{
				$iDefaultCtrID   = stripslashes($aRow['defaultctrid']);
				$iDefaultEventID = stripslashes($aRow['defaulteventid']);
			}
			$sQry  = "SELECT ctrname FROM {$this->APP->TABLEPREFIX}od_controller WHERE ctrid = :ctrid";
		   	$oStmt = $this->DB->prepare($sQry);
			$oStmt->bindParam(':ctrid', $iDefaultCtrID);
			$oStmt->execute();
			$aRows = $oStmt->fetchAll();
		    foreach($aRows as $aRow)
			{
			    $sDefaultCtrlName   = stripslashes($aRow['ctrname']);
			}
			$sRedirectPath = $this->APP->BASEURL.'/'.$sDefaultCtrlName.'?ID='.$iDefaultEventID;
			//print $sRedirectPath;exit();
		    header("Location: $sRedirectPath");
		    exit();
		}
		return true;
	}

	/* Forgot your password */
    public function getPassword($sForgotPwdSec)
    {
	    $sWebsiteURL     = $this->APP->BASEURL;
	    $sMsg            = '';
	    $sSqlPwdDetails  = "SELECT userid, firstname, username  FROM {$this->APP->TABLEPREFIX}od_user WHERE email = :email";
		$oStmt    	   	 = $this->DB->prepare($sSqlPwdDetails);
		$oStmt->bindParam(':email',$sForgotPwdSec);
		$oStmt->execute();
		$aForgotPwdSec   = $oStmt->fetchAll();
	    $iRecordNumber   = $oStmt->rowCount();
        if($iRecordNumber == 0)
        {
            $sMsg = 'The email id does not exist';
            return $sMsg;
        }
		else
		{
		    foreach($aForgotPwdSec as $aRowPwd)
			{
		    	$sFirstName       = stripslashes(trim($aRowPwd['firstname']));
		    	$iId              = stripslashes(trim($aRowPwd['userid']));
		    	$sUsername        = stripslashes(trim($aRowPwd['username']));
		    	$sPwd             = $this->createPassword();
		    	$sUpdatePassword  = $this->updatePassword($sPwd,$iId);
			}
			// Include file to send the message to the User
			include $this->APP->BASEURL.'/osf/view/forgot-pwd-msg.tpl.php';
			if(mail($sForgotPwdSec, $sSubject, $sMessage, $sHeaders))
			{
				$sMsg  = 'An email has been sent with your sign in details. Please <a href='.$_SERVER[PHP_SELF].' title="Click here">click here</a> to Sign In with the sent details.';
				return $sMsg;
			}
	    }
	}

	/* Function to create a new password */
	private function createPassword($len = 6)
    {
    	$chars = uniqid();
	    $s = "";
	    for ($i = 0; $i < $len; $i++) {
	        $int         = rand(0, strlen($chars)-1);
	        $rand_letter = $chars[$int];
	        $s           = $s . $rand_letter;
	    }
	    return $s;
	}

	/* Function to update password for the user*/
	private function updatePassword($sPassword,$iId)
    {
        $sNewPassword = md5($sPassword);
        $sQry  		  = "UPDATE {$this->APP->TABLEPREFIX}od_user SET password = :password WHERE userid = :userid";
	    $oStmt    	  = $this->DB->prepare($sQry);
		$oStmt->bindParam(':password',$sNewPassword);
		$oStmt->bindParam(':userid',$iId);
		$oStmt->execute();
    	return true;
	}

}//End of class

?>
