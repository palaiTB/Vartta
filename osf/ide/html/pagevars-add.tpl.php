<div class="container" role="main">
	<?php if ($aMsg[0] == 1) { ?>
	<div class="alert alert-danger" role="alert"><?php print $aMsg[1];?></div>
	<?php } else { ?>
	<div class="alert alert-info" role="alert">Please fill up the following form to create a new role.</div>
	<?php } ?>

	<div class="row">
		<div class="col-lg-12">
			<p><a class="btn btn-primary btn-sm" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=90"><i class="fa fa-chevron-left"></i> Back</a></p>
			<hr/>
			
			<form role="form" name="frmPagevarAdd" id="frmPagevarAdd" action="<?php print $_SERVER['PHP_SELF'].'?ID=91';?>" method="post">
			<div class="row">
				<div class="col-lg-12 osf-content-left">
					<div class="form-group">
						<label>Variable Key</label>
		                <input type="text" name="txtPagevarKey" id="txtPagevarKey" value="<?php if (isset($_POST['txtPagevarKey'])) print $_POST['txtPagevarKey'];?>" class="form-control required"/>
						<p class="help-block">(A-Z 0-9, and no white space, no special characters)</p>
		            </div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-12 osf-content-left">
					<input type="hidden" name="hidAddStatus" id="hidAddStatus" value="1" />
					<div class="form-group">
						<button class="btn btn-primary" type="submit" href="javascript:void(0);" onclick="javascript:addPagevar();"><i class="fa fa-check-square-o"></i> Submit</button>
		            </div>
				</div>
			</div>
			</form>
				
			<script type="text/javascript">
			function addPagevar()
			{
			 	$("#frmPagevarAdd").validate();
			 	$("#frmPagevarAdd").submit();
			}
			</script>
		</div>
	</div>
</div>
