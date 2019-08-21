<div class="container" role="main">
	<?php if ($_SESSION['ERROR_CODE'] == '2') { ?>
	<div class="alert alert-success" role="alert">The application settings have successfully been edited.</div>
	<?php } else { ?>
	<div class="alert alert-info" role="alert">The list of lifestream log files (date-wise) have been presented below. Click on file or <strong>View</strong> icon to see the log on a particular date.</div>
	<?php } $_SESSION['ERROR_CODE'] = ''; ?>

	<div class="row">
		<div class="col-lg-12">
			<p><a class="btn btn-danger btn-sm" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=83"><i class="fa fa-times-circle"></i> Remove History</a></p>
			<hr/>
			
			<div class="row osf-box-wrapper-color osf-box-default osf-box-tabular-rowheader">
				<div class="col-sm-1 osf-box-tabular-cell-thin osf-box-left">
					Sl. No.
				</div>
				<div class="col-sm-6 osf-box-tabular-cell-thin osf-box-left">
					Log Files (Date-wise)
				</div>
				<div class="col-sm-3 osf-box-tabular-cell-thin osf-box-left">
					Size of Log File (KB)
				</div>
				<div class="col-sm-2 osf-box-tabular-cell-thin osf-box-left">
					Action
				</div>
			</div>
			<?php 
			if(count($aListofFiles) > 0){
			$k = 1;
			foreach($aListofFiles as $aRow) {
			?>
			<div class="row osf-box-wrapper-color osf-box-default osf-box-tabular-row">
				<div class="col-sm-1 osf-box-tabular-cell-thin osf-box-left">
					<?php print $k++; ?>
				</div>
				<div class="col-sm-6 osf-box-tabular-cell-thin osf-box-left">
					<a href="<?php print $_SERVER['PHP_SELF'].'?ID=81&File='.stripslashes($aRow['name']); ?>" title="<?php print stripslashes($aRow['name']); ?>"><?php print stripslashes($aRow['name']); ?></a>
				</div>
				<div class="col-sm-3 osf-box-tabular-cell-thin osf-box-left">
					<?php print stripslashes($aRow['size']); ?>
				</div>
				<div class="col-sm-1 osf-box-tabular-cell-thin osf-box-left">
					<a href="<?php print $_SERVER['PHP_SELF'].'?ID=81&File='.stripslashes($aRow['name']); ?>"><i class="fa fa-view-file-o fa-lg"></i></a>
				</div>
				<div class="col-sm-1 osf-box-tabular-cell-thin osf-box-left">
					<a href="<?php print $_SERVER['PHP_SELF'].'?ID=82&File='.stripslashes($aRow['name']); ?>" onclick="javascript:return confirm(&quot;Do you want to delete?&quot;);"><i class="fa fa-times-circle fa-lg"></i></a>
				</div>
			</div>
			
			<?php } } else {?>
			<div class="row osf-box-wrapper-color osf-box-default bs-box-tabular-row">
				<div class="col-sm-12 text-center bs-box-tabular-cell-thin">
					<h5 style="color:red;">No log file is currently present.</h5>
				</div>
			</div>
			<?php }?>
			
			</div>
	</div>
</div>
