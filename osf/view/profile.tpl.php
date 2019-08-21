<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $obj=new artcls();
  $insert = $obj->setpreference($_SESSION['USERID']);
  ?>

  <div style="text-align: center;" class="container">
  <div class="wrapper">
        <div class="container-fluid">
              <div class="row">
                  <div class="col-md-12">
                      <div class="page-header">

                        <?php
                        if ($insert['status'] == true) {
                          ?>
                          <div class="alert alert-success">
                            <?php echo $insert['message']  ?>
                          </div>
                          <?php
                        } else {
                          ?>
                          <div class="alert alert-error">
                            <?php echo $insert['detailed_message']  ?>
                          </div>
                          <?php
                        }
                        ?>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <br><br>
      <a href="<?php echo $APP->BASEURL ?>" class="btn" style="font-size: 20px; font-weight: bold;"><img src="https://img.icons8.com/android/24/000000/circled-left-2.png">Home</a>
    </div>
  <?php

  exit();

  }

  ?>
  <br><br>
<div class="text-focus-in container">
  <h4 class="text-center">Bookmarked Articles!</h4>
  <br>
  <table class='table table-hover'>
    <thead>
      <tr>
        <th scope='col'>#</th>
        <th scope='col'>Article</th>
        <th scope='col'>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $book=new viewarticle();
      $row=$book->fetchBookmark($_SESSION['USERID']);
      if($row[0]=="")
      {
        echo "<tr>";
        echo "<td class='text-muted'>No Bookmarks</td>";
        echo "</tr>";
      }
      else {

      for ($i=0; $i <sizeof($row) ; $i++)
      {
        echo "<tr class='book-".$i."'>"; //Used to remove the row when bookmark is removed
              echo "<td>" .($i+1). "</td>";
              //echo "<td>" .($value['articleid']) . "</td>";
              $query="SELECT * FROM app_article WHERE id='".$row[$i]."' ";
              $res=$DB->query($query);
              $data = $res->fetch(PDO::FETCH_ASSOC);
              echo "<td>" . base64_decode($data['name']) . "</td>";
              echo "<td>";
              echo '<a href="'.$APP->BASEURL.'/index.php?ID=14&articleid='.$row[$i].'"><img src="https://img.icons8.com/material-outlined/24/000000/visible.png" > </a>';?>
              <a onclick="unmark('<?php echo $i; ?>')" ><img src="https://img.icons8.com/metro/26/000000/unpin.png">  </a>
              <?php
              echo "</td>";
          echo "</tr>";
      }
    }
       ?>
    </tbody>
  </table>
  <br><br><br>
  <h4 class="text-center">Update your Preferences!</h4>
    <br>
    <form class="" action="<?php echo $_SERVER['PHP_SELF'] ?>?ID=16" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="">Preferences</label>
        <select multiple class="form-control" name="preference[]">
          <option value="" selected disabled>-Select preference-</option>
          <?php
            $ctgry=new category();
            $result=$ctgry->view();
            foreach($result as $key=>$value)
            {
              echo '<option value="'.$value['id'].'">'.
              $value['category']
              .'</option>';
            }
           ?>
        </select>
      </div>
      <br>
      <br>
      <div class="form-group">
      <div class="" style="text-align:center">
        <button type="submit" class="btn"><img src="https://img.icons8.com/ios/50/000000/verified-account-filled.png"></button>
      </div>

      </div>
    </form>
</div>

<script type="text/javascript">
  function unmark(articleindex)
  {
    $.post( "<?php echo $APP->BASEURL; ?>/user/index.php?ID=16", {   //remember this method always
      articleindex: articleindex,
      unmark: '1'
    }, function( data ) {
      var response = JSON.parse(data);
      $(".book-"+articleindex).remove();
      alert(response.detailed_message);
    });
  }
</script>
