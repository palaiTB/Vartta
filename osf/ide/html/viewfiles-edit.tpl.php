<div class="container" role="main">
	<?php if ($aMsg[0] == 1) { ?>
	<div class="alert alert-danger" role="alert"><?php print $aMsg[1];?></div>
	<?php } else { ?>
	<div class="alert alert-info" role="alert">Please fill up the following form to create a new role.</div>
	<?php } ?>

	<div class="row">
		<div class="col-lg-12">
			<p><a class="btn btn-primary btn-sm" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=40&VFT=<?php print $_GET['VFT'];?>"><i class="fa fa-chevron-left"></i> Back</a></p>
			<hr/>
			
			<form role="form" name="frmViewFileEdit" id="frmViewFileEdit" action="<?php print $_SERVER['PHP_SELF'].'?ID=42&VFT='.$_GET['VFT'];?>" method="post">
				<div class="row">
					<div class="col-lg-12 osf-content-left">
						<div class="form-group">
							<label><?php print $sFileTypeTexts;?> Name</label>
			                <input type="text" name="txtFileName" id="txtFileName" value="<?php if($_POST['txtFileName']){ print $_POST['txtFileName']; }else{ print stripslashes($sFile); } ?>" class="form-control required" readonly="readonly" />
							<p class="help-block">(File name should have proper file extension included. Filename Cannot be edited later.)</p>
			            </div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12 osf-content-left">
						<div class="form-group">
							<label><?php print $sFileTypeTexts;?> File Code</label>
			                <textarea name="taCodeEdit" id="textarea_1" class="form-control" rows="35" cols=""><?php if(stripslashes($sFileContent)) { print stripslashes($sFileContent); }else{ print $_POST['taCodeEdit']; } ?></textarea>
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
							<button class="btn btn-primary" type="submit" href="javascript:void(0);" onclick="javascript:editViewFile();"><i class="fa fa-check-square-o"></i> Submit</button>
			            </div>
					</div>
				</div>
			</form>
				
			<script type="text/javascript">
			function editViewFile()
			{
				document.getElementById('frmViewFileEdit').hidTextArea.value = editAreaLoader.getValue("textarea_1");
			 	$("#frmViewFileEdit").validate();
			 	$("#frmViewFileEdit").submit();
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
