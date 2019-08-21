<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php print $APP->PAGEVARS['title']; ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="../ide/images/favicon.ico">
    <link rel="apple-touch-icon" href="../ide/images/apple-touch-icon.png">
	<link rel="stylesheet" href="https://www.batoi.com/themes/preview/pub/css/theme.php?theme=basic&dev=y&navbar=appfixed">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="../ide/codeeditor/lib/codemirror.css">
</head>
<body>
<!--[if lt IE 8]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]--><!-- Fixed navbar -->
        <nav class="navbar navbar-inverse navbar-fixed-top">
          <div class="container osf-navbar-img-sm">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=1"><img src="./images/ide-logo.png" alt="OSF IDE">
			  </a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php print $aAppDetails[0]['appname'];?> <span class="caret"></span></a>
                  	<ul class="dropdown-menu">
                  		<li><a href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=20">Controllers and Events</a></li>
                    	<li role="separator" class="divider"></li>
                    	<li class="dropdown-header">Model</li>
                    	<li><a href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=30" title="Application Classes">Application Classes</a></li>
						<li><a href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=35" title="Script Includes">Script Includes</a></li>
						<li><a href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=50" title="Configuration Variables">Configuration Variables</a></li>
						<li role="separator" class="divider"></li>
                    	<li class="dropdown-header">View</li>
						<li><a href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=40&VFT=html" title="View Page Parts">View Page Parts</a></li>
						<li><a href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=90" title="View Page Variables">View Page Variables</a></li>
						<li><a href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=40&VFT=js" title="JavaScript Files">JavaScript Files</a></li>
						<li><a href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=40&VFT=css" title="CSS Files">CSS Files</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=63">Users and Roles</a></li>
						<li><a href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=80">Lifestream</a></li>
						<li><a href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=100">Application Settings</a></li>
					
                  </ul>
                </li>
              </ul>
			  <ul class="nav navbar-nav navbar-right">
		        <li><a href="https://www.batoi.com/framework/documentation/" target="_blank"><i class="fa fa-book"></i></a></li>
		        <li class="dropdown">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> Administrator <span class="caret"></span></a>
		          <ul class="dropdown-menu">
					  <li><a href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=104"><i class="fa fa-key"></i> Change Password</a></li>
		            <li role="separator" class="divider"></li>
		            <li><a href="<?php print $APP->BASEURL;?>/osf/ide/sign.php?ID=5"><i class="fa fa-sign-out"></i> Logout</a></li>
		          </ul>
		        </li>
			</ul>
            </div><!--/.nav-collapse -->
          </div>
	  </nav>
	  
	  <div class="container" role="main">
		  <?php if($APP->PAGEVARS['breadcrumb'] != '') { ?>
			  <ol class="breadcrumb"><?php print $APP->PAGEVARS['breadcrumb'];?></ol>
		  <?php } ?>
		  <div class="page-header">
			  <h1><?php print $APP->PAGEVARS['headertext'];?></h1>
		  </div>
	  </div>
