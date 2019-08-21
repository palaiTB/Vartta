<?php
$current_url = $_SERVER['REQUEST_URI'];
$current_url_peices_array = explode('/', $current_url);
$ob=new artcls();
$id=$ob->role($_SESSION['USERID']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Vartta - News Portal</title>
  <link rel="shortcut icon" type="image/png" href="<?php echo $APP->BASEURL ?>/pub/images/icons8-news-32.png">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css?family=Monoton|Patrick+Hand|Quicksand&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Fredoka+One&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Cookie&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
  <link rel="stylesheet" href="<?php echo $APP->BASEURL; ?>/pub/css/styles.css">
	<link rel="stylesheet" href="<?php echo $APP->BASEURL; ?>/pub/css/esuite.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
</head>
<body class="m-0 text-focus-in">
<nav class="navbar navbar-expand-lg navbar-dark fixed-top custom-carets" style="background-color: #211717;">
	<div class="container">
  <a style="font-weight: medium;" class="navbar-brand navcolor" href="<?php echo $APP->BASEURL ?>" style=" font-size: 1.2rem;"><i class="fab fa-viacoin"></i> AMS</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">

    <ul class="navbar-nav ml-auto" ><!--created a new Ul for the category tab so that it can be centered-->
      <?php
    if(isset($_SESSION['USERID']) && $id=='1'){ ?> <!--in_array('admin', $current_url_peices_array)-->

      <div class="dropdown" >
      <button  class="btn dropdown-toggle nav-link" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 15px; font-weight:medium; color: white;	">
        Action <i class="fa fa-angle-down"></i>
      </button>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <a class="dropdown-item" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=20">Controllers and Events</a>
          <li role="separator" class="divider"></li>
          <li class="dropdown-header" style="font-weight: medium;">Model</li>
          <li><a class="dropdown-item" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=30" title="Application Classes">Application Classes</a></li>
          <li><a class="dropdown-item" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=35" title="Script Includes">Script Includes</a></li>
          <li><a class="dropdown-item" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=50" title="Configuration Variables">Configuration Variables</a></li>
          <li role="separator" class="divider"></li>
          <li class="dropdown-header"  style="font-weight: medium;">View</li>
          <li><a class="dropdown-item" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=40&VFT=html" title="View Page Parts">View Page Parts</a></li>
          <li><a class="dropdown-item" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=90" title="View Page Variables">View Page Variables</a></li>
          <li><a class="dropdown-item" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=40&VFT=js" title="JavaScript Files">JavaScript Files</a></li>
          <li><a class="dropdown-item" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=40&VFT=css" title="CSS Files">CSS Files</a></li>
          <br>
          <li role="separator" class="divider"></li>
          <li><a class="dropdown-item" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=63">Users and Roles</a></li>
          <li><a class="dropdown-item" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=80">Lifestream</a></li>
          <li><a class="dropdown-item" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=100">Application Settings</a></li>
      </div>
    </div>

      <li class="nav-item">
      <a class="nav-link navcolor " href=<?php echo $APP->BASEURL ?> style="font-size: 15px; font-weight:medium;" data-method="POST">Home</a></li>


			<div class="dropdown">
				<button class=" btn dropdown-toggle nav-link " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 15px; font-weight: lighter;">
					Web Mining (beta) <i class="fa fa-angle-down"></i>
				</button>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<li><a class="dropdown-item" href="<?php echo $APP->BASEURL ?>/index.php?ID=19&scrape=occ">OCC news</a></li>
					<li><a class="dropdown-item" href="<?php echo $APP->BASEURL ?>/index.php?ID=19&scrape=frs">Federal Reserve System</a></li>
					<li><a class="dropdown-item" href="<?php echo $APP->BASEURL ?>/index.php?ID=19&scrape=fdic">FDIC</a></li>
					<li><a class="dropdown-item" href="<?php echo $APP->BASEURL ?>/index.php?ID=19&scrape=exim">EXIM</a></li>
					<li><a class="dropdown-item" href="<?php echo $APP->BASEURL ?>/index.php?ID=19&scrape=fca">FCA</a></li>
					<li><a class="dropdown-item" href="<?php echo $APP->BASEURL ?>/index.php?ID=19&scrape=cftc">CFTC</a></li>
					<li><a class="dropdown-item" href="<?php echo $APP->BASEURL ?>/index.php?ID=19&scrape=hud">HUD</a></li>
					<li><a class="dropdown-item" href="<?php echo $APP->BASEURL ?>/index.php?ID=19&scrape=nych">NYCHA</a></li>
					<li><a class="dropdown-item" href="<?php echo $APP->BASEURL ?>/index.php?ID=19&scrape=phl">Philadelphia Events</a></li>
					<!-- <li><a class="dropdown-item" href="<?php echo $APP->BASEURL ?>/index.php?ID=19&scrape=main">Data Scraping</a></li> -->
				</div>
			</div>
      <?php }?>

        <div class="dropdown" >
        <a class="dropdown-toggle nav-link" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 15px; color: white">
          Categories <i class="fa fa-angle-down"></i>
        </a>

        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

          <?php
          $catgry=new category();
          $result=$catgry->view();

          foreach($result as $key=>$value)
          {
            echo "<a class='dropdown-item' href='".$APP->BASEURL."/index.php?category=".strtolower($value['category'])."'>".$value['category'].'</a>';
          }
           ?>
            <!-- <a class="dropdown-item" href="<?php print $APP->BASEURL;?>/osf/ide/index.php?ID=20">Controllers and Events</a> -->
        </div>
      </div>

	<!-- ********************************************************************************HIDDEN****************************************************************************************************		 -->
	<li class="nav-item">
		<a class="nav-link navcolor " href="<?php echo $APP->BASEURL; ?>/index.php?ID=17" style="font-size: 15px; font-weight:medium;">Agencies</a>
	</li>

<!-- ***********************************************************************************HIDDEN********************************************************************************************************* -->

    </ul>

		<ul class="navbar-nav ml-auto">
		<?php if(!isset($_SESSION['USERID'])){ ?>
		<ul class="navbar-nav ml-auto"><!--created another ul so that it can be positioned in the right-->
			<li class ="nav-item"><a class="nav-link navcolor " href="<?php echo $APP->BASEURL ?>/admin" style="font-size: 15px;color: white;"><i class="fa fa-lg fa-user-circle"></i></a></li>
		<?php } ?>

		<?php if($id=='5'){ ?>
				<li class ="nav-item"><a class="nav-link navcolor " href="<?php echo $APP->BASEURL ?>/user/index.php?ID=16" style="font-size: 15px; font-weight:medium;"><i class="fa fa-lg fa-user-circle"></i></a></li>
				<li class ="nav-item"><a class="nav-link navcolor " href="<?php echo $APP->BASEURL ?>/index.php?ID=7" style="font-size: 15px; font-weight:medium;"><i style="color: white;" class="fas fa-sign-out-alt"></i></a></li>
			<?php } ?>

			<?php
			if (isset($_SESSION['USERID'])&& $id!='5') {
				?>
				<li class ="nav-item"><a class="nav-link navcolor " href="<?php echo $APP->BASEURL ?>/user/index.php?ID=16" style="font-size: 15px; font-weight:medium;"><i class="fa fa-lg fa-user-circle"></i></a></li>
				<li class ="nav-item"><a class="nav-link navcolor " href="<?php echo $APP->BASEURL ?>/admin" style="font-size: 15px; font-weight:medium;"><i class="fas fa-briefcase"></i></a></li>
				<li class ="nav-item"><a class="nav-link navcolor " href="<?php echo $APP->BASEURL ?>/index.php?ID=7" style="font-size: 15px; font-weight:medium;"><i class="fas fa-sign-out-alt"></i></a></li><?php
			}
			?>

		</ul>
  </div>
</div>
</nav>

<!-- <div class="clearfix mb-2">
used as a separator
</div> -->

      <!-- Nav Bar -->
