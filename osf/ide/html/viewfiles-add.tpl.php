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
			
			<form role="form" name="frmViewFileAdd" id="frmViewFileAdd" action="<?php print $_SERVER['PHP_SELF'].'?ID=41&VFT='.$_GET['VFT'];?>" method="post">
				<div class="row">
					<div class="col-lg-12 osf-content-left">
						<div class="form-group">
							<label><?php print $sFileTypeTexts;?> Name</label>
			                <input type="text" name="txtFileName" id="txtFileName" value="" class="form-control required space" />
							<p class="help-block">(File name should have proper file extension included. Filename Cannot be edited later.)</p>
			            </div>
					</div>
				</div>
			
				<div class="row">
					<div class="col-lg-12 osf-content-left">
						<input type="hidden" name="hidAddStatus" id="hidAddStatus" value="1" />
						<div class="form-group">
							<button class="btn btn-primary" type="submit" href="javascript:void(0);" onclick="javascript:addViewFile();"><i class="fa fa-check-square-o"></i> Submit</button>
			            </div>
					</div>
				</div>
			</form>
				
			<script type="text/javascript">
			function addViewFile()
			{
			 	$("#frmViewFileAdd").validate();
			 	$("#frmViewFileAdd").submit();
			}
			</script>
		</div>
	</div>
</div>
