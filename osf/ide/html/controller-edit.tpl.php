<div class="container" role="main">
	<?php if ($aMsg[0] == 1) { ?>
	<div class="alert alert-danger" role="alert"><?php print $aMsg[1];?></div>
	<?php } else { ?>
	<div class="alert alert-info" role="alert">Please edit the details of the controller file in the form below. Be careful as it may affect the functioning of the application.</div>
	<?php } ?>

	<div class="row">
		<div class="col-lg-12">
			<p><a class="btn btn-primary btn-sm" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=20"><i class="fa fa-chevron-left"></i> Back</a></p>
			<hr/>
			
			<form role="form" name="frmControllerEdit" id="frmControllerEdit" action="<?php print $_SERVER['PHP_SELF'].'?ID=23&RecID='.stripslashes($aEachCtrDetails[0]['ctrid']);?>" method="post">
			<div class="row">
				<div class="col-lg-12 osf-content-left">
					<div class="form-group">
						<label>Controller File Name</label>
		                <input type="text" name="txtName"  id="txtName" value="<?php if(isset($_POST['txtName'])){ print $_POST['txtName']; }else{ print stripslashes($aEachCtrDetails[0]['ctrname']); } ?>" class="form-control required"/>
		                <p class="help-block">(A-Z a-z 0-9, no white space, no special characters, should have .php extension)</p>
		            </div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-3 osf-content-left">
					<div class="form-group">
						<?php
						$aEvents = $oControllers->getControllerEvents(stripslashes($aEachCtrDetails[0]['ctrid']));
						if(count($aEvents) > 0){?>
						<label>Default Event</label>
						<select name="selEvent" id="selEvent" class="form-control required">
						<option value="">Select Event</option>
						<?php foreach($aEvents as $aRow) { ?>
						<option <?php if($_POST['selEvent'] == stripslashes($aRow['eventid']) || stripslashes($aEachCtrDetails[0]['defaulteventid']) == stripslashes($aRow['eventid'])) print 'selected="selected"';?> value="<?php print stripslashes($aRow['eventid']);?>">
						<?php print stripslashes($aRow['eventname']);?>
						</option>
						<?php } ?>
						</select>
						<?php }?>
		            </div>
				</div>
				<div class="col-lg-3 osf-content-left">
					<div class="form-group">
						<label>Status</label>
						<select name="selStatus" id="selStatus" class="form-control required">
						<option value="">Select Status</option>
						<option <?php if($_POST['selStatus'] == 0 || stripslashes($aEachCtrDetails[0]['ctrstatus']) == 0) print 'selected="selected"';?> value="0"> Inactive</option>
						<option <?php if($_POST['selStatus'] == 1 || stripslashes($aEachCtrDetails[0]['ctrstatus']) == 1) print 'selected="selected"';?> value="1"> Active</option>
						</select>
		            </div>
				</div>
				<div class="col-lg-3 osf-content-left">
					<div class="form-group">
						<label for="radIsPublic">Access Privilege</label><br/>
						<input id="radPublicYes"  name="radPublic" class="required" type="radio"  onclick="javascript:displayController('0');" value="1" <?php if($aEachCtrDetails[0]['ispublic'] == 1) print 'checked="checked"';?>/>
						<label for="radPublicYes"  class="radiolabel">Public</label>
						<input id="radPublicNo" name="radPublic" class="required" onclick="javascript:displayController('1');" type="radio" value="0" <?php if($aEachCtrDetails[0]['ispublic'] == 0) print 'checked="checked"';?>/>
						<label for="radPublicNo" class="radiolabel">Private</label>
					</div>
				</div>
				<div class="col-lg-3 osf-content-left">
					<div class="form-group">
						<label for="radPublic" class="error" style="display:none;">Please select a radio button.</label>
						<?php 
						if(stripslashes($aEachCtrDetails[0]['ispublic']) == 0) $sDisplay = "block";
						else $sDisplay = "none";
						?>
						<div class="divSpacing" style="display:<?php print $sDisplay;?>;" id="dispController">
						<label>Select Sign In Controller</label>
						<select name="selController" id="selController" class="form-control">
							<option value="">Select Sign In Controller</option>
							<?php
							foreach($aPublicControllers as $aRow) { ?>
							<option <?php if($_POST['selController'] == stripslashes($aRow['ctrid']) || stripslashes($aEachCtrDetails[0]['signinctrid']) == stripslashes($aRow['ctrid'])) print 'selected="selected"';?> value="<?php print stripslashes($aRow['ctrid']);?>">
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
					<input type="hidden" name="hidEditStatus" id="hidEditStatus" value="1" />
					<div class="form-group">
						<button class="btn btn-primary" type="submit" href="javascript:void(0);" onclick="javascript:editController();"><i class="fa fa-check-square-o"></i> Submit</button>
		            </div>
				</div>
			</div>
			</form>
				
			<script type="text/javascript">
			function editController()
			{
			 	$("#frmControllerEdit").validate();
			 	$("#frmControllerEdit").submit();
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








