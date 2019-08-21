<div class="container" role="main">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">

            <div class="account-wall text-center ">
                <!--<i class="fa fa-5x fa-lock"></i>-->
				<!-- <div class="row">
					<div class="col-xs-2">
						<a href="<?php print $APP->BASEURL?>/login/sso.php?IDP=Yahoo"><i class="fa fa-2x fa-yahoo"></i></a>
					</div>
					<div class="col-xs-3">
						<a href="<?php print $APP->BASEURL?>/login/sso.php?IDP=Twitter"><i class="fa fa-2x fa-twitter"></i></a>
					</div>
					<div class="col-xs-2">
						<a href="<?php print $APP->BASEURL?>/login/sso.php?IDP=Google"><i class="fa fa-2x fa-google"></i></a>
					</div>
					<div class="col-xs-3">
						<a href="<?php print $APP->BASEURL?>/login/sso.php?IDP=Live"><i class="fa fa-2x fa-windows"></i></a>
					</div>
					<div class="col-xs-2">
						<a href="<?php print $APP->BASEURL?>/login/sso.php?IDP=Facebook"><i class="fa fa-2x fa-facebook"></i></a>
					</div>
				</div> -->
        <h1 class="text-center"><img src="https://img.icons8.com/ios/50/000000/user-male-circle.png"></h1>
        <h4 style="font-weight: bold;">Login</h4>
				<hr/>

                <form id="frmLogin" class="form-signin" method="post" action="<?php print $APP->BASEURL?>/login/index.php?ID=2">
                  <input type="hidden" name="hidStatus" value="1">
                	<?php if (isset($sErrMsg)) print '<div class="alert alert-danger" role="alert">'.$sErrMsg.'</div>';?>
					<div class="form-group">
            <h5 class="text-left" style="padding-bottom: 10px;">Username:</h5>
						<input type="text" id="txtUsername" name="txtUsername" class="form-control" placeholder="Email" required autofocus>
					</div>
					<div class="form-group">
                    <h5 class="text-left" style="padding-bottom: 10px;">Password:</h5>
                		<input type="password" id="txtPassword" name="txtPassword" class="form-control" placeholder="Password" required>
					</div>
					<div class="form-group">
                		<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
					</div><br>
                	   <a class="pull-left" href="<?php echo $APP->BASEURL ?>/index.php?ID=15">New User? Click here!</a>
                		<!-- <a href="<?php print $APP->BASEURL?>/login/index.php?ID=3" class="pull-right need-help">Need help? </a><span class="clearfix"></span> -->
                </form>
            </div>
            <!--<h4 class="text-center osf-top-space"><a href="#">Create an account</a></h4>-->
        </div>
    </div>
</div> <!-- /container -->

<script type="text/javascript">
 function submitContactForm()
 {
 	$("#frmLogin").validate();
 	$("#frmLogin").submit();
 }
 </script>
