<?php

$obj=new viewarticle();
$value=$obj->delete();

if($value===true)
{
 ?>

 <body style="text-align: center;">
 <div class="wrapper">
       <div class="container-fluid">
             <div class="row">
                 <div class="col-md-12">
                     <div class="page-header">
                       <div class="clearfix">

                       </div>
                         <h2><i class="far fa-check-circle"></i>Article Deleted Successfully</h2>

                     </div>
                 </div>
             </div>
         </div>
     </div>
     <br><br>
     <a href="<?php echo $_SERVER['HTTP_REFERER'] ?>" class="btn" style="font-size: 20px; font-weight: bold;">Back</a>
   </body>

<?php
}
else {
  ?>
  <div class="wrapper">
          <div class="container-fluid">
              <div class="row">
                  <div class="col-md-12">
                      <div class="page-header">
                          <h2 style="text-align: center"><i class="far fa-times-circle"></i>Article couldn't be deleted</h2>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <?php
}
 ?>
