<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $obj=new artcls();
  $insert = $obj->insertarticle();

  ?>
  <div style="text-align: center;">
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
      <a href="<?php echo $APP->BASEURL ?>/admin/article/index.php?page=1" class="btn" style="font-size: 20px; font-weight: bold;"><img src="https://img.icons8.com/ios-glyphs/30/000000/circled-left-2.png">Back</a>
    </div>
<?php

  exit();

}

?>

<div class="container">
<br><br>
<h2 class="text-center">Create a new Article</h2>
<br>
<form class="" action="<?php echo $_SERVER['PHP_SELF'] ?>?ID=10" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="">Name</label>
    <input type="text" class="form-control" placeholder="Name!" name="name" value="">
  </div>

  <div class="form-group">
    <label for="">Article</label>
    <textarea name="article" class="form-control" rows="15" cols="80"></textarea>
  </div>

  <div class="form-group">
    <label for="">Category</label>
    <select class="form-control" name="category">
      <option value="" selected disabled>-Select category-</option>
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
  <div class="form-group">
    <label>Upload the Article Image</label>
    <input type="file" name="image" class="form-control-file">
  </div>
  <br>
  <div class="form-group">
    <label for="">Status</label>
    <select class="form-control" name="status">
      <option value="" selected disabled>-Select Option-</option>
      <option value="0">Draft</option>
      <option value="1">Ready for Submission!</option>
    </select>
    <br><br>
  <div class="" style="text-align:center">
    <button type="submit" class="btn btn-outline-dark btn-light">Submit</button>
  </div>

  </div>
</form>


</div>
