<div class="container" role="main">
	<?php if (isset($_GET['PC']) && isset($_GET['PF']) && $_GET['PF'] == '1') { ?>
	<div class="alert alert-success" role="alert">The new event <strong><?php print $_GET['PC'];?></strong> has successfully been added.</div>
	<?php } else if (isset($_GET['PC']) && isset($_GET['PF']) && $_GET['PF'] == '2') { ?>
	<div class="alert alert-success" role="alert">The event <strong><?php print $_GET['PC'];?></strong> has successfully been edited.</div>
	<?php } else if (isset($_GET['PC']) && isset($_GET['PF']) && $_GET['PF'] == '3') { ?>
		<div class="alert alert-success" role="alert">The event <strong><?php print $_GET['PC'];?></strong> has successfully been deleted.</div>
	<?php } else if (isset($_GET['PF']) && $_GET['PF'] == '4') { ?>
		<div class="alert alert-success" role="alert">The display order of the Events has successfully been changed.</div>
	<?php } else { ?>
		<div class="alert alert-info" role="alert">The list of events have been presented below. Click on <strong>Edit</strong> icon to edit an event.</div>
	<?php } ?>
	
	<div class="row">
		<div class="col-lg-12">
			<p><a class="btn btn-primary btn-sm" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=29&CtrID=<?php print $_GET['CtrID'];?>" title="Sort Display Order"><i class="fa fa-sort"></i> Sort Display Order</a> <a class="btn btn-primary btn-sm" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=24&CtrID=<?php print $_GET['CtrID'];?>"><i class="fa fa-plus"></i> Add Event</a> <a class="btn btn-primary btn-sm" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=20"><i class="fa fa-chevron-left"></i> Back</a></p>
			<hr/>
			
			<div class="row osf-box-wrapper-color osf-box-default osf-box-tabular-rowheader">
				<div class="col-sm-2 osf-box-tabular-cell-thin osf-box-left">
					Event ID ($APP->ID)
				</div>
				<div class="col-sm-3 osf-box-tabular-cell-thin osf-box-left">
					Event Name ($APP->IDN)
				</div>
				<div class="col-sm-3 osf-box-tabular-cell-thin text-center">
					User Roles Which Access Event
				</div>
				<div class="col-sm-1 osf-box-tabular-cell-thin text-center">
					Status
				</div>
				<div class="col-sm-3 osf-box-tabular-cell-thin text-center">
					Action
				</div>
			</div>
			<?php if(count($aEventDetails) > 0) {
			foreach($aEventDetails as $aRow) { 
			$sRoleName   = $oEvent->getRoleName(stripslashes($aRow['roles']));   
			if($aRow['estatus'] == 1) $sStatus = 'Active';
			else $sStatus = 'Inactive';    
			?>
			<div class="row osf-box-wrapper-color osf-box-default osf-box-tabular-row">
				<div class="col-sm-2 osf-box-tabular-cell-thin osf-box-left">
					<?php print stripslashes($aRow['eventid']); if ($aCtrDetails[0]['defaulteventid'] == $aRow['eventid']) print ' <em>[Default Event]</em>';?>
				</div>
				<div class="col-sm-3 osf-box-tabular-cell-thin osf-box-left">
					<?php print stripslashes($aRow['eventname']); ?>
				</div>
				<div class="col-sm-3 osf-box-tabular-cell-thin osf-box-left">
					<?php print $sRoleName; ?>
				</div>
				<div class="col-sm-1 osf-box-tabular-cell-thin text-center">
					<?php if($aRow['estatus'] == 1) { ?>
						<i style="color:green;" class="fa fa-circle fa-lg"></i><br/><a href="javascript:void(0);" onclick="javascript:changeStatus('<?php print $aRow['estatus']; ?>', '<?php print $aRow['eventid']; ?>', '<?php print $_GET['CtrID']; ?>');"><span style="font-size:11px;">Change</span></a>
					<?php } elseif($aRow['estatus'] == 0) { ?>
						<i style="color:red;" class="fa fa-circle fa-lg"></i><br/><a href="javascript:void(0);" onclick="javascript:changeStatus('<?php print $aRow['estatus']; ?>', '<?php print $aRow['eventid']; ?>', '<?php print $_GET['CtrID']; ?>');"><span style="font-size:11px;">Change</span></a>
					<?php } ?>
				</div>
				<div class="col-sm-1 osf-box-tabular-cell-thin text-center">
					<a href="<?php print '../../'.stripslashes($aCtrDetails[0]['ctrname']).'?ID='.stripslashes($aRow['eventid']); ?>" target="_blank"><i class="fa fa-random fa-lg"></i></a>
				</div>
				<div class="col-sm-1 osf-box-tabular-cell-thin text-center">
					<a href="<?php print $_SERVER['PHP_SELF'].'?ID=25&RecID='.stripslashes($aRow['eventid']).'&CtrID='.$_GET['CtrID']; ?>"><i class="fa fa-edit fa-lg"></i></a>
				</div>
				<div class="col-sm-1 osf-box-tabular-cell-thin text-center">
					<a href="<?php print $_SERVER['PHP_SELF'].'?ID=26&RecID='.stripslashes($aRow['eventid']).'&CtrID='.$_GET['CtrID']; ?>"  onclick="javascript:return confirm(&quot;Do you want to delete?&quot;);"><i class="fa fa-times-circle fa-lg"></i></a>
				</div>
			</div>
			
			<?php } } else {?>
			<div class="row bs-box-wrapper-color osf-box-default bs-box-tabular-row">
				<div class="col-sm-12 text-center bs-box-tabular-cell-thin">
					<h5 style="color:red;">The Controller currently has no event. <a href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=24&CtrID=<?php print $_GET['CtrID'];?>" title="Please create one now!">Please create one now!</a></h5>
				</div>
			</div>
			<?php }?>
			
			
			
			<script type="text/javascript">
			function changeStatus(iStatus, iEventId, iCtrID)
			{ 	
			 $.ajax({
				   type: "POST",
				   url: "<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=108",
				   data: "requeststatus="+iStatus+"&requesteventid="+iEventId,
				   success: function(msg)
				   {
				   	  if(msg == "1") self.location.href = '<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=21&CtrID='+iCtrID+'&Msg=1';
				   	  else if(msg == "2") self.location.href = '<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=21&CtrID='+iCtrID+'&Msg=2';
			       }
				 });
			}
			</script>
			
		</div>
	</div>
</div>
