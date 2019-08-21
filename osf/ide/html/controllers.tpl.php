<div class="container" role="main">
	<?php if (isset($_GET['PC']) && isset($_GET['PF']) && $_GET['PF'] == '1') { ?>
	<div class="alert alert-success" role="alert">The new controller <strong><?php print $_GET['PC'];?></strong> has been successfully added.</div>
	<?php } else if (isset($_GET['PC']) && isset($_GET['PF']) && $_GET['PF'] == '2') { ?>
		<div class="alert alert-success" role="alert">The controller <strong><?php print $_GET['PC'];?></strong> has successfully been edited.</div>
	<?php } else if (isset($_GET['PC']) && isset($_GET['PF']) && $_GET['PF'] == '3') { ?>
		<div class="alert alert-success" role="alert">The controller <strong><?php print $_GET['PC'];?></strong> has successfully been deleted.</div>
	<?php } else if (isset($_GET['PF']) && $_GET['PF'] == '4') { ?>
		<div class="alert alert-success" role="alert">The display order of controllers has successfully been changed.</div>
	<?php } else { ?>
		<div class="alert alert-info" role="alert">The list of controllers have been presented below. Click on a <strong>Controller File</strong> or click on <strong>View Events</strong> icon to see list of events thereof.</div>
	<?php } ?>
	
	<div class="row">
		<div class="col-lg-12">
			<p><a class="btn btn-primary btn-sm" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=27" title="Sort Display Order"><i class="fa fa-sort"></i> Sort Display Order</a> <a class="btn btn-primary btn-sm" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=22"><i class="fa fa-plus"></i> Add Controller</a></p>
			<hr/>
			<div class="row osf-box-wrapper-color osf-box-default osf-box-tabular-rowheader">
				<div class="col-sm-3 osf-box-tabular-cell-thin osf-box-left">
					$_DELIGHT[CTRID]
				</div>
				<div class="col-sm-4 osf-box-tabular-cell-thin osf-box-left">
					Controller File Name (with Path from Root of Application)
				</div>
				<div class="col-sm-1 osf-box-tabular-cell-thin text-center">
					Public?
				</div>
				<div class="col-sm-1 osf-box-tabular-cell-thin text-center">
					Status
				</div>
				<div class="col-sm-3 osf-box-tabular-cell-thin text-center">
					Action
				</div>
			</div>
			<?php 
			if(count($aCtrlDetails) > 0){
			foreach($aCtrlDetails as $aRow) { 
			 $sDefaultEvent = $oControllers->getDefaultEvent(stripslashes($aRow['defaulteventid']));
			 if(stripslashes($aRow['ispublic']) == 1) $sIsPublic = 'Yes';
			 else $sIsPublic = 'No'; 
			 if(stripslashes($aRow['ctrstatus']) == 1) $sCtrStatus = 'Active';
			 else $sCtrStatus = 'Inactive'; 
			 ?>
			<div class="row osf-box-wrapper-color osf-box-default osf-box-tabular-row">
				<div class="col-sm-3 osf-box-tabular-cell-thin osf-box-left">
					<?php print stripslashes($aRow['ctrid']); ?>
				</div>
				<div class="col-sm-4 osf-box-tabular-cell-thin osf-box-left">
					<a href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=21&CtrID=<?php print $aRow['ctrid']; ?>" title="<?php print stripslashes($aRow['ctrname']); ?>">/<?php print stripslashes($aRow['ctrname']); ?></a>
				</div>
				<div class="col-sm-1 osf-box-tabular-cell-thin text-center">
					<?php if($aRow['ispublic'] == 1) { ?>
					<i class="fa fa-unlock fa-lg"></i><br/><a href="javascript:void(0);" onclick="javascript:changePublic('<?php print $aRow['ispublic']; ?>', '<?php print $aRow['ctrid']; ?>');"><span style="font-size:11px;">Change</span></a>
					<?php } elseif($aRow['ispublic'] == 0) { ?>
					<i class="fa fa-lock fa-lg"></i><br/><a href="javascript:void(0);" onclick="javascript:changePublic('<?php print $aRow['ispublic']; ?>', '<?php print $aRow['ctrid']; ?>');"><span style="font-size:11px;">Change</span></a>
					<?php } ?>
				</div>
				<div class="col-sm-1 osf-box-tabular-cell-thin text-center">
					<?php if($aRow['ctrstatus'] == 1) { ?>
					<i style="color:green;" class="fa fa-circle fa-lg"></i><br/><a href="javascript:void(0);" onclick="javascript:changeStatus('<?php print $aRow['ctrstatus']; ?>', '<?php print $aRow['ctrid']; ?>');"><span style="font-size:11px;">Change</span></a>
					<?php } elseif($aRow['ctrstatus'] == 0) { ?>
					<i style="color:red;" class="fa fa-circle fa-lg"></i><br/><a href="javascript:void(0);" onclick="javascript:changeStatus('<?php print $aRow['ctrstatus']; ?>', '<?php print $aRow['ctrid']; ?>');"><span style="font-size:11px;">Change</span></a>
					<?php } ?>
				</div>
				<div class="col-sm-1 osf-box-tabular-cell-thin text-center">
					<a href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=21&CtrID=<?php print $aRow['ctrid']; ?>"><i class="fa fa-file-text fa-lg"></i></a>
				</div>
				<div class="col-sm-1 osf-box-tabular-cell-thin text-center">
					<a href="<?php print $_SERVER['PHP_SELF'].'?ID=23&RecID='.stripslashes($aRow['ctrid']); ?>"><i class="fa fa-edit fa-lg"></i></a>
				</div>
				<div class="col-sm-1 osf-box-tabular-cell-thin text-center">
					<a href="<?php print $_SERVER['PHP_SELF'].'?ID=28&RecID='.stripslashes($aRow['ctrid']); ?>"  onclick="javascript:return confirm(&quot;Do you want to delete?&quot;);"><i class="fa fa-times-circle fa-lg"></i></a>
				</div>
			</div>
			
			<?php } } else {?>
			<div class="row bs-box-wrapper-color osf-box-default bs-box-tabular-row">
				<div class="col-sm-12 text-center bs-box-tabular-cell-thin">
					<h5 style="color:red;">No controller found.</h5>
				</div>
			</div>
			<?php }?>
			
			
			<script type="text/javascript">
			function changeStatus(iStatus, iCtrlId)
			{ 	
			 $.ajax({
				   type: "POST",
				   url: "<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=106",
				   data: "requeststatus="+iStatus+"&requestctrlid="+iCtrlId,
				   success: function(msg)
				   {
				   	  if(msg == "1") self.location.href = '<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=20&Msg=1';
				   	  else if(msg == "2") self.location.href = '<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=20&Msg=2';	   
			       }
				 });
			}
			
			function changePublic(iPublic, iCtrlId)
			{ 	
			 $.ajax({
				   type: "POST",
				   url: "<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=107",
				   data: "requestpublic="+iPublic+"&requestctrlid="+iCtrlId,
				   success: function(msg)
				   {
				   	  if(msg == "1") self.location.href = '<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=20&Msg=3';
				   	  else if(msg == "2") self.location.href = '<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=20&Msg=4';	   
			       }
				 });
			}
			</script>
			
			
		</div>
	</div>
</div>
