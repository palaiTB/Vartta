<div class="container" role="main">
	<?php if ($aMsg[0] == 1) { ?>
	<div class="alert alert-danger" role="alert"><?php print $aMsg[1];?></div>
	<?php } else { ?>
	<div class="alert alert-info" role="alert">Please fill up the following form to create a new role.</div>
	<?php } ?>

	<div class="row">
		<div class="col-lg-12">
			<p><a class="btn btn-primary btn-sm" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=70"><i class="fa fa-chevron-left"></i> Back</a></p>
			<hr/>
			
			<form role="form" name="frmRoleAdd" id="frmRoleAdd" action="<?php print $_SERVER['PHP_SELF'].'?ID=71';?>" method="post">
			<div class="row">
				<div class="col-lg-4 osf-content-left">
					<div class="form-group">
						<label>Role Name</label>
		                <input type="text" name="txtRoleName" id="txtRoleName" value="" class="form-control required" />
						<p class="help-block">(A-Z a-z 0-9, no white space, no special characters)</p>
		            </div>
				</div>
				<div class="col-lg-4 osf-content-left">
					<div class="form-group">
						<label>Default Controller</label>
						<select name="selController" id="selController" class="form-control required" onChange="javascript:selectCtrl();">
							<option value="">Select Controller</option>
							<?php $aControllers  	= $oRoles->getControllers();
							foreach($aControllers as $aRow) { ?>
							<option value="<?php print stripslashes($aRow['ctrid']);?>">
							<?php print stripslashes($aRow['ctrname']);?>
							</option>
							<?php } ?>
						</select>
						<p class="help-block">(Choose the Controller where any user with this role will head after signing in)</p>
		            </div>
				</div>
				<div class="col-lg-4 osf-content-left">
					<div class="form-group" id="eventdiv">
						<label>Default Event</label>
						<select name="selEvent" id="selEvent" class="form-control required">
							<option value="">Select Event</option>
						</select>
						<p class="help-block">(Choose the Event that will be instantiated by default after signing in)</p>
		            </div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-12 osf-content-left">
					<input type="hidden" name="hidAddStatus" id="hidAddStatus" value="1" />
					<div class="form-group">
						<button class="btn btn-primary" type="submit" href="javascript:void(0);" onclick="javascript:addRole();"><i class="fa fa-check-square-o"></i> Submit</button>
		            </div>
				</div>
			</div>
			</form>
				
			<script type="text/javascript">
			function addRole()
			{
			 	$("#frmRoleAdd").validate(); 
			 	$("#frmRoleAdd").submit();
			}
			 function selectCtrl()
			 { 	
				 $.ajax({
					   type: "POST",
					   url: "<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=105",
					   data: "requestctrlid="+document.getElementById('selController').value,
					   success: function(msg)
					   {
					   	  if(msg != "") document.getElementById('eventdiv').innerHTML = msg;		   
				       }
					 });
			 }
			 </script>
		</div>
	</div>
</div>
