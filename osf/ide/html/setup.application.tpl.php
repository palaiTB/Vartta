<div class="container" role="main">
	<div class="page-header">
		<h1><?php print $APP->PAGEVARS['headertext'];?></h1>
	</div>
	<div class="row">
		<div class="col-lg-12 osf-content-left">
			<form name="frmCreateAppln" id="frmCreateAppln" method="post" action="<?php print $_SERVER['PHP_SELF'];?>?ID=2">
			<div class="text-center" style="margin:40px 0;padding:40px 0;">
			<a href="javascript:void(0);" onclick="javscript:document.getElementById('frmCreateAppln').submit();" title="Setup Application" class="btn btn-lg btn-success"><i class="fa fa-check-square-o"></i> Click to Begin Setup</a>
			</div>
			<input type="hidden" name="hidCreateAppln" id="hidCreateAppln" value="1"/> 
			</form>
		</div>
	</div>
</div>

