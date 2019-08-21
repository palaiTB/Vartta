<div class="container" role="main">
	<?php if ($aMsg[0] == 1) { ?>
	<div class="alert alert-danger" role="alert"><?php print $aMsg[1];?></div>
	<?php } else { ?>
	<div class="alert alert-info" role="alert"><?php print $aMsg[1];?></div>
	<?php } ?>

	<div class="row">
		<div class="col-lg-12">
			<p><a class="btn btn-primary btn-sm" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=21&CtrID=<?php print $_GET['CtrID'];?>"><i class="fa fa-chevron-left"></i> Back</a></p>
			<hr/>
			
			<form role="form" name="frmEventEdit" id="frmEventEdit" action="<?php print $_SERVER['PHP_SELF'].'?ID=25&RecID='.stripslashes($aEachEventDetails[0]['eventid']).'&CtrID='.stripslashes($aEachEventDetails[0]['ctrid']);?>" method="post">
			<div class="row">
				<div class="col-lg-4 osf-content-left">
					<div class="form-group">
						<label>Event Name, $APP->IDN</label>
		                <input type="text" name="txtEventName" value="<?php if($_POST['txtEventName']){ print $_POST['txtEventName']; }else{ print stripslashes($aEachEventDetails[0]['eventname']); } ?>" class="form-control required" style="width:250px;" readonly="readonly" />
		                <p class="help-block">(A-Z a-z 0-9, no white space, no special characters, can have dashes or underscores)</p>
		            </div>
				</div>
				<div class="col-lg-4 osf-content-left">
					<div class="form-group">
						<label>Set as Default</label>
		                <input type="checkbox"  <?php if(stripslashes($aEachEventDetails[0]['eventid']) == stripslashes($aCtrDetails[0]['defaulteventid'])) print 'checked="checked"';?> name="chkDefault" id="chkDefault" value="1" />
		                <p class="help-block">This will make the application land at this menu after login (with a normal login).</p>
		            </div>
				</div>
				<div class="col-lg-4 osf-content-left">
					<div class="form-group">
						<label>Roles</label>
						<?php $aRoles  	= $oEvent->getRoles();
						$i = 0;
						foreach($aRoles as $aRow) { 
						$i++;
						$aRolesData = explode(',', stripslashes($aEachEventDetails[0]['roles']));
						
						?>
		                <div class="checkbox">
							<label><input type="checkbox" style="float:left;" <?php if ($aRow['rolename'] == 'Administrator') print 'checked="checked" disabled="disabled"'; else if(in_array(stripslashes($aRow['roleid']),$aRolesData)) print 'checked="checked"';?> name="chkRole<?php print $i;?>" id="chkRole<?php print $i;?>" value="<?php print stripslashes($aRow['roleid']);?>" /> <?php print stripslashes($aRow['rolename']);?></label>
						</div>
						<?php } ?>
		                <p class="help-block">Which user roles will be allowed to access this event?</p>
		            </div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-6 osf-content-left">
					<div class="form-group">
						<label>Event Verifier</label>
		                <input type="text" name="txtEventVerifier"  id="txtEventVerifier" value="<?php if($_POST['txtEventVerifier']){ print htmlentities($_POST['txtEventVerifier']); }else{ print htmlentities($aEachEventDetails[0]['eventverifier']); } ?>" class="form-control" />
		                <p class="help-block">(Additional boolean expression that needs to be satisfied to make the event executed successfully)</p>
		            </div>
				</div>
				<div class="col-lg-6 osf-content-left">
					<div class="form-group">
						<label>Form Rules</label>
		                <input type="text" name="txtFormrules"  id="txtFormrules" value="<?php if($_POST['txtFormrules']){ print htmlentities($_POST['txtFormrules']); }else{ print htmlentities($aEachEventDetails[0]['formrules']); } ?>" class="form-control" />
		                <p class="help-block">(An array with information about form validation and sanitization as required)</p>
		            </div>
				</div>
			</div>
			
			
			<div class="row">
				<div class="col-lg-12 osf-content-left">
					<label>Code for Calling Application Objects and Including External Scripts</label>
					<textarea name="taBusinessLogic" id="textarea_1" class="form-control" rows="15" cols="15"><?php if($_POST['taBusinessLogic']) print print $_POST['taBusinessLogic']; else print stripslashes($aEachEventDetails[0]['blcode']); ?></textarea>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-12 osf-content-left">
					<div class="form-group">
						<label>View Page Parts</label>
		                <input type="text" name="txtViewParts"  id="txtViewParts" value="<?php if($_POST['txtViewParts']){ print $_POST['txtViewParts']; }else{ print stripslashes($aEachEventDetails[0]['viewparts']); } ?>" class="form-control" />
		                <p class="help-block">(A comma-separated ordered list of HTML files to be called for creating UI)</p>
		            </div>
				</div>
			</div>
			
			<?php 
			$j = 0;
			$sPagevars = stripslashes($aEachEventDetails[0]['pagevars']);
			$aPagevars = explode("^", $sPagevars);
			foreach($aPageVarDetails as $aRow) {
			$j++;
			?>
			<div class="row">
				<div class="col-lg-12 osf-content-left">
					<div class="form-group">
						<label>Web Page Variable: <?php print stripslashes($aRow['pagevarkey']);?></label>
		                <input type="text" name="txtPagevars<?php print $j;?>" id="txtPagevars<?php print $j;?>" class="form-control" value="<?php print $aPagevars[$j - 1];?>" />
		            </div>
				</div>
			</div>
			<?php } ?>
			
			<div class="row">
				<div class="col-lg-12 osf-content-left">
					<input type="hidden" name="hidEditStatus" id="hidEditStatus" value="1" />
					<input type="hidden" name="hidCtrlID" id="hidCtrlID" value="<?php print $_GET['CtrID']; ?>" />
					<input type="hidden" name="hidNumRoles" id="hidNumRoles" value="<?php print $i; ?>" />
					<input type="hidden" name="hidNumPagevars" id="hidNumPagevars" value="<?php print count($aPageVarDetails); ?>" />
					<input type="hidden" name="hidTextArea" id="hidTextArea" value="" />
					<div class="form-group">
						<button class="btn btn-primary" type="submit" href="javascript:void(0);" onclick="javascript:editEvent();"><i class="fa fa-check-square-o"></i> Submit</button>
		            </div>
				</div>
			</div>
			</form>
				
			<script type="text/javascript">
			function editEvent()
			{
				document.getElementById('frmEventEdit').hidTextArea.value = editAreaLoader.getValue("textarea_1");
			 	$("#frmEventEdit").validate();
			 	$("#frmEventEdit").submit();
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
