<div class="container" role="main">
	<?php if ($aMsg[0] == 1) { ?>
	<div class="alert alert-danger" role="alert"><?php print $aMsg[1];?></div>
	<?php } else { ?>
	<div class="alert alert-info" role="alert">Please fill up the following form to create a new controller.</div>
	<?php } ?>

	<div class="row">
		<div class="col-lg-12">
			<p><a class="btn btn-primary btn-sm" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=20"><i class="fa fa-chevron-left"></i> Back</a></p>
			<hr/>
			
			<form role="form" name="frmControllerAdd" id="frmControllerAdd" action="<?php print $_SERVER['PHP_SELF'].'?ID=22';?>" method="post">
			<div class="row">
				<div class="col-lg-4 osf-content-left">
					<div class="form-group">
						<label>Controller File Name</label>
		                <input type="text" name="txtName"  id="txtName" value="<?php if (isset($_POST['txtName'])) print $_POST['txtName'];?>" class="form-control required" />
		                <p class="help-block">(A-Z a-z 0-9, no white space, no special characters, should have .php extension)</p>
		            </div>
				</div>
				<div class="col-lg-4 osf-content-left">
					<label>Access Privilege</label>
					<div class="form-group">
						<label class="radio-inline">
  							<input type="radio" id="radPublicYes" name="radPublic" class="required" value="1" onclick="javascript:displayController('0');"> Public
						</label>
						<label class="radio-inline">
  							<input type="radio" id="radPublicNo" name="radPublic" class="required" value="0" onclick="javascript:displayController('1');"> Private
						</label>
						<label for="radPublic" class="error" style="display:none;">Please select a radio button.</label>
		                <p class="help-block">(Determines if a signin is required to access the controller or not)</p>
		            </div>
				</div>
				<div class="col-lg-4 osf-content-left">
					<div class="form-group">
						<div class="divSpacing" id="dispController" style="display:none;">
						<label>Select Sign In Controller</label>
						<select name="selController" id="selController" class="form-control">
						<option value="">Select Sign In Controller</option>
						<?php 
						foreach($aPublicControllers as $aRow) { ?>
						<option <?php if($_POST['selController'] == stripslashes($aRow['ctrid'])) print 'selected="selected"';?> value="<?php print stripslashes($aRow['ctrid']);?>">
						<?php print stripslashes($aRow['ctrname']);?>
						</option>
						<?php } ?>
						</select>
						</div>
		            </div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-12 osf-content-left">
					<input type="hidden" name="hidAddStatus" id="hidAddStatus" value="1" />
					<div class="form-group">
						<button class="btn btn-primary" type="submit" href="javascript:void(0);" onclick="javascript:addController();"><i class="fa fa-check-square-o"></i> Submit</button>
		            </div>
				</div>
			</div>
			</form>
				
			<script type="text/javascript">
			function addController()
			{
			 	$("#frmControllerAdd").validate();
			 	$("#frmControllerAdd").submit();
			}
			
			function displayController(iVal)
			{
			  if(iVal == 1)
			  {
				  document.getElementById('dispController').style.display = "block";
				  document.getElementById('selController').className = "dropdown required";
			  }
			  else 
			  {
				  document.getElementById('dispController').style.display = "none";
				  document.getElementById('selController').className = "dropdown";
			  }
			}
			</script>
		</div>
	</div>
</div>
