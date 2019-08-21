<div class="container" role="main">
	<?php if ($aMsg[0] == 1) { ?>
	<div class="alert alert-danger" role="alert"><?php print $aMsg[1];?></div>
	<?php } else { ?>
	<div class="alert alert-info" role="alert">Please fill up the following form to create a new configuration variable. The variable name must be unique.</div>
	<?php } ?>

	<div class="row">
		<div class="col-lg-12">
			<p><a class="btn btn-primary btn-sm" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=50"><i class="fa fa-chevron-left"></i> Back</a></p>
			<hr/>
			
			<form name="frmConfigurationAdd" id="frmConfigurationAdd" action="<?php print $_SERVER['PHP_SELF'].'?ID=51';?>" method="post">
			<div class="row">
				<div class="col-lg-4 osf-content-left">
					<div class="form-group">
						<label>Variable Name</label>
		                <input type="text" name="txtVariable" id="txtVariable" value="<?php if (isset($_POST['txtVariable'])) print $_POST['txtVariable'];?>" class="form-control required space"/>
						<p class="help-block">(A-Z 0-9, and no white space, no special characters)</p>
		            </div>
				</div>
				<div class="col-lg-4 osf-content-left">
					<div class="form-group">
						<label>Description</label>
						<input type="text" name="txtDescription" id="txtDescription" value="<?php if (isset($_POST['txtDescription'])) print $_POST['txtDescription'];?>" class="form-control required"/>
						<p class="help-block">(what is this variable about?)</p>
		            </div>
				</div>
				<div class="col-lg-4 osf-content-left">
					<div class="form-group">
						<label>Value of Variable</label>
						<input type="text" name="txtValue"  id="txtValue" value="<?php if (isset($_POST['txtValue'])) print $_POST['txtValue'];?>" class="form-control required" />
						<p class="help-block">(any string)</p>
		            </div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-12 osf-content-left">
					<input type="hidden" name="hidAddStatus" id="hidAddStatus" value="1" />
					<div class="form-group">
						<button class="btn btn-primary" type="submit" href="javascript:void(0);" onclick="javascript:addConfiguration();"><i class="fa fa-check-square-o"></i> Submit</button>
		            </div>
				</div>
			</div>
			</form>
				
			<script type="text/javascript">
			function addConfiguration()
			{
			 	$("#frmConfigurationAdd").validate();
			 	$("#frmConfigurationAdd").submit();
			}
			</script>
		</div>
	</div>
</div>
