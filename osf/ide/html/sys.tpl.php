<div class="container" role="main">
	<?php if ($_SESSION['ERROR_CODE'] == '2') { ?>
	<div class="alert alert-success" role="alert">The application settings have successfully been edited.</div>
	<?php } else { ?>
	<div class="alert alert-info" role="alert">The details of application settings have been presented below. You can edit as required.</div>
	<?php } $_SESSION['ERROR_CODE'] = ''; ?>

	<div class="row">
		<div class="col-lg-12">
			<p><a class="btn btn-primary btn-sm" href="<?php print $_SERVER['PHP_SELF'].'?ID=102&RecID=1';?>"><i class="fa fa-edit"></i> Edit Application Settings</a> <a class="btn btn-primary btn-sm" href="<?php print $_SERVER['PHP_SELF'].'?ID=110&RecID=1';?>"><i class="fa fa-sign-in"></i> SSO Settings</a></p>
			<hr/>
			<?php 
			$i = 0;
			if(count($aSysDetails) > 0) {
			foreach($aSysDetails as $aRow) {
			$i++;
			?>
			<div class="row osf-box-wrapper-color osf-box-default osf-box-tabular-row">
				<div class="col-sm-4 osf-box-tabular-cell-thin osf-box-left">
					Application Name
				</div>
				<div class="col-sm-8 osf-box-tabular-cell-thin osf-box-left">
					<?php print stripslashes($aRow['appname']); ?>
				</div>
			</div>
			
			<div class="row osf-box-wrapper-color osf-box-default osf-box-tabular-row">
				<div class="col-sm-4 osf-box-tabular-cell-thin osf-box-left">
					Author Name
				</div>
				<div class="col-sm-8 osf-box-tabular-cell-thin osf-box-left">
					<?php print stripslashes($aRow['author']); ?>
				</div>
			</div>
			
			<div class="row osf-box-wrapper-color osf-box-default osf-box-tabular-row">
				<div class="col-sm-4 osf-box-tabular-cell-thin osf-box-left">
					Application Base URL
				</div>
				<div class="col-sm-8 osf-box-tabular-cell-thin osf-box-left">
					<?php print stripslashes($aRow['baseurl']); ?>
				</div>
			</div>
			
			<div class="row osf-box-wrapper-color osf-box-default osf-box-tabular-row">
				<div class="col-sm-4 osf-box-tabular-cell-thin osf-box-left">
					Default Role for Single Sign-On (SSO)
				</div>
				<div class="col-sm-8 osf-box-tabular-cell-thin osf-box-left">
					<?php
					$oRoles      = new Roles();
					$aEachRoleDetails = $oRoles->listEachRole($aRow['ssodefaultroleid']);
					print stripslashes($aEachRoleDetails[0]['rolename']);
					?>
				</div>
			</div>
			
			<div class="row osf-box-wrapper-color osf-box-default osf-box-tabular-row">
				<div class="col-sm-4 osf-box-tabular-cell-thin osf-box-left">
					Lifestream Log Status
				</div>
				<div class="col-sm-8 osf-box-tabular-cell-thin osf-box-left">
					<?php if (stripslashes($aRow['logstatus']) == 1) print 'Enabled'; else print 'Disabled'; ?>
				</div>
			</div>
			
			<div class="row osf-box-wrapper-color osf-box-default osf-box-tabular-row">
				<div class="col-sm-4 osf-box-tabular-cell-thin osf-box-left">
					Application Status
				</div>
				<div class="col-sm-8 osf-box-tabular-cell-thin osf-box-left">
					<?php if (stripslashes($aRow['sysstatus']) == 1) print 'Active'; else print 'Inactive'; ?>
				</div>
			</div>
			
			<div class="row osf-box-wrapper-color osf-box-default osf-box-tabular-row">
				<div class="col-sm-4 osf-box-tabular-cell-thin osf-box-left">
					Application Description
				</div>
				<div class="col-sm-8 osf-box-tabular-cell-thin osf-box-left">
					<?php print nl2br(stripslashes($aRow['description'])); ?>
				</div>
			</div>
			
			<?php } } else{?>
			<div class="row bs-box-wrapper-color osf-box-default bs-box-tabular-row">
				<div class="col-sm-12 text-center bs-box-tabular-cell-thin">
					<h5 style="color:red;">The application has not yet setup. <a href="../install/">Go to installation now!</a></h5>
				</div>
			</div>
			<?php }?>

		</div>
	</div>
</div>
