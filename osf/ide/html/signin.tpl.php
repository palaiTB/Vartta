<div class="container" role="main">
	<div class="page-header">
		<h1><?php print $APP->PAGEVARS['headertext'];?></h1>
	</div>
	<?php if(isset($_REQUEST['Msg'])){ ?>
		<div class="alert alert-success" role="alert">You have signed out successfully. If you want to signin again, please enter your username and password to proceed.</div>
	<?php } else { ?>
		<div class="alert alert-info" role="alert">Please enter your username and password to sign into <strong>Integrated Development Environment (IDE) of opendelight</strong> for application <strong><?php print $aAppDetails[0]['appname'];?></strong>.</div>
	<?php } ?>
	
	<div class="row">
		<div class="col-lg-12 text-center">
			<form role="form" name="frmLogin" id="frmLogin" action="./sign.php?ID=2" method="post" style="max-width: 330px;padding: 15px;margin: 0 auto;">
				<div class="form-group">
					<label for="txtUsername" class="sr-only">Email address</label>
                	<input type="text" id="txtUsername" name="txtUsername" class="form-control" placeholder="Email address" required autofocus>
            	</div>
				<div class="form-group">
					<label for="txtPassword" class="sr-only">Password</label>
                	<input type="password" id="txtPassword" name="txtPassword" class="form-control" placeholder="Password" required >
            	</div>
				
				<div class="form-group">
					<input type="hidden" name="hidStatus" id="hidStatus" value="1" />
                	<button href="javascript:void(0);" onclick="javascript:submitContactForm();" class="btn btn-success btn-block" type="submit">Login</button>
            	</div>
			</form>
		</div>
	</div>
	<hr/>
	<div class="row">
		<div class="col-lg-12 text-center">
			<p><a href="./sign.php?ID=3" title="Forgot Password" style="color:#3a8104;">Forgot Password</a>?</p>
		</div>
	</div>
</div>

<script type="text/javascript">
function submitContactForm()
{
	$("#frmLogin").validate();
	$("#frmLogin").submit();
}
</script>
