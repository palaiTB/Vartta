<div class="container" role="main">
	<?php if ($aMsg[0] == 1) { ?>
	<div class="alert alert-danger" role="alert"><?php print $aMsg[1];?></div>
	<?php } else { ?>
	<div class="alert alert-info" role="alert">Please edit the following form.</div>
	<?php } ?>

	<div class="row">
		<div class="col-lg-12">
			<p><a class="btn btn-primary btn-sm" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=63"><i class="fa fa-chevron-left"></i> Back</a></p>
			<hr/>
			
			<form role="form" name="frmUserEdit" id="frmUserEdit" action="<?php print $_SERVER['PHP_SELF'].'?ID=65&RecID='.stripslashes($aEachUsersDetails[0]['userid']);?>" method="post">
			<div class="row">
				<div class="col-lg-6 osf-content-left">
					<div class="form-group">
						<label>First Name</label>
		                <input type="text" name="txtFirstName" id="txtFirstName" value="<?php if($_POST['txtFirstName']){ print $_POST['txtFirstName']; }else{ print stripslashes($aEachUsersDetails[0]['firstname']); } ?>" class="form-control required"/>
		            </div>
				</div>
				<div class="col-lg-6 osf-content-left">
					<div class="form-group">
						<label>Last Name</label>
						<input type="text" name="txtLastName" id="txtLastName" value="<?php if($_POST['txtLastName']){ print $_POST['txtLastName']; }else{ print stripslashes($aEachUsersDetails[0]['lastname']); } ?>" class="form-control required"/>
		            </div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-6 osf-content-left">
					<div class="form-group">
						<label>Username</label>
		                <input type="text" name="txtUsername" id="txtUsername" value="<?php if($_POST['txtUsername']){ print $_POST['txtUsername']; }else{ print stripslashes($aEachUsersDetails[0]['username']); } ?>" class="form-control required" <?php if($aEachUsersDetails[0]['username'] == 'admin') { print 'readonly="readonly"';} ?>/>
						<p class="help-block">(A-Z a-z 0-9, and no white space, no special characters, unique)</p>
		            </div>
				</div>
				<div class="col-lg-6 osf-content-left">
					<div class="form-group">
						<label>Email Address</label>
						<input type="text" name="txtEmail" id="txtEmail" value="<?php if($_POST['txtEmail']){ print $_POST['txtEmail']; }else{ print stripslashes($aEachUsersDetails[0]['email']); } ?>" class="form-control required email"/>
						<p class="help-block">(Email address has to be unique)</p>
		            </div>
				</div>
			</div>
			
			<?php if($aEachUsersDetails[0]['username'] != 'admin') { ?>
			<div class="row">
				<div class="col-lg-6 osf-content-left">
					<div class="form-group">
						<label>Password</label>
		                <input type="text" name="txtPassword" id="txtPassword" value="" class="form-control"/>
						<p class="help-block">(Fill up only if you want to change the password, else leave it blank)</p>
		            </div>
				</div>
				<div class="col-lg-6 osf-content-left">
					<div class="form-group">
						<label>Role</label>
						<select name="selRole" id="selRole" class="form-control required">
							<option value="">Select Role</option>
							<?php $aRoles  	= $oUsers->getRoles();
							foreach($aRoles as $aRow) { ?>
							<option <?php if($_POST['selRole'] == $aRow['roleid'] || stripslashes($aEachUsersDetails[0]['roleid']) == stripslashes($aRow['roleid']) ) print 'selected="selected"';?> value="<?php print stripslashes($aRow['roleid']);?>">
							<?php print stripslashes($aRow['rolename']);?>
							</option>
							<?php } ?>
						</select>
		            </div>
				</div>
			</div>
			<?php } ?>
			
			<div class="row">
				<div class="col-lg-12 osf-content-left">
					<input type="hidden" name="hidEditStatus" id="hidEditStatus" value="1" />
					<div class="form-group">
						<button class="btn btn-primary" type="submit" href="javascript:void(0);" onclick="javascript:editUser();"><i class="fa fa-check-square-o"></i> Submit</button>
		            </div>
				</div>
			</div>
			</form>
				
			<script type="text/javascript">
			 function editUser()
			 {
			 	$("#frmUserEdit").validate();
			 	$("#frmUserEdit").submit();
			 }
			 </script>
		</div>
	</div>
</div>








