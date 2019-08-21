<div class="container" role="main">
	<?php if ($aMsg[0] == 1) { ?>
	<div class="alert alert-danger" role="alert"><?php print $aMsg[1];?></div>
	<?php } else { ?>
	<div class="alert alert-info" role="alert">Please fill up the following form to create a new user.</div>
	<?php } ?>

	<div class="row">
		<div class="col-lg-12">
			<p><a class="btn btn-primary btn-sm" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=63"><i class="fa fa-chevron-left"></i> Back</a></p>
			<hr/>
			
			<form role="form" id="frmUserAdd" method="post" action="<?php print $_SERVER['PHP_SELF'].'?ID=64';?>" >
			<div class="row">
				<div class="col-lg-6 osf-content-left">
					<div class="form-group">
						<label>First Name</label>
		                <input type="text" name="txtFirstName" id="txtFirstName" value="<?php if (isset($_POST['txtFirstName'])) print $_POST['txtFirstName'];?>" class="form-control required"/>
		            </div>
				</div>
				<div class="col-lg-6 osf-content-left">
					<div class="form-group">
						<label>Last Name</label>
						<input type="text" name="txtLastName" id="txtLastName" value="<?php if (isset($_POST['txtLastName'])) print $_POST['txtLastName'];?>" class="form-control required"/>
		            </div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-6 osf-content-left">
					<div class="form-group">
						<label>Username</label>
		                <input type="text" name="txtUsername" id="txtUsername" value="<?php if (isset($_POST['txtUsername'])) print $_POST['txtUsername'];?>" class="form-control required"/>
						<p class="help-block">(A-Z a-z 0-9, and no white space, no special characters, unique)</p>
		            </div>
				</div>
				<div class="col-lg-6 osf-content-left">
					<div class="form-group">
						<label>Email Address</label>
						<input type="text" name="txtEmail" id="txtEmail" value="<?php if (isset($_POST['txtEmail'])) print $_POST['txtEmail'];?>" class="form-control required email"/>
						<p class="help-block">(Email address must be unique)</p>
		            </div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-6 osf-content-left">
					<div class="form-group">
						<label>Password</label>
		                <input type="password" name="txtPassword" id="txtPassword" value="<?php if (isset($_POST['txtPassword'])) print $_POST['txtPassword'];?>" class="form-control required"/>
		            </div>
				</div>
				<div class="col-lg-6 osf-content-left">
					<div class="form-group">
						<label>User Role</label>
						<select name="selRole" id="selRole" class="form-control required">
							<option value="">Select Role</option>
							<?php $aRoles = $oUsers->getRoles();
							foreach($aRoles as $aRow) { ?>
							<option value="<?php print stripslashes($aRow['roleid']);?>">
							<?php print stripslashes($aRow['rolename']);?>
							</option>
							<?php } ?>
						</select>
		            </div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-12 osf-content-left">
					<input type="hidden" name="hidAddStatus" id="hidAddStatus" value="1" />
					<div class="form-group">
						<button class="btn btn-primary" type="submit" href="javascript:void(0);" onclick="javascript:validateUserAdd();"><i class="fa fa-check-square-o"></i> Submit</button>
		            </div>
				</div>
			</div>
			</form>
				
			<script type="text/javascript">
			function validateUserAdd()
			 {
			 	$("#frmUserAdd").validate();
			 	$("#frmUserAdd").submit();
			 }
			 </script>
		</div>
	</div>
</div>
