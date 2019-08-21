<div class="container" role="main">
	<?php if ($_SESSION['ERROR_CODE'] == '2') { ?>
	<div class="alert alert-success" role="alert"><?php print $_SESSION['ERROR_MSG'];?></div>
	<?php } else { ?>
	<div class="alert alert-info" role="alert">Please choose the SSO servers you would like to setup and fill in their respective details.</div>
	<?php } $_SESSION['ERROR_CODE'] = ''; ?>

	<div class="row">
		<div class="col-lg-12">
			<p><a class="btn btn-primary btn-sm" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=100"><i class="fa fa-chevron-left"></i> Back</a></p>
			<hr/>
			<?php
			//print_r($aSSOSettings);print '<br/><br/>';
			//print $aSSOSettings['providers']['Google']['keys']['id'];
			?>
			<form role="form" name="frmSysEdit" id="frmSysEdit" action="<?php print $_SERVER['PHP_SELF'].'?ID=110&RecID='.stripslashes($aEachSysDetails[0]['sysid']);?>" method="post">
			<div class="row">
				<div class="col-lg-12 osf-content-left">
					<label>Tick up to three SSO (Single-Sign On) Identity Providers and fill their respective details. Pleaase refer to the associated documentation to access such details.</label>
					<div class="form-group">
		                <div class="checkbox">
							<label>
								<input type="checkbox" name="ssogoogle" id="ssogoogle" value="google" <?php if( isset($aSSOSettings['providers']['Google']['keys']['id']) && (trim($aSSOSettings['providers']['Google']['keys']['id'])!='') ) print 'checked';?>> <strong>Google as Identity Provider</strong>
							</label>
						</div>
						<div class="row">
							<div class="col-lg-6 osf-content-left">
								<label>Client ID</label>
								<input type="text" name="txtGoogleClientID"  id="txtGoogleClientID" value="<?php if(isset($aSSOSettings['providers']['Google']['keys']['id'])){ print $aSSOSettings['providers']['Google']['keys']['id']; }else{ print ''; } ?>" class="form-control required"/>
							</div>
							<div class="col-lg-6 osf-content-left">
								<label>Client Secret</label>
								<input type="text" name="txtGoogleClientSecret"  id="txtGoogleClientSecret" value="<?php if(isset($aSSOSettings['providers']['Google']['keys']['secret'])){ print $aSSOSettings['providers']['Google']['keys']['secret']; }else{ print ''; } ?>" class="form-control required"/>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12 osf-content-left">
								<p class="help-block">Please refer to the documentation at <a href="https://www.batoi.com/support/articles/article/create-an-app-at-google" target="_blank">https://www.batoi.com/support/articles/article/create-an-app-at-google</a> to create a new App and to get the requisite details to fill in as above. Provide this URL as the Callback URL for your application: <code>https://your_base_url/osf/lib/hybridauth/?hauth.done=Google</code>.</p>
							</div>
						</div>
						<hr/>
						<div class="checkbox">
							<label>
								<input type="checkbox" name="ssolive" id="ssolive" value="live" <?php if( isset($aSSOSettings['providers']['Live']['keys']['id']) && (trim($aSSOSettings['providers']['Live']['keys']['id'])!='') ) print 'checked';?>> <strong>Windows Live as Identity Provider</strong>
							</label>
						</div>
						<div class="row">
							<div class="col-lg-6 osf-content-left">
								<label>Application ID</label>
								<input type="text" name="txtLiveClientID"  id="txtLiveClientID" value="<?php if(isset($aSSOSettings['providers']['Live']['keys']['id'])){ print $aSSOSettings['providers']['Live']['keys']['id']; }else{ print ''; } ?>" class="form-control required"/>
							</div>
							<div class="col-lg-6 osf-content-left">
								<label>Application Secret</label>
								<input type="text" name="txtLiveClientSecret"  id="txtLiveClientSecret" value="<?php if(isset($aSSOSettings['providers']['Live']['keys']['secret'])){ print $aSSOSettings['providers']['Live']['keys']['secret']; }else{ print ''; } ?>" class="form-control required"/>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12 osf-content-left">
								<p class="help-block">Please refer to the documentation at <a href="https://www.batoi.com/support/articles/article/create-an-app-on-the-microsoft-application-registration-por" target="_blank">https://www.batoi.com/support/articles/article/create-an-app-on-the-microsoft-application-registration-por</a> to create a new App and to get the requisite details to fill in as above. Provide this URL as the Callback URL for your application: <code>https://your_base_url/osf/lib/hybridauth/?hauth.done=Live</code>.</p>
							</div>
						</div>
						<hr/>
						<div class="checkbox">
							<label>
								<input type="checkbox" name="ssoyahoo" id="ssoyahoo" value="yahoo" <?php if( isset($aSSOSettings['providers']['Yahoo']['keys']['key']) && (trim($aSSOSettings['providers']['Yahoo']['keys']['key'])!='') ) print 'checked';?>> <strong>Yahoo as Identity Provider</strong>
							</label>
						</div>
						<div class="row">
							<div class="col-lg-6 osf-content-left">
								<label>Client ID</label>
								<input type="text" name="txtYahooClientID"  id="txtYahooClientID" value="<?php if(isset($aSSOSettings['providers']['Yahoo']['keys']['key'])){ print $aSSOSettings['providers']['Yahoo']['keys']['key']; }else{ print ''; } ?>" class="form-control required"/>
							</div>
							<div class="col-lg-6 osf-content-left">
								<label>Client Secret</label>
								<input type="text" name="txtYahooClientSecret"  id="txtYahooClientSecret" value="<?php if(isset($aSSOSettings['providers']['Yahoo']['keys']['secret'])){ print $aSSOSettings['providers']['Yahoo']['keys']['secret']; }else{ print ''; } ?>" class="form-control required"/>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12 osf-content-left">
								<p class="help-block">Please refer to the documentation at <a href="https://www.batoi.com/support/articles/article/create-an-app-in-yahoo" target="_blank">https://www.batoi.com/support/articles/article/create-an-app-in-yahoo</a> to create a new App and to get the requisite details to fill in as above. Provide this URL as the Callback URL for your application: <code>https://your_base_url/osf/lib/hybridauth/?hauth.done=Yahoo</code>.</p>
							</div>
						</div>
						<hr/>
						<div class="checkbox">
							<label>
								<input type="checkbox" name="ssotwitter" id="ssotwitter" value="twitter" <?php if( isset($aSSOSettings['providers']['Twitter']['keys']['key']) && (trim($aSSOSettings['providers']['Twitter']['keys']['key'])!='') ) print 'checked';?>> <strong>Twitter as Identity Provider</strong>
							</label>
						</div>
						<div class="row">
							<div class="col-lg-6 osf-content-left">
								<label>Client ID</label>
								<input type="text" name="txtTwitterClientID"  id="txtTwitterClientID" value="<?php if(isset($aSSOSettings['providers']['Twitter']['keys']['key'])){ print $aSSOSettings['providers']['Twitter']['keys']['key']; }else{ print ''; } ?>" class="form-control required"/>
							</div>
							<div class="col-lg-6 osf-content-left">
								<label>Client Secret</label>
								<input type="text" name="txtTwitterClientSecret"  id="txtTwitterClientSecret" value="<?php if(isset($aSSOSettings['providers']['Twitter']['keys']['secret'])){ print $aSSOSettings['providers']['Twitter']['keys']['secret']; }else{ print ''; } ?>" class="form-control required"/>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12 osf-content-left">
								<p class="help-block">Please refer to the documentation at <a href="https://www.batoi.com/support/articles/article/create-an-app-in-twitter" target="_blank">https://www.batoi.com/support/articles/article/create-an-app-in-twitter</a> to create a new App and to get the requisite details to fill in as above. Provide this URL as the Callback URL for your application: <code>https://your_base_url/osf/lib/hybridauth/?hauth.done=Twitter</code>.</p>
							</div>
						</div>
						<hr/>
						<div class="checkbox">
							<label>
								<input type="checkbox" name="ssofacebook" id="ssofacebook" value="facebook" <?php if( isset($aSSOSettings['providers']['Facebook']['keys']['id']) && (trim($aSSOSettings['providers']['Facebook']['keys']['id'])!='') ) print 'checked';?>> <strong>Facebook as Identity Provider</strong>
							</label>
						</div>
						<div class="row">
							<div class="col-lg-6 osf-content-left">
								<label>App ID</label>
								<input type="text" name="txtFacebookClientID"  id="txtFacebookClientID" value="<?php if(isset($aSSOSettings['providers']['Facebook']['keys']['id'])){ print $aSSOSettings['providers']['Facebook']['keys']['id']; }else{ print ''; } ?>" class="form-control required"/>
							</div>
							<div class="col-lg-6 osf-content-left">
								<label>App Secret</label>
								<input type="text" name="txtFacebookClientSecret"  id="txtFacebookClientSecret" value="<?php if(isset($aSSOSettings['providers']['Facebook']['keys']['secret'])){ print $aSSOSettings['providers']['Facebook']['keys']['secret']; }else{ print ''; } ?>" class="form-control required"/>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12 osf-content-left">
								<p class="help-block">Please refer to the documentation at <a href="https://www.batoi.com/support/articles/article/create-an-app-in-facebook" target="_blank">https://www.batoi.com/support/articles/article/create-an-app-in-facebook</a> to create a new App and to get the requisite details to fill in as above. Provide this URL as the Callback URL for your application: <code>https://your_base_url/osf/lib/hybridauth/?hauth.done=Facebook</code>.</p>
							</div>
						</div>
						<hr/>
		            </div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-12 osf-content-left">
					<input type="hidden" name="hidEditStatus" id="hidEditStatus" value="1" />
					<div class="form-group">
						<button class="btn btn-primary" type="submit" href="javascript:void(0);" onclick="javascript:editSys();"><i class="fa fa-check-square-o"></i> Submit</button>
		            </div>
				</div>
			</div>
			</form>
				
			<script type="text/javascript">
			function editSys()
			{
			 	$("#frmSysEdit").validate();
			 	$("#frmSysEdit").submit();
			}
			</script>
		</div>
	</div>
</div>
