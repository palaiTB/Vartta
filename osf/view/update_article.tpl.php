<?php
$name = $article = "";
$name_err = $article_err ="";
$object=new viewarticle();
// Processing form data when form is submitted
if($_SERVER['REQUEST_METHOD'] === 'POST'){  // && !empty($_POST["id"]) was used previously but it showed error in wamp
    // Get hidden input value
    $value=$object->update();
    if($value===true)
    {
      ?>
      <br><br>
      <body style="text-align: center;">
      <div class="wrapper">
            <div class="container">
                  <div class="row">
                      <div class="col-md-12">
                          <div class="page-header">
                              <h2><i class="far fa-check-circle"></i>Article Updated Successfully</h2>
                            <?php
                            $editor=$object->fetchuser($_SESSION['USERID']);
                            $admin=$object->fetchuser(1);
                            if($editor['roleid']==4 && $_POST['status']==3)
                            {
                              // function sendSMS($mobile, $msg)
                              // {
                              //     $projectid = 'pid_ab097c7e_324e_43a7_ba5d_e4cd057884fd';  //Get the project id of specific project from developer portal
                              //     $authtoken = '201520fc_ab32_49be_b91a_07c78ff6b349';      //Get the authtoken of the above project from developer portal
                              //     $url = "https://api.vox-cpaas.com/sendsms";
                              //     $fields = array(
                              //         'projectid' => $projectid,
                              //         'authtoken' => $authtoken,
                              //         'to' => $mobile,  // add country code to number Ex: +919848012345
                              //         'body' => $msg,
                              //     );
                              //     $postvars = '';
                              //     foreach($fields as $key=>$value)
                              //     {
                              //         $postvars .= $key . "=" . urlencode($value) . "&";
                              //     }
                              //     $ch = curl_init();
                              //     curl_setopt($ch, CURLOPT_URL, $url);
                              //     curl_setopt($ch, CURLOPT_POST, 1);
                              //     curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
                              //     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                              //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                              //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                              //     $json = curl_exec($ch);
                              //     curl_close($ch);
                              //     $response = json_decode($json, true);
                              //     return $response;
                              // }
                              // $link="".$APP->BASEURL."/index.php?ID=14&articleid=".($_GET['articleid']);
                              // $message="New article published on AMS!\n \nTitle: ".($_POST['name'])." \nLink: ".$link;
                              // $resp = sendsms("+91".$admin['ph_number'], $message);
                              // print_r($resp);

                              }

                             ?>
                             <script>

                               setTimeout(function(){ //feature to take some time
                                     var targetUrl = '<?php echo $APP->BASEURL.'/admin/article/index.php?page=1'; ?>';
                                     // window.open(targetUrl, "self"); opens a new window
                                     window.location.href = targetUrl;  //redirects the window to required URL
                               }, 3000);

                             </script>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <br><br>
          <p class="text-muted"><img src="<?php echo $APP->BASEURL; ?>/pub/images/Ripple-1.1s-200px.gif" /> Please wait..</p>
        </body>
<?php
      exit();
    }

    else {
      ?>
      <div class="wrapper">
              <div class="container">
                  <div class="row">
                      <div class="col-md-12">
                          <div class="page-header">
                              <h2 style="text-align: center"><i class="far fa-times-circle"></i>Article couldn't be Updated</h2>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      <?php
    }
?>
<?php
  }
   else{
    // Check existence of id parameter before processing further

    $row=$object->article_read();
    $name=$row['name'];
    $article=$row['article'];
    $id=$row['id'];
}
?>

<body>
  <br><br>
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2 style="text-align: center">Update Article</h2>
                    </div>
                    <p style="font-weight: lighter;" class="text-muted">Please edit the Article and submit to update the record.</p>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo base64_decode($name) ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($_err)) ? 'has-error' : ''; ?>">
                            <label>Article</label>
                            <textarea name="article" class="form-control"><?php echo base64_decode($article); ?></textarea>
                            <span class="help-block"><?php echo $article_err;?></span>
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
                        <div class="form-group">
                          <label>Upload the Article Image</label>
                          <input type="file" name="image" class="form-control-file">
                        </div>
                        <div class="form-group">
                          <label for="">Status</label>
                          <select class="form-control" name="status">
                            <option value="" selected disabled>-Select Option-</option>
                            <?php $editor=$object->fetchuser($_SESSION['USERID']);
                            if($editor['roleid']==4)
                            {?>
                              <option value="2">In review</option>
                              <option value="3">Publish!!</option>
                        <?php    }
                            else{?>
                            <option value="0">Draft</option>
                            <option value="1">Ready for Submission!</option> <?php } ?>
                          </select>
                        </div>
                        <br>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="<?php echo $APP->BASEURL ?>/admin/article/index.php?page=1" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
