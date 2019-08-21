<?php
    $object_main= new viewarticle();
    $category_obj = new category();
    $user=$object_main->fetchuser($_SESSION['USERID']);

 if (!isset($_GET['category'])) {?>

<div class="container-fluid border-bottom" style="background-image:url('<?php echo $APP->BASEURL ?>/pub/images/ross-sokolovski-UAFXj9dRpwo-unsplash.jpg');background-size: cover;" id="animate-area">
<div class="container">
	<div class="row border-bottom-1 border-info">
		<div class="col-12 col-md-12 mt-4 pt-5 mb-5 pb-5">
<?php
if (isset($_SESSION['USERID'])) {
     $id=$_SESSION['USERID'];
     $use=$object_main->fetchuser($id); ?>
	<h1 style="color: white;font-family: 'Cookie', cursive;font-size: 5rem;" class="text-focus-in">Welcome <?php echo " ".$use['username']."!"; ?> </h1>
	<br>
<?php
 } else {?>

	<h1 style="color: white;font-family: 'Cookie', cursive;font-size: 5rem;">Vartta</h1><br>
<?php } ?>
		<div class="wrapper" style="text-align: center;">
			<h2 style="color: white" class="text-focus-in">Personalized news feed <img src="https://img.icons8.com/bubbles/50/000000/news.png"></h2>
		</div>
		<p class="lead text-center mt-0 mb-5 text-white">The one stop portal for all the Latest news! Read. Comment. Bookmark. Set your preferences. Relax and enjoy. </p>

		<?php if (!isset($_SESSION['USERID'])) { ?>
		<p class="text-center mt-4 mb-3"><a href="<?php echo $APP->BASEURL ?>/index.php?ID=15"><button type="button" class="btn btn-outline-light"><i class="fa fa-sign-in-alt"></i> Signup Free</button></a>
			<a href="<?php echo $APP->BASEURL ?>/admin"><button type="button" class="btn btn-light btn-outline-dark"><i class="fas fa-key"></i> Login</button></a>
    <a href="<?php echo $APP->BASEURL; ?>/index.php?ID=17"><button type="button" class="btn btn-outline-light"><i class="fas fa-rss"></i> Agencies</button></a></p>
		<?php } else { ?>
			<p class="text-center mt-4 mb-3"><a href="<?php echo $APP->BASEURL ?>/user/index.php?ID=16"><button type="button" class="btn btn-outline-light"><i class="fa fa-lg fa-user-circle"></i> Profile</button></a>

				<?php if ($user['roleid']!=5) { ?>
				<a href="<?php echo $APP->BASEURL ?>/admin"><button type="button" class="btn btn-light btn-outline-dark"><i class="fas fa-briefcase"></i> Panel</button></a></p>
			<?php } ?>
			<?php } ?>

	</div>
	</div>
	</div>
</div>
		<?php }
    else{ ?>

      <br>
			<h2 class="text-focus-in" style="text-align: center; font-weight: bold;text-transform: capitalize; text-decoration: underline;"><?php echo $_GET['category']; ?></h2>
    <?php } ?>
      <div class="container text-center">

				<h3 style="visibility: hidden;">News Cards</h3> <!-- Some error wrt scrolling was coming -->
				<div class="row" id="all-articles">
			<?php
            if (isset($_GET['category']) && !empty($_GET['category'])) {
                $result=$object_main->view('category', $_GET['category']);
            } else {
                $result=$object_main->view2($limit, $offset);
            }

            $result_count = count($result);

            foreach ($result as $key => $value) {
                ?>
						<div class="col-lg-6">
							<?php

                $category_array = $category_obj->fetch_category($value['category']);

                $image = '';
                $imageFilePath = $APP->BASEURL."/pub/uploads/".$value['image'];
                if (!empty($value['image']) && file_exists("pub/uploads/".$value['image'])) {
                    $image = "<img class='view-article-image rounded' src=".$imageFilePath." />";
                } ?>

		<div class="card mt-5 slit-in-vertical" style="height: 31rem; width: 100%; overflow: hidden; border-radius: 10px;">
			<div class="card-body " style="background-image: linear-gradient(to bottom, rgba(255, 255, 255, 0) 0%,  rgba(0, 0, 0, 1) 100%), url(<?php echo $imageFilePath; ?>); background-position: center; background-size: cover; padding-top: 14rem;">
					<?php

                $user=$object_main->fetchuser($value['userid']);
                $uname=$user['username'];
                $encode=base64_decode($value['name']);
                echo "<a style='color: white; margin-top: 50%;' class='stretched-link' href='".$APP->BASEURL."/index.php?ID=14&articleid=".$value['id']."'><h3 style='font-weight: bold; color: white;'> " . $encode . "</h3></a>";
                echo "<h6 style='color: white;'>By: ".$uname."</h6>";
                echo "<p style='font-size: 12px; color: white;'>Created at: ".date("d F Y, H:i A", $value['createdat'])."</p>";

                //echo "<p>" . base64_decode($value['article']) . "</p>";
                             ?>
					</div>
				</div>
			</div>
			<?php
            }

             ?>
			</div>
			<div id="loader" class="d-none text-center">
				<br>
			 <img src="<?php echo $APP->BASEURL; ?>/pub/images/Ripple-1.1s-200px.gif" />
		 </div>
		</div>


			<button type="button"  class="d-none" id="load-articles"></button> <!--this button is used to prevent multiple Ajax requests.-->

		<?php if (!isset($_GET['category'])) { ?>  <!-- for category in URL, we don't require scrolling as it is buggy-->
			<script>
			var limit = 4;
			var offset = 0;
			$(function () {
					var $win = $(window);
					$win.scroll(function () {
 							if (parseInt($win.height()) + parseInt($win.scrollTop()) == (parseInt($(document).height()))-1) {
									$("#load-articles").click(); //this is used when the bottom scroll is done
							}
					});
			});

			$(document).on("click", "#load-articles", function(event){ //when the button is clicked then only the Ajax request is executed and hence multiple Ajax requests are prevented
				$("#loader").removeClass("d-none");
					$.post('<?php echo $APP->BASEURL ?>/index.php?ID=6',{limit: limit, offset: offset},function(data){
							$("#all-articles").append(data);
							$("#loader").attr("class", "d-none");
							offset = offset+4;
					});
			});
			</script>
		<?php } ?>
