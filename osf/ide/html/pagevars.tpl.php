<div class="container" role="main">
	<?php if (isset($_GET['PC']) && isset($_GET['PF']) && $_GET['PF'] == '1') { ?>
	<div class="alert alert-success" role="alert">The new view page variable has successfully been added. Please check in the list below.</div>
	<?php } else if (isset($_GET['PC']) && isset($_GET['PF']) && $_GET['PF'] == '2') { ?>
	<div class="alert alert-success" role="alert">The view page variable <strong><?php print $_GET['PC'];?></strong> has successfully been edited.</div>
	<?php } else if (isset($_GET['PC']) && isset($_GET['PF']) && $_GET['PF'] == '3') { ?>
		<div class="alert alert-success" role="alert">The view page variable <strong><?php print $_GET['PC'];?></strong> has successfully been deleted.</div>
	<?php } else { ?>
		<div class="alert alert-info" role="alert">The list of view page variables have been presented below.</div>
	<?php } ?>
	
	<div class="row">
		<div class="col-lg-12">
			<p><a class="btn btn-primary btn-sm" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=91"><i class="fa fa-plus"></i> Add Page Variables</a></p>
			<hr/>
			
			<div class="row osf-box-wrapper-color osf-box-default osf-box-tabular-rowheader">
				<div class="col-sm-2 osf-box-tabular-cell-thin osf-box-left">
					PageVar #
				</div>
				<div class="col-sm-9 osf-box-tabular-cell-thin osf-box-left">
					Page Variable Key
				</div>
				<div class="col-sm-1 osf-box-tabular-cell-thin text-center">
					Action
				</div>
			</div>
			<?php 
			if(count($aPagevarDetails) > 0) 
			{ 
			foreach($aPagevarDetails as $aRow) 
			{
			?>
			<div class="row osf-box-wrapper-color osf-box-default osf-box-tabular-row">
				<div class="col-sm-2 osf-box-tabular-cell-thin osf-box-left">
					<?php print stripslashes($aRow['pagevarid']); ?>
				</div>
				<div class="col-sm-9 osf-box-tabular-cell-thin osf-box-left">
					<?php print stripslashes($aRow['pagevarkey']); ?>
				</div>
				<!--<div class="col-sm-1 osf-box-tabular-cell-thin text-center">
					<a href="<?php print $_SERVER['PHP_SELF'].'?ID=92&RecID='.stripslashes($aRow['pagevarid']); ?>"><i class="fa fa-edit fa-lg"></i></a>
				</div>-->
				<div class="col-sm-1 osf-box-tabular-cell-thin text-center">
					<?php if($aRow['pagevarid'] > 3){?>
						<a href="<?php print $_SERVER['PHP_SELF'].'?ID=93&RecID='.stripslashes($aRow['pagevarid']); ?>"  onclick="javascript:return confirm(&quot;Do you want to delete?&quot;);"><i class="fa fa-times-circle fa-lg"></i></a>
					<?php }else{?>
						&nbsp;
					<?php }?>
				</div>
			</div>
			
			<?php } } else {?>
			<div class="row osf-box-wrapper-color osf-box-default bs-box-tabular-row">
				<div class="col-sm-12 text-center bs-box-tabular-cell-thin">
					<h5 style="color:red;">No pagevars found.</h5>
				</div>
			</div>
			<?php }?>
			
		</div>
	</div>
</div>
