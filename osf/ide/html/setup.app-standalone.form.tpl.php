<?php
//print($_SERVER['HTTP_REFERER']);
$aFileFullPath = explode("/delight-ide/install.php", $_SERVER['HTTP_REFERER']);
//$sHost         = $_SERVER['HTTP_HOST'];
$sBaseUrl      = $aFileFullPath[0];
$sOffShoot = '/osf/install/';
if (substr($sBaseUrl,-strlen($sOffShoot))===$sOffShoot) $sBaseUrl = substr($sBaseUrl, 0, strlen($sBaseUrl)-strlen($sOffShoot));
?>
<div class="container" role="main">
	<div class="page-header">
		<h1><?php print $APP->PAGEVARS['headertext'];?></h1>
	</div>
	<form name="frmInstall" id="frmInstall" role="form" method="post" action="<?php print $_SERVER['PHP_SELF'];?>?ID=2">
	<div class="row">
		<div class="col-lg-6 osf-content-left">
			<div class="form-group">
				<label>Application Name</label>
                <input class="form-control" type="text" name="txtAppName" value="" id="txtAppName" class="required">
                <p class="help-block">Name your Application here.</p>
            </div>
		</div>
		<div class="col-lg-6 osf-content-left">
			<div class="form-group">
				<label>Author</label>
                <input class="form-control" type="text" name="txtAuthor" value="" id="txtAuthor" class="required">
                <p class="help-block">You may name the author of the Application</p>
            </div>
		</div>
	</div>
	
	
	<div class="row">
		<div class="col-lg-6 osf-content-left">
			<div class="form-group">
				<label>Application Base URL</label>
                <input type="text" name="txtBaseURL" value="<?php if(isset($_POST['txtBaseURL'])) print $_POST['txtBaseURL']; else print $sBaseUrl;?>"  id="txtBaseURL" class="form-control required" />
                <p class="help-block">There must be no trailing slash '/'.</p>
            </div>
		</div>
		<div class="col-lg-6 osf-content-left">
			<div class="form-group">
				<label>Email</label>
                <input type="email" name="txtEmail" id="txtEmail" class="form-control required" value="" />
                <p class="help-block">Your Admin Email here.</p>
            </div>
		</div>
	</div>
	
	
	
	
	<div class="row">
		<div class="col-lg-12 osf-content-left">
			<div class="form-group">
				<label>Description of Application (Optional)</label>
                <textarea name="taAppDesc" id="taAppDesc" class="form-control" rows="3" cols=""></textarea>
            </div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-12 osf-content-left">
			<div class="form-group">
				<label>Database Settings: DSN (e.g., <code>mysql:host=localhost;dbname=newapp</code>).</label>
                <input type="text" name="txtDSN" value="" id="txtDSN" class="form-control required" />
                <p class="help-block">Note: Opendelight uses PDO - PHP Data Object</p>
            </div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-4 osf-content-left">
			<div class="form-group">
				<label>Database Username</label>
                <input type="text" name="txtDbUser" value="" id="txtDbUser" class="form-control required" />
                <p class="help-block">Your DB Username here.</p>
            </div>
		</div>
		<div class="col-lg-4 osf-content-left">
			<div class="form-group">
				<label>Database Password</label>
                <input type="text" name="txtDatabasePwd" value=""  id="txtDatabasePwd" class="form-control required" />
                <p class="help-block">Your DB Password here.</p>
            </div>
		</div>
		<div class="col-lg-4 osf-content-left">
			<div class="form-group">
				<label>Database Table Prefix</label>
                <input type="text" name="txtTablePrefix" id="txtTablePrefix" class="form-control required" value="app_"/>
                <p class="help-block">Usually protects your installation from others.</p>
            </div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-12 osf-content-left">
			<div class="form-group">
				<input type="hidden" name="hidInstallStatus" value="1"/>
				<button type="submit" href="javascript:void(0);" onclick="javascript:funcInstall();" class="btn btn-success"><i class="fa fa-check-square-o"></i> Submit</button>
            </div>
		</div>
	</div>
	
	</form>
</div>


