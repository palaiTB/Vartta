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
class Lifestream
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
	
	function listLogFiles() 
	{
		$sPath = '../data/log/';
		$aRowData = $this->dirList($sPath);
		return $aRowData;
	}
	
	private function dirList($dir)
    {
    	$dir_handle  = opendir($dir);
        $dir_objects = array();
        while ($object = readdir($dir_handle))
        if (!in_array($object, array('.','..')))
        {
            $filename    = $dir . $object;
            $file_object = array(
                                     'name' => $object,
                                     'size' => ceil(filesize($filename)/1024),                                           
                                     'time' => date("d F Y, g:i a", (filemtime($filename)+60*60*5.5))
                                 );
            $dir_objects[] = $file_object;
         }               
         return $dir_objects;
    }
    
    function ViewLogFile($sFile)
    {
    	$sFileName = '../data/log/'.$sFile;	   
		$handle    = fopen($sFileName, "r");
		$sContents  = fread($handle, filesize($sFileName));
		fclose($handle);
		return $sContents;		
    }
    
    /* get List Page Message */
	function getListPageMessage()
	{
		$aMsg[0] = 0;
		if (isset($_GET['PF']) && $_GET['PF'] == '1') $aMsg[1] = "The Lifestream Log File <strong>{$_GET['PC']}</strong> has successfully been deleted.";
		else if (isset($_GET['PF']) && $_GET['PF'] == '2') $aMsg[1] = "The Lifestream history has successfully been removed.";
		else $aMsg[1] = "The list of lifestream log files (date-wise) have been presented below. Click on file or <strong>View</strong> icon to see the log on a particular date.";
		return $aMsg;
	}
	
	/* Delete Lifestream Log file */
	function deleteLog($sFile)
	{
		if($sFile)
		{
			$sFileName  = '../data/log/'.$sFile;
			if(unlink($sFileName))
			{
				$sPath = $_SERVER['PHP_SELF'].'?ID=80&PF=1&PC='.$sFile;	
				header("Location: $sPath");
				exit();
			}
			else
			{
				$aMsg[0] = 1;
			    $aMsg[1] = "The Lifestream Log file {$sFile} could not be deleted.";
			    return $aMsg;
			}
		}
		else
		{
			$aMsg[0] = 1;
			$aMsg[1] = "System access error!";
			return $aMsg;
		}
		return $aMsg;
	}
	
	/* Remove Lifestream Log History */
	function deleteHistory()
	{
		$sPath = '../data/log/';
		$aRowData = $this->dirList($sPath);
		foreach($aRowData AS $aRow)
		{
		    $sFileName  = '../data/log/'.$aRow[name];
			if(!unlink($sFileName))
			{
				$aMsg[0] = 1;
			    $aMsg[1] = "The Lifestream history could not be removed.";
			    return $aMsg;
			}
		}
		$sPath = $_SERVER['PHP_SELF'].'?ID=80&PF=2';	
		header("Location: $sPath");
		exit();
		return $aMsg;
	}
} //END OF CLASS
?>