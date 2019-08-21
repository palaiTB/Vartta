<div class="container" role="main">
	<?php if ($aMsg[0] == 1) { ?>
	<div class="alert alert-danger" role="alert"><?php print $aMsg[1];?></div>
	<?php } else { ?>
	<div class="alert alert-info" role="alert">Change your password with the form below.</div>
	<?php } ?>

	<div class="row">
		<div class="col-lg-12">
			<form role="form" name="frmChangePwd" id="frmChangePwd" action="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=104" method="post">
			<div class="row">
				<div class="col-lg-4 osf-content-left">
					<div class="form-group">
						<label>Current Password</label>
		                <input type="password" name="txtCurrentPassword"  id="txtCurrentPassword" value="<?php if(isset($_POST['txtCurrentPassword'])) print $_POST['txtCurrentPassword'];?>" class="form-control required"/>
						<p class="help-block">(Your existing password here)</p>
		            </div>
				</div>
				<div class="col-lg-4 osf-content-left">
					<div class="form-group">
						<label>New Password</label>
		                <input type="password" name="txtNewPassword"  id="txtNewPassword" value="<?php if(isset($_POST['txtNewPassword'])) print $_POST['txtNewPassword'];?>" class="form-control required"/>
						<p class="help-block">(should be minimum 6 characters)</p>
		            </div>
				</div>
				<div class="col-lg-4 osf-content-left">
					<div class="form-group">
						<label>Retype New Password</label>
		                <input type="password" name="txtRetypePassword"  id="txtRetypePassword" value="<?php if(isset($_POST['txtRetypePassword'])) print $_POST['txtRetypePassword'];?>" class="form-control required"/>
						<p class="help-block">(for confirmation of typing)</p>
		            </div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-12 osf-content-left">
					<input type="hidden" name="hidPwd" id="hidPwd" value="1" />
					<div class="form-group">
						<button class="btn btn-primary" type="submit" href="javascript:void(0);" onclick="javascript:changePassword();"><i class="fa fa-check-square-o"></i> Submit</button>
		            </div>
				</div>
			</div>
			</form>
				
			<script type="text/javascript">
			function changePassword()
			{
					$("#frmChangePwd").validate();
				 	$("#frmChangePwd").submit();
			}
			</script>
		</div>
	</div>
</div>
