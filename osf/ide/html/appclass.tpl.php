<div class="container" role="main">
	<?php if ($aMsg[0] == 1) { ?>
	<div class="alert alert-danger" role="alert"><?php print $aMsg[1];?></div>
	<?php } else { ?>
	<div class="alert alert-info" role="alert">The list of application classes have been presented below. Click on <strong>Edit</strong> icon to edit.</div>
	<?php } ?>
	
	<div class="row">
		<div class="col-lg-12">
			<p><a class="btn btn-primary btn-sm" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=31"><i class="fa fa-plus"></i> Add Application Class</a></p>
			<hr/>
			
			<div class="row osf-box-wrapper-color osf-box-default osf-box-tabular-rowheader">
				<div class="col-sm-1 osf-box-tabular-cell-thin osf-box-left">
					Sl. No.
				</div>
				<div class="col-sm-6 osf-box-tabular-cell-thin osf-box-left">
					Class Name (File name is the same as class name but with .cls.php appended)
				</div>
				<div class="col-sm-1 osf-box-tabular-cell-thin text-center">
					Size of Class File (KB)
				</div>
				<div class="col-sm-2 osf-box-tabular-cell-thin text-center">
					Last Update
				</div>
				<div class="col-sm-2 osf-box-tabular-cell-thin text-center">
					Action
				</div>
			</div>
			<?php 
			if(count($aAppClassDetails) > 0){
			$k = 1;
			foreach($aAppClassDetails as $aRow) {
			$aFileName = explode('.cls.php', $aRow['name']);
			?>
			<div class="row osf-box-wrapper-color osf-box-default osf-box-tabular-row">
				<div class="col-sm-1 osf-box-tabular-cell-thin osf-box-left">
					<?php print $k++; ?>
				</div>
				<div class="col-sm-6 osf-box-tabular-cell-thin osf-box-left">
					<?php print stripslashes($aFileName[0]); ?>
				</div>
				<div class="col-sm-1 osf-box-tabular-cell-thin osf-box-left">
					<?php print stripslashes($aRow['size']); ?>
				</div>
				<div class="col-sm-2 osf-box-tabular-cell-thin text-center">
					<?php print stripslashes($aRow['time']); ?>
				</div>
				<div class="col-sm-1 osf-box-tabular-cell-thin text-center">
					<a href="<?php print $_SERVER['PHP_SELF'].'?ID=32&Class='.stripslashes($aFileName[0]); ?>"><i class="fa fa-edit fa-lg"></i></a>
				</div>
				<div class="col-sm-1 osf-box-tabular-cell-thin text-center">
					<a href="<?php print $_SERVER['PHP_SELF'].'?ID=33&Class='.stripslashes($aFileName[0]); ?>"  onclick="javascript:return confirm(&quot;Do you want to delete?&quot;);"><i class="fa fa-times-circle fa-lg"></i></a>
				</div>
			</div>
			
			<?php } } else {?>
			<div class="row osf-box-wrapper-color osf-box-default bs-box-tabular-row">
				<div class="col-sm-12 text-center bs-box-tabular-cell-thin">
					<h5 style="color:red;">No application class is currently present. <a href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=31" title="Add one now!">Add one now!</a></h5>
				</div>
			</div>
			<?php }?>
			
		</div>
	</div>
</div>
