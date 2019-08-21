<div class="container" role="main">
	<?php if (isset($_GET['PC']) && isset($_GET['PF']) && $_GET['PF'] == '1') { ?>
	<div class="alert alert-success" role="alert">The new user role <strong><?php print $_GET['PC'];?></strong> has successfully been added.</div>
	<?php } else if (isset($_GET['PC']) && isset($_GET['PF']) && $_GET['PF'] == '2') { ?>
	<div class="alert alert-success" role="alert">The role <strong><?php print $_GET['PC'];?></strong> has successfully been edited.</div>
	<?php } else if (isset($_GET['PC']) && isset($_GET['PF']) && $_GET['PF'] == '3') { ?>
		<div class="alert alert-success" role="alert">The role <strong><?php print $_GET['PC'];?></strong> has successfully been deleted.</div>
	<?php } else if (isset($_GET['PF']) && $_GET['PF'] == '4') { ?>
		<div class="alert alert-success" role="alert">The display order of user roles has successfully been changed.</div>
	<?php } else { ?>
		<div class="alert alert-info" role="alert">The list of user roles have been presented below. The role <strong>Administrator</strong> cannot be deleted.</div>
	<?php } ?>
	
	<div class="row">
		<div class="col-lg-12">
			<p><a class="btn btn-primary btn-sm" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=74"><i class="fa fa-sort"></i> Sort Display Order</a> <a class="btn btn-primary btn-sm" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=71"><i class="fa fa-plus"></i> Add User Role</a></p>
			<hr/>
			
			<div class="row osf-box-wrapper-color osf-box-default osf-box-tabular-rowheader">
				<div class="col-sm-1 osf-box-tabular-cell-thin osf-box-left">
					Sl. No.
				</div>
				<div class="col-sm-3 osf-box-tabular-cell-thin osf-box-left">
					Role Name
				</div>
				<div class="col-sm-3 osf-box-tabular-cell-thin text-center">
					Default Controller File
				</div>
				<div class="col-sm-3 osf-box-tabular-cell-thin text-center">
					Default Event Name
				</div>
				<div class="col-sm-2 osf-box-tabular-cell-thin text-center">
					Action
				</div>
			</div>
			<?php 
			$i = 0;
			if(count($aRolesDetails) > 0) {
			foreach($aRolesDetails as $aRow) { 
			$sDefaultCtr   = $oRoles->getDefaultCtr(stripslashes($aRow['defaultctrid']));
			$sDefaultEvent = $oRoles->getDefaultEvent(stripslashes($aRow['defaulteventid']));
			$i++;
			?>
			<div class="row osf-box-wrapper-color osf-box-default osf-box-tabular-row">
				<div class="col-sm-1 osf-box-tabular-cell-thin osf-box-left">
					<?php print $i; ?>
				</div>
				<div class="col-sm-3 osf-box-tabular-cell-thin osf-box-left">
					<?php print $aRow['rolename']; ?>
				</div>
				<div class="col-sm-3 osf-box-tabular-cell-thin osf-box-left">
					<?php print $sDefaultCtr; ?>
				</div>
				<div class="col-sm-3 osf-box-tabular-cell-thin text-center">
					<?php print $sDefaultEvent; ?>
				</div>
				<div class="col-sm-1 osf-box-tabular-cell-thin text-center">
					<a href="<?php print $_SERVER['PHP_SELF'].'?ID=72&RecID='.stripslashes($aRow['roleid']); ?>"><i class="fa fa-edit fa-lg"></i></a>
				</div>
				<div class="col-sm-1 osf-box-tabular-cell-thin text-center">
					<?php if($aRow['rolename'] != 'Administrator') { ?>
						<a href="<?php print $_SERVER['PHP_SELF'].'?ID=73&RecID='.stripslashes($aRow['roleid']); ?>" onclick="javascript:return confirm(&quot;Do you want to delete?&quot;);"><i class="fa fa-times-circle fa-lg"></i></a>
					<?php } else {?>
						&nbsp;
					<?php } ?>
				</div>
			</div>
			
			<?php } } else {?>
			<div class="row osf-box-wrapper-color osf-box-default bs-box-tabular-row">
				<div class="col-sm-12 text-center bs-box-tabular-cell-thin">
					<h5 style="color:red;">SYSTEM ERROR! No user role has been found.</h5>
				</div>
			</div>
			<?php }?>
			
		</div>
	</div>
</div>


