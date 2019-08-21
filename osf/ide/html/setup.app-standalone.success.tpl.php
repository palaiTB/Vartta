<div class="container" role="main">
	<div class="page-header">
		<h1><?php print $APP->PAGEVARS['headertext'];?></h1>
	</div>
	<div class="alert alert-success" role="alert">The application <strong><?php print stripslashes($aAppDetails[0]['appname']);?></strong> has been installed successfully.</div>
	<div class="row">
		<div class="col-lg-12 text-center">
			<p>You can now start developing your application.</p>
			<p><strong>Login:</strong> <a href="<?php print stripslashes($aAppDetails[0]['baseurl']);?>/osf/ide/sign.php"><?php print stripslashes($aAppDetails[0]['baseurl']);?>/osf/ide/sign.php</a><br/>
				<strong>Username:</strong> admin<br/>
				<strong>Password:</strong> <?php print $_SESSION['PasswordNew'];?></p>
				<p class="osf-top-space">Remember to change the password after signing in.</p>
				<p><strong>Happy application development!</strong></p>
		</div>
	</div>
</div>
