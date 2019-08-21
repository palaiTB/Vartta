<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $obj=new artcls();
  $insert = $obj->newuser();

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
                        <script>

                          setTimeout(function(){ //feature to take some time
                                var targetUrl = '<?php echo $APP->BASEURL.'/login'; ?>';
                                // window.open(targetUrl, "self"); opens a new window
                                window.location.href = targetUrl;  //redirects the window to required URL
                          }, 3000);

                        </script>
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

    <p class="text-muted"><img src="<?php echo $APP->BASEURL; ?>/pub/images/Ripple-1.1s-200px.gif" /> Please wait..</p>
    <!-- <a href="<?php echo $APP->BASEURL ?>/login" class="btn" style="font-size: 20px; font-weight: bold;"><img src="https://img.icons8.com/material-sharp/24/000000/home-page.png">Home</a> -->
  </div>
<?php

exit();

}

?>
<!-- <div class="container">
  <h1>Registration <img src="https://img.icons8.com/android/48/000000/add-user-male.png"></h1>
  <form class="" action="<?php echo $_SERVER['PHP_SELF'] ?>?ID=15" method="post" enctype="multipart/form-data">

    <a class="float-right" href="<?php echo $APP->BASEURL ?>/admin">Already Registered? Click here!</a><br>
    <div class="form-group">
      <label for="">First Name</label>
      <input type="text" class="form-control" placeholder="First Name!" name="fname" value="">
    </div>
    <div class="form-group">
      <label for="">Last Name</label>
      <input type="text" class="form-control" placeholder="Last Name!" name="lname" value="">
    </div>
    <div class="form-group">
      <label for="">Username</label>
      <input type="text" class="form-control" placeholder="Username" name="uname" value="">
    </div>
    <div class="form-group">
      <label for="">Phone Number</label>
      <input type="text" class="form-control" placeholder="Number" name="number" value="">
    </div>
    <div class="form-group">
      <label for="">Email</label>
      <input type="text" class="form-control" placeholder="xyz@mail.com" name="email" value="">
    </div>
    <div class="form-group">
      <label for="">Password</label>
      <input type="password" class="form-control" placeholder="Strong password!!" name="password" value="">
    </div>
    <br>
    <div class="" style="text-align:center">
      <button type="submit" class="btn btn-light btn-outline-dark">Submit</button>
    </div>
</div> -->
<!--    *************************************************************************-->
<div class="container" role="main">
    <div class="row">
        <div class="col-sm-6 col-md-6 col-md-offset-3">
            <div class="account-wall text-center " style="padding: 3rem;margin-top: 0;">
            <h1 class="text-center"><img src="https://img.icons8.com/android/48/000000/add-user-male.png"></h1>
            <h4 style="font-weight: bold;">Register</h4>
    				<hr/>
            <form class="" action="<?php echo $_SERVER['PHP_SELF'] ?>?ID=15" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label for="">First Name</label>
                <input type="text" class="form-control" placeholder="First Name!" name="fname" value="">
              </div>
              <div class="form-group">
                <label for="">Last Name</label>
                <input type="text" class="form-control" placeholder="Last Name!" name="lname" value="">
              </div>
              <div class="form-group">
                <label for="">Username</label>
                <input type="text" class="form-control" placeholder="Username" name="uname" value="" required autofocus>
              </div>
              <div class="form-group">
                <label for="">Phone Number</label>
                <input type="text" class="form-control" placeholder="Number" name="number" value="" required autofocus>
              </div>
              <div class="form-group">
                <label for="">Email</label>
                <input type="text" class="form-control" placeholder="xyz@mail.com" name="email" value="" required autofocus>
              </div>
              <div class="form-group">
                <label for="">Password</label>
                <input type="password" class="form-control" placeholder="Strong password!!" name="password" value="" required autofocus>
              </div>
              <br>
              <div class="" style="text-align:center">
                <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
              </div>
            </form>
            <br>
            <a class="float-right" href="<?php echo $APP->BASEURL ?>/admin">Already Registered? Click here!</a>
            </div>
            <!--<h4 class="text-center osf-top-space"><a href="#">Create an account</a></h4>-->
        </div>
    </div>
</div>
