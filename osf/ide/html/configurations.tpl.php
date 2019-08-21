<div class="container" role="main">
	<?php if (isset($_GET['PC']) && isset($_GET['PF']) && $_GET['PF'] == '1') { ?>
	<div class="alert alert-success" role="alert">The new variable has been successfully added. Please check in the list below.</div>
	<?php } else if (isset($_GET['PC']) && isset($_GET['PF']) && $_GET['PF'] == '2') { ?>
	<div class="alert alert-success" role="alert">The variable <strong><?php print $_GET['PC'];?></strong> has successfully been edited.</div>
	<?php } else if (isset($_GET['PC']) && isset($_GET['PF']) && $_GET['PF'] == '3') { ?>
		<div class="alert alert-success" role="alert">The variable <strong><?php print $_GET['PC'];?></strong> has successfully been deleted.</div>
	<?php } else if (isset($_GET['PF']) && $_GET['PF'] == '4') { ?>
		<div class="alert alert-success" role="alert">The display order of configuration variables have successfully been sorted.</div>
	<?php } else { ?>
		<div class="alert alert-info" role="alert">The list of configuration variables have been presented below. You can add, edit and delete any configuration variable.</div>
	<?php } ?>
	
	<div class="row">
		<div class="col-lg-12">
			<p><a class="btn btn-primary btn-sm" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=54" title="Sort Display Order"><i class="fa fa-sort"></i> Sort Display Order</a> <a class="btn btn-primary btn-sm" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=51"><i class="fa fa-plus"></i> Add Configuration Variable</a></p>
			<hr/>
			
			<div class="row osf-box-wrapper-color osf-box-default osf-box-tabular-rowheader">
				<div class="col-sm-1 osf-box-tabular-cell-thin osf-box-left">
					Sl. No.
				</div>
				<div class="col-sm-3 osf-box-tabular-cell-thin osf-box-left">
					Variable Name
				</div>
				<div class="col-sm-4 osf-box-tabular-cell-thin text-center">
					Description
				</div>
				<div class="col-sm-2 osf-box-tabular-cell-thin text-center">
					Value
				</div>
				<div class="col-sm-2 osf-box-tabular-cell-thin text-center">
					Action
				</div>
			</div>
			<?php 
			$i = 0;
			if(count($aConfigDetails) > 0) {
			foreach($aConfigDetails as $aRow) {
			$i++;
			?>
			<div class="row osf-box-wrapper-color osf-box-default osf-box-tabular-row">
				<div class="col-sm-1 osf-box-tabular-cell-thin osf-box-left">
					<?php print $i; ?>
				</div>
				<div class="col-sm-3 osf-box-tabular-cell-thin osf-box-left">
					<?php print stripslashes($aRow['configname']); ?>
				</div>
				<div class="col-sm-4 osf-box-tabular-cell-thin osf-box-left">
					<?php print stripslashes($aRow['description']); ?>
				</div>
				<div class="col-sm-2 osf-box-tabular-cell-thin text-center">
					<?php print stripslashes($aRow['configvalue']); ?>
				</div>
				<div class="col-sm-1 osf-box-tabular-cell-thin text-center">
					<a href="<?php print $_SERVER['PHP_SELF'].'?ID=52&RecID='.stripslashes($aRow['configid']); ?>"><i class="fa fa-edit fa-lg"></i></a>
				</div>
				<div class="col-sm-1 osf-box-tabular-cell-thin text-center">
					<a href="<?php print $_SERVER['PHP_SELF'].'?ID=53&RecID='.stripslashes($aRow['configid']); ?>"  onclick="javascript:return confirm(&quot;Do you want to delete?&quot;);"><i class="fa fa-times-circle fa-lg"></i></a>
				</div>
			</div>
			
			<?php } } else {?>
			<div class="row osf-box-wrapper-color osf-box-default bs-box-tabular-row">
				<div class="col-sm-12 text-center bs-box-tabular-cell-thin">
					<h5 style="color:red;">No configuration variable has been created yet. <a href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=51" title="Add a configuration variable now!">Add a configuration variable now!</a></h5>
				</div>
			</div>
			<?php }?>
			
		</div>
	</div>
</div>
