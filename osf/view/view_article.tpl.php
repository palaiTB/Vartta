<?php
$obj3=new viewarticle();
$view=$obj3->article_read();
$name=$view['name'];
$article=$view['article'];
$image=$view['image'];
$id=$view['category'];

$test=new category();
$ctgry=$test->fetch_category($id);
$category=$ctgry['category'];


$articleid=$_GET['articleid'];
$uid=$_SESSION['USERID'];


$user=$obj3->fetchuser($view['userid']);
$uname=$user['username'];
?>
<div class="clearfix mb-3">

</div>
<div class="">
  <br><br>

    <div class="text-focus-in container">
      <ul class="breadcrumb text-focus-in" style="width: 20%;"> <!-- To have a link to the category section. Its easier to navigate-->
        <li><a href="<?php echo $APP->BASEURL ?>/index.php?category=<?php echo strtolower($category) ?>"><?php echo $category ?></a></li>
      </ul>
        <div class="text-center">

            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1><?php echo base64_decode($name); ?></h1>
                        <hr>
                        <?php echo "Published by: ".$uname; ?><br>
                        <?php echo "Published At: ".date("d F Y, H:i A", $view['createdat']); ?>
                        <hr>

                        <div class="row">
                          <div class="col-lg-4 text-right">
                            <a class="a2a_dd" href="https://www.addtoany.com/share"><img src="https://img.icons8.com/windows/32/000000/share.png"></a>
                          </div>
                          <div class="col-lg-4 text-center">
                            <a data-toggle="tooltip" onclick="myFunction()"><img src="https://img.icons8.com/ios-glyphs/30/000000/send-to-printer.png"></a>
                          </div>
                          <?php if(isset($_SESSION['USERID'])){ ?>
                          <div class="col-lg-4 text-left">
                            <a onclick="book('<?php echo $articleid; ?>', '<?php echo $uid; ?>')" class='stretched-link'><img src="https://img.icons8.com/material/24/000000/mark-as-favorite.png"></a>
                          </div>
                        </div>
                      <?php } ?>
                    </div>
                    <div class="form-group">
                        <img class="scale-down" style="width: 777px;height:535px"  src="<?php echo $APP->BASEURL ?>/pub/uploads/<?php echo $image ?>" alt="">

                        <div style="font-weight: medium;" class="text-left"><?php echo base64_decode($article); ?></div>
                    </div>

                </div>
            </div>
            <br>
            <div class="col-md-12"><div class="astrodivider"><div class="astrodividermask"></div><span><i>&#10038;</i></span></div>
              <h5 style="font-family: 'Monoton', cursive;">Comments</h5>
              <div class="comment text-left">
              <?php
              $sql1="SELECT * FROM app_comment WHERE article='".$_GET['articleid']."' ";
              $result=$DB->query($sql1);
              $row=$result->fetchAll(PDO::FETCH_ASSOC);
              echo $content = '<div class="row w-100 mx-auto">';
              foreach ($row as $key => $value) {
                  $userData = $obj3->fetchuser($value['userid']);
                  echo '
                    <div class="card mt-4 col-12" style="background-color: white;">
                      <div class=" float-left " style="font-weight: bold">
                      '.$userData['firstname'].' '.$userData['lastname'].':'.'<br />
                        <div class="text-muted" style="font-weight: normal">
                          '.$value['comment'].'
                        </div>
                      </div>
                        <br>
                    </div>

                  ';
                  // echo $userData['firstname'].' '.$userData['lastname'];
                  // echo '<br>';
                  // echo $value['comment'];
                  // echo '<hr>';
              }
               ?>


               </div>
               </div>
              <br>
              <!-- <form id="usercomment">
                <?php if(isset($_SESSION['USERID'])){ ?>
                <div class="form-group">
                  <input type="hidden" name="articl" value="<?php echo $_GET['articleid'] ?>">
                  <input type="text" name="comment" class="form-control" placeholder="Comment here..">
                </div>
                <br>
                <button type="submit" id="button" class="btn btn-outline-dark btn-light">Submit</button>
              <?php } else{?>
              <br>
              <a href="<?php echo $APP->BASEURL ?>/admin" class="btn btn-dark" style="font-weight: bold">NOTE:  You need to login first in order to comment</a>
            <?php } ?>
              </form> -->

              <div id="disqus_thread"></div>
<script>

/**
*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
/*
var disqus_config = function () {
this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
};
*/
(function() { // DON'T EDIT BELOW THIS LINE
var d = document, s = d.createElement('script');
s.src = 'https://vartta.disqus.com/embed.js';
s.setAttribute('data-timestamp', +new Date());
(d.head || d.body).appendChild(s);
})();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>

              <br><br>
              <a href="<?php echo $_SERVER['HTTP_REFERER'] ?>" class="btn" style="color: black; font-size: 20px;"><img src="https://img.icons8.com/ios-glyphs/30/000000/circled-left-2.png">Back</a></p>
              <!-- $_SERVER[HTTP_REFERER] is used to return to the page that sent the request -->
            </div>
        </div>
    </div>
    </div>

    <script async src="https://static.addtoany.com/menu/page.js"></script>
    <script type="text/javascript">
    function myFunction()
    {
      window.print();
    }

      function book(articleid, userid)
      {

        $.post( "<?php echo $APP->BASEURL; ?>/index.php?ID=14", {   //remember this method always
          articleid: articleid,
          userid: userid
        }, function( data ) {
          var response = JSON.parse(data);
          alert(response.detailed_message);
        });
      }

      $("#usercomment").submit(function(event){   //this is the way to submit forms through ajax
        event.preventDefault();                   //prevents the page from reloading when a form is submitted
        $.post('<?php echo $APP->BASEURL ?>/index.php?ID=14',$(this).serialize(),function(data){   //appends all inputs of form and send it to ajax & this keyword is used to refer to #usercomment form field
            var res= JSON.parse(data);
            alert(res.message);
            $(".comment").html(res.comments);
        });
      });


    </script>
