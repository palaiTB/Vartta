<div class="container" role="main">
	<?php if ($aMsg[0] == 1) { ?>
	<div class="alert alert-danger" role="alert"><?php print $aMsg[1];?></div>
	<?php } else { ?>
	<div class="alert alert-info" role="alert">Please fill up the following form to create a new role.</div>
	<?php } ?>

	<div class="row">
		<div class="col-lg-12">
			<p><a class="btn btn-primary btn-sm" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=30"><i class="fa fa-chevron-left"></i> Back</a></p>
			<hr/>
			
			<form role="form" name="frmAppClassEdit" id="frmAppClassEdit" action="<?php print $_SERVER['PHP_SELF'].'?ID=32';?>" method="post">
				<div class="row">
					<div class="col-lg-12 osf-content-left">
						<div class="form-group">
							<label>Application Class Name</label>
			                <input type="text" name="txtClassName" id="txtClassName" value="<?php if($_POST['txtClassName']){ print $_POST['txtClassName']; }else{ print stripslashes($sClass); } ?>" class="form-control required" readonly="readonly" />
							<p class="help-block">(File name is the same as class name but with .cls.php appended. Cannot be edited later.)</p>
			            </div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12 osf-content-left">
						<div class="form-group">
							<label>Application Class Code</label>
			                <textarea name="taBusinessLogic" id="textarea_1" class="form-control" rows="35" cols=""><?php if(stripslashes($sClassContent)) { print stripslashes($sClassContent); }else{ print $_POST['taBusinessLogic']; } ?></textarea>
							<p class="help-block">(Entire content is editable)</p>
			            </div>
					</div>
				</div>
			
				<div class="row">
					<div class="col-lg-12 osf-content-left">
						<input type="hidden" name="hidEditStatus" id="hidEditStatus" value="1" />
						<input type="hidden" name="hidClassName" id="hidClassName" value="<?php print stripslashes($sClass);?>" />
						<input type="hidden" name="hidTextArea" id="hidTextArea" value="" />
						<div class="form-group">
							<button class="btn btn-primary" type="submit" href="javascript:void(0);" onclick="javascript:editAppClass();"><i class="fa fa-check-square-o"></i> Submit</button>
			            </div>
					</div>
				</div>
			</form>
				
			<script type="text/javascript">
			function addAppClass()
			{
			 	$("#frmAppClassAdd").validate();
			 	$("#frmAppClassAdd").submit();
			}
			</script>
		</div>
	</div>
</div>

