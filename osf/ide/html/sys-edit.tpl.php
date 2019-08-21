<div class="container" role="main">
	<?php if ($_SESSION['ERROR_CODE'] == '2') { ?>
	<div class="alert alert-success" role="alert">The application settings have successfully been edited.</div>
	<?php } else { ?>
	<div class="alert alert-info" role="alert">The details of application settings have been presented below. You can edit as required.</div>
	<?php } $_SESSION['ERROR_CODE'] = ''; ?>

	<div class="row">
		<div class="col-lg-12">
			<p><a class="btn btn-primary btn-sm" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=100"><i class="fa fa-chevron-left"></i> Back</a></p>
			<hr/>
			
			<form role="form" name="frmSysEdit" id="frmSysEdit" action="<?php print $_SERVER['PHP_SELF'].'?ID=102&RecID='.stripslashes($aEachSysDetails[0]['sysid']);?>" method="post">
			<div class="row">
				<div class="col-lg-4 osf-content-left">
					<div class="form-group">
						<label>Name of the Application</label>
		                <input type="text" name="txtAppName" value="<?php if($_POST['txtAppName']){ print $_POST['txtAppName']; }else{ print stripslashes($aEachSysDetails[0]['appname']); } ?>"  id="txtAppName" class="form-control required" />
		            </div>
				</div>
				<div class="col-lg-4 osf-content-left">
					<div class="form-group">
						<label>Name of Author</label>
						<input type="text" name="txtAuthor"  id="txtAuthor" value="<?php if($_POST['txtAuthor']){ print $_POST['txtAuthor']; }else{ print stripslashes($aEachSysDetails[0]['author']); } ?>" class="form-control required"/>
		            </div>
				</div>
				<div class="col-lg-4 osf-content-left">
					<div class="form-group">
						<label>Default Role for SSO</label>
						<select name="ssodefaultroleid" id="ssodefaultroleid" class="form-control required">
							<?php $aRoles  	= $oUsers->getRoles();
							foreach($aRoles as $aRow) { ?>
							<option <?php if($_POST['ssodefaultroleid'] == $aRow['roleid'] || stripslashes($aEachSysDetails[0]['ssodefaultroleid']) == stripslashes($aRow['roleid']) ) print 'selected="selected"';?> value="<?php print stripslashes($aRow['roleid']);?>">
							<?php print stripslashes($aRow['rolename']);?>
							</option>
							<?php } ?>
						</select>
		            </div>
					<!--<div class="form-group">
						<label>Application Base URL (without trailing slash "/")</label>
						<input type="text" name="txtBaseURL"  id="txtBaseURL" value="<?php if($_POST['txtBaseURL']){ print $_POST['txtBaseURL']; }else{ print stripslashes($aEachSysDetails[0]['baseurl']); } ?>" class="form-control required"/>
		            </div>-->
					<input type="hidden" name="txtBaseURL"  id="txtBaseURL" value="<?php if($_POST['txtBaseURL']){ print $_POST['txtBaseURL']; }else{ print stripslashes($aEachSysDetails[0]['baseurl']); } ?>"/>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-4 osf-content-left">
					<div class="form-group">
						<label>Description of Application</label>
		                <textarea name="taDescription" id="taDescription" class="form-control" rows="3" cols="85"><?php if($_POST['taDescription']){ print $_POST['taDescription']; }else{ print stripslashes($aEachSysDetails[0]['description']); } ?></textarea>
		            </div>
				</div>
				<div class="col-lg-4 osf-content-left">
					<label>Enable Log? (This determines if log files are to be created or not)</label>
					<div class="form-group">
						<label class="radio-inline">
							<input id="radLogYes" name="radLog" class="required" type="radio" value="1" <?php if($_POST['radLog'] == 1 || $aEachSysDetails[0]['logstatus'] == 1) print 'checked="checked"';?>/> Yes
						</label>
						<label class="radio-inline">
							<input id="radLogNo" name="radLog" class="required" type="radio" value="0" <?php if($_POST['radLog'] == '0' || stripslashes($aEachSysDetails[0]['logstatus']) == '0') print 'checked="checked"';?>/> No
						</label>
		            </div>
				</div>
				<div class="col-lg-4 osf-content-left">
					<label>Status of Application (This determines if the application is active or not)</label>
					<div class="form-group">
						<label class="radio-inline">
							<input id="radStatusActive" name="radStatus" class="required" type="radio" value="1" <?php if($_POST['radStatus'] == 1 || $aEachSysDetails[0]['sysstatus'] == 1) print 'checked="checked"';?>/> Active
						</label>
						<label class="radio-inline">
							<input id="radStatusInactive" name="radStatus" class="required" type="radio" value="0" <?php if($_POST['radStatus'] == '0' || stripslashes($aEachSysDetails[0]['sysstatus']) == '0') print 'checked="checked"';?>/> Inactive
						</label>
		            </div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-12 osf-content-left">
					<input type="hidden" name="hidEditStatus" id="hidEditStatus" value="1" />
					<div class="form-group">
						<button class="btn btn-primary" type="submit" href="javascript:void(0);" onclick="javascript:editSys();"><i class="fa fa-check-square-o"></i> Submit</button>
		            </div>
				</div>
			</div>
			</form>
				
			<script type="text/javascript">
			function editSys()
			{
			 	$("#frmSysEdit").validate();
			 	$("#frmSysEdit").submit();
			}
			</script>
		</div>
	</div>
</div>
