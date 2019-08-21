<!DOCTYPE html>
<html lang="en" dir="ltr">
  <div class="text-focus-in container-fluid">
    <br>
    <ul class="breadcrumb">
      <li><a style="color: #495057;" href="<?php echo $APP->BASEURL ?>">Home</a> <span class="divider">/</span></li>
      <li><a style="color: #495057;" href="<?php echo $APP->BASEURL ?>/admin/index.php?ID=8">Menu</a> <span class="divider">/</span></li>
      <li class="active">Articles</li>
    </ul>
    <div class="container-fluid">
      <div class="float-left">
        <h2>Articles</h2>
      </div>
      <?php if($USER->iRole=='1' || $USER->iRole=='3'){ ?>
      <div class="float-right">
        <a href="<?php echo $APP->BASEURL; ?>/admin/article/index.php?ID=10" class="btn"><img src="https://img.icons8.com/metro/26/000000/plus.png"> New Article</a>
      </div>
    <?php } ?>
      <div class="clearfix"></div>
      <hr>

      <div class="w-100" style="overflow: auto;"> <!-- For mobile screen the table can't fit hence the sideways scroll is required -->
        <?php
          $obj2= new viewarticle();
          $category_obj = new category();

          $user=$obj2->fetchuser($_SESSION['USERID']);
          //echo '<pre>'; print_r($article_array);echo '</pre>';
          // $row=$obj2->fetchuser($_SESSION['USERID']);
          // $role=$row['roleid'];
          echo "<table class='table table-hover'>";
            echo "<thead style='background-color: #9fcdff;'>";
              echo "<tr>";
                echo "<th scope='col'>#</th>";
                echo "<th scope='col'>Name</th>";
                if($_SESSION['USERID']==1)
                {
                  echo "<th scope='col'>Author</th>";
                }
                echo "<th scope='col'>Status</th>";
                echo "<th scope='col'>Category</th>";
                echo "<th scope='col'>Action</th>";
                echo "<th scope='col'>Date</th>";
              echo "</tr>";
            echo "</head>";
            echo "<tbody>";

            $total=$obj2->view(); //we want the total number of articles
            $totalArticles = count($total);
            $perpage=10;
            $numberofpages=ceil($totalArticles/$perpage);

            $offset=($_GET['page']*10)-10;
            $article_array=$obj2->view3($offset,10);

            $totalno=$totalArticles-(($_GET['page']-1)*10);  //we want the starting index of the top article in each page i.e used for indexing for pagination
            foreach($article_array as $key=>$value)
            {
              $category_array = $category_obj->fetch_category($value['category']);
              echo "<tr>";


                    echo "<td>" .($totalno--). "</td>";
                    echo "<td>" . base64_decode($value['name']) . "</td>";
                    if($_SESSION['USERID']==1)
                    {
                      $name = $obj2->fetchuser($value['userid']);
                      echo "<td><em>" .$name['username']. "</em></td>";
                    }
                    if($value['status']==0)
                    {$option="Draft";
                    echo "<td><span class='badge badge-warning'>" . $option . "</span></td>";}
                    else if($value['status']==1)
                    {$option="Submitted";
                    echo "<td><span class='badge badge-info'>" . $option . "</span></td>";}
                    else if($value['status']==2)
                    {$option="In Review";
                    echo "<td><span class='badge badge-secondary'>" . $option . "</span></td>";}
                    else if($value['status']==3)
                    {$option="Published!";
                    echo "<td><span class='badge badge-success'>" . $option . "</span></td>";}

                    echo "<td>" . $category_array['category'] . "</td>";

                    echo "<td>";
                    echo "<div class='btn-group' role='group' aria-label='Basic example'>";
                        echo '<a type="button" class="btn btn-sm btn-outline-secondary" href="'.$APP->BASEURL.'/admin/article/index.php?ID=11&articleid='.$value['id'].'"><i class="fa fa-eye"></i></a> ';

                        if($value['status']<=1 || $user['roleid']==4 ) //this section isnt allowed for writer if his article is in review or published. However it is visible to editor and admin(previously)
                        {
                        echo '<a type="button" class="btn btn-sm btn-outline-secondary" href="'.$APP->BASEURL.'/admin/article/index.php?ID=12&articleid='.$value['id'].'"><i class="fa fa-tools"></i></a>  ';
                        {?> <a type="button" class="btn btn-sm btn-outline-secondary" onClick="return confirm('Are you sure you want to Delete??')" href="<?php echo $APP->BASEURL.'/admin/article/index.php?ID=13&articleid='.$value['id'] ?>"><i class="fa fa-trash-alt"></i></a> <?php  }?>
                         <?php
                       }
                    echo "</div>";
                    echo "</td>";
                    echo "<td>" .date("d/m/y", $value['createdat']). "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
          echo "</table>";

         ?>
      </div>

       <br>
       <nav>
         <ul class="pagination justify-content-center">
           <?php if($_GET['page']==1){ ?>
           <li class="page-item disabled">
             <a class="page-link" href="#" tabindex="-1">Previous</a>
           </li>
         <?php } else{ ?>
                <a class="page-link" href="<?php echo $APP->BASEURL ?>/admin/article/index.php?page=<?php echo ($_GET['page']-1) ?> ">Previous</a>
         <?php } ?>

           <?php
           for ($i=1; $i <=$numberofpages ; $i++) {
             if($_GET['page']==$i)
             {
               echo '<li class="page-item"><a style="color: white; background-color: #0e68b0; font-weight: bold" class="page-link" href="'.$APP->BASEURL.'/admin/article/index.php?page='.($i).'">'. $i . '</a></li>';
              continue;
             }

             echo '<li class="page-item"><a class="page-link" href="'.$APP->BASEURL.'/admin/article/index.php?page='.($i).'">'. $i . '</a></li>';

           }

            ?>
            <?php if($_GET['page']==$numberofpages){ ?>
              <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1">Next</a>
              </li>
            <?php } else{ ?>
             <a class="page-link" href="<?php echo $APP->BASEURL ?>/admin/article/index.php?page=<?php echo ($_GET['page']+1) ?> ">Next</a>
           <?php } ?>
         </ul>
       </nav>
    </div>

  </div>
</html>
