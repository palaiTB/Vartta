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
              <a class="navbar-brand" href="#"><img src="../ide/images/ide-logo.png" alt="OSF IDE">
			  </a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
			  	<ul class="nav navbar-nav">
					<li><a href="#"><?php print $aAppDetails[0]['appname'];?></a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
		        	<li><a href="https://www.batoi.com/opendelight/docs/ide" target="_blank"><i class="fa fa-info-circle"></i></a></li>
				</ul>
            </div><!--/.nav-collapse -->
          </div>
	  </nav>
	  