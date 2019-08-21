<div class="container" role="main">
	<?php if (isset($_GET['PC']) && isset($_GET['PF']) && $_GET['PF'] == '1') { ?>
	<div class="alert alert-success" role="alert">The new user <strong><?php print $_GET['PC'];?></strong> has successfully been added.</div>
	<?php } else if (isset($_GET['PC']) && isset($_GET['PF']) && $_GET['PF'] == '2') { ?>
	<div class="alert alert-success" role="alert">The user <strong><?php print $_GET['PC'];?></strong> has successfully been edited.</div>
	<?php } else if (isset($_GET['PC']) && isset($_GET['PF']) && $_GET['PF'] == '3') { ?>
		<div class="alert alert-success" role="alert">The user <strong><?php print $_GET['PC'];?></strong> has successfully been deleted.</div>
	<?php } else if (isset($_GET['PF']) && $_GET['PF'] == '4') { ?>
		<div class="alert alert-success" role="alert">The status of the chosen user has successfully been changed.</div>
	<?php } else if (isset($_GET['PF']) && $_GET['PF'] == '5') { ?>
		<div class="alert alert-danger" role="alert">The status of the chosen user could not been changed.</div>
	<?php } else { ?>
		<div class="alert alert-info" role="alert">The list of users have been presented below. Only user with username <strong>admin</strong> is responsible for IDE management.</div>
	<?php } ?>
	
	<div class="row">
		<div class="col-lg-12">
			<p><a class="btn btn-primary btn-sm" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=70"><i class="fa fa-sort"></i> Manage Roles</a> <a class="btn btn-primary btn-sm" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=64"><i class="fa fa-plus"></i> Add User</a></p>
			<hr/>
			
			<div class="row osf-box-wrapper-color osf-box-default osf-box-tabular-rowheader">
				<div class="col-sm-2 osf-box-tabular-cell-thin osf-box-left">
					Name
				</div>
				<div class="col-sm-2 osf-box-tabular-cell-thin osf-box-left">
					Username
				</div>
				<div class="col-sm-2 osf-box-tabular-cell-thin text-center">
					Email
				</div>
				<div class="col-sm-2 osf-box-tabular-cell-thin text-center">
					Last Login
				</div>
				<div class="col-sm-1 osf-box-tabular-cell-thin text-center">
					User Status
				</div>
				<div class="col-sm-1 osf-box-tabular-cell-thin text-center">
					User Role
				</div>
				<div class="col-sm-2 osf-box-tabular-cell-thin text-center">
					Action
				</div>
			</div>
			<?php 
			if(count($aUsersDetails) > 0) {
			foreach($aUsersDetails as $aRow) {
		    if($aRow['firstname']) $sFullName = stripslashes($aRow['firstname']).' '.stripslashes($aRow['lastname']);
		    else $sFullName = 'N/A';
		    if($aRow['userstatus'] == 1) $sUserStatus = 'Active';
		    else $sUserStatus = 'Inactive';    
		    $sRoleName   = $oUsers->getRoleName(stripslashes($aRow['roleid']));    
			?>
			<div class="row osf-box-wrapper-color osf-box-default osf-box-tabular-row">
				<div class="col-sm-2 osf-box-tabular-cell-thin osf-box-left">
					<?php print $sFullName; ?>
				</div>
				<div class="col-sm-2 osf-box-tabular-cell-thin osf-box-left">
					<?php print stripslashes($aRow['username']); ?>
				</div>
				<div class="col-sm-2 osf-box-tabular-cell-thin osf-box-left">
					<?php print stripslashes($aRow['email']); ?>
				</div>
				<div class="col-sm-2 osf-box-tabular-cell-thin text-center">
					<?php print stripslashes($aRow['lastlogin']); ?>
				</div>
				<div class="col-sm-1 osf-box-tabular-cell-thin text-center">
					<?php if($aRow['userstatus'] == 1) { ?>
						<i style="color:green;" class="fa fa-circle fa-lg"></i><br/><?php if($aRow['username'] != 'admin') { ?><a href="javascript:void(0);"  onclick="javascript:changeStatus('<?php print $aRow['userstatus']; ?>', '<?php print $aRow['userid']; ?>');" ><span style="font-size:11px;">Change</span></a><?php } ?>
					<?php } elseif($aRow['userstatus'] == 0) { ?>
						<i style="color:red;" class="fa fa-circle fa-lg"></i><br/><?php if($aRow['username'] != 'admin') { ?><a href="javascript:void(0);" onclick="javascript:changeStatus('<?php print $aRow['userstatus']; ?>', '<?php print $aRow['userid']; ?>');" ><span style="font-size:11px;">Change</span></a><?php } ?>
					<?php } ?>
				</div>
				<div class="col-sm-1 osf-box-tabular-cell-thin text-center">
					<?php print $sRoleName; ?>
				</div>
				<div class="col-sm-1 osf-box-tabular-cell-thin text-center">
					<a href="<?php print $_SERVER['PHP_SELF'].'?ID=65&RecID='.stripslashes($aRow['userid']); ?>"><i class="fa fa-edit fa-lg"></i></a>
				</div>
				<div class="col-sm-1 osf-box-tabular-cell-thin text-center">
					<?php if($aRow['username'] != 'admin') { ?>
						<a href="<?php print $_SERVER['PHP_SELF'].'?ID=66&RecID='.stripslashes($aRow['userid']); ?>" onclick="javascript:return confirm(&quot;Do you want to delete?&quot;);"><i class="fa fa-times-circle fa-lg"></i></a>
					<?php } else {?>
						&nbsp;
					<?php } ?>
				</div>
			</div>
			
			<?php } } else {?>
			<div class="row osf-box-wrapper-color osf-box-default bs-box-tabular-row">
				<div class="col-sm-12 text-center bs-box-tabular-cell-thin">
					<h5 style="color:red;">No user found.</h5>
				</div>
			</div>
			<?php }?>
			
			
			
			<script type="text/javascript">
			function changeStatus(iStatus, iUserId)
			{ 	
			 $.ajax({
				   type: "POST",
				   url: "<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=109",
				   data: "requeststatus="+iStatus+"&requestuserid="+iUserId,
				   success: function(msg)
				   {
					  if(msg == "1") self.location.href = '<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=63&PF=4';
				   	  else if(msg == "2") self.location.href = '<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=63&PF=5';	   
			       }
				 });
			}
			</script>
			
		</div>
	</div>
</div>
