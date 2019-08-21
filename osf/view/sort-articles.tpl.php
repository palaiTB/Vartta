<?php
$object_main= new viewarticle();	$category_obj = new category();

$result=$object_main->view2($limit, $offset);

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
              }

              ?>

              <div class="card mt-5 rounded-5  slit-in-vertical" style="height: 31rem; width: 100%; overflow: hidden; border-radius: 10px;">
                <div class="card-body " style="background-image: linear-gradient(to bottom, rgba(255, 255, 255, 0) 0%,  rgba(0, 0, 0, 1) 100%), url(<?php echo $imageFilePath; ?>); background-position: center; background-size: cover; padding-top: 14rem;">
                    <?php
                    $user=$object_main->fetchuser($value['userid']);
                    $uname=$user['username'];
                    echo "<a style='color: white' class='stretched-link' href='".$APP->BASEURL."/index.php?ID=14&articleid=".$value['id']."'><h3 style='font-weight: bold;color: white;'> " . base64_decode($value['name']) . "</h3></a>";
                    echo "<h6 style='color: white'>By: ".$uname."</h6>";
                    echo "<p style='font-size: 12px; color: white;'>Created at: ".date("d F Y, H:i A", $value['createdat'])."</p>";

                    //echo "<p>" . base64_decode($value['article']) . "</p>";
                     ?>
                </div>
              </div>
            </div><?php

            }

         ?>
