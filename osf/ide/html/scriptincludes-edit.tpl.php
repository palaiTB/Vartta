<div class="container" role="main">
	<?php if ($aMsg[0] == 1) { ?>
	<div class="alert alert-danger" role="alert"><?php print $aMsg[1];?></div>
	<?php } else { ?>
	<div class="alert alert-info" role="alert">Please fill up the following form to create a new role.</div>
	<?php } ?>

	<div class="row">
		<div class="col-lg-12">
			<p><a class="btn btn-primary btn-sm" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=35"><i class="fa fa-chevron-left"></i> Back</a></p>
			<hr/>
			
			<form role="form" name="frmAppClassEdit" id="frmAppClassEdit" action="<?php print $_SERVER['PHP_SELF'].'?ID=37';?>" method="post">
				<div class="row">
					<div class="col-lg-12 osf-content-left">
						<div class="form-group">
							<label>Script Include Name</label>
			                <input type="text" name="txtSIName" id="txtSIName" value="<?php if($_POST['txtSIName']){ print $_POST['txtSIName']; }else{ print stripslashes($sFile); } ?>" class="form-control required" readonly="readonly" />
							<p class="help-block">(Cannot be edited.)</p>
			            </div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12 osf-content-left">
						<div class="form-group">
							<label>Script Include File Code</label>
			                <textarea name="taBusinessLogic" id="textarea_1" class="form-control" rows="35" cols=""><?php if(stripslashes($sClassContent)) { print stripslashes($sClassContent); }else{ print $_POST['taBusinessLogic']; } ?></textarea>
							<p class="help-block">(Entire content is editable.)</p>
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
			function editAppClass()
			{
				document.getElementById('frmAppClassEdit').hidTextArea.value = editAreaLoader.getValue("textarea_1");
			 	$("#frmAppClassEdit").validate();
			 	$("#frmAppClassEdit").submit();
			}
			
			editAreaLoader.init({
				id : "textarea_1"		// textarea id
				,syntax: "css"			// syntax to be uses for highgliting
				,start_highlight: true		// to display with highlight mode on start-up
			});
			</script>
		</div>
	</div>
</div>
