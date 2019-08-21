<?php

include "simple_html_dom.php";

$occ="occnews.xml";
$tech = "techreview.xml";
$beeb = 'beeb.xml';
$xml1=simplexml_load_file($occ) or die("Can't connect to URL"); //loads the xml file and returns an object
$xml2=simplexml_load_file($tech) or die("Can't connect to URL");

?>

<br><br>
<div class="container">

<hr>
<br>
<div class="row">
  <div class="col-lg-12">
    <div class="card border-info mt-5  text-center slit-in-vertical" style=" width: 100%; overflow: hidden;">
      <div class="card-header" style="font-weight: bold; font-size: 2rem;">
        Agency News
      </div>
      <div class="card-body text-left" >
        <br>

       <div class="row">

       <?php
       $i=0;
       $xml3 = simplexml_load_file($beeb) or die("Can't connect to URL");
        foreach ($xml3->channel->item as $key => $value){
          sleep(1);
          if($i==10)
          {
            break;
          }
         $content= ($i+1).". <a class='stretched-link' style='color: #0e68b0' href='$value->link'>".$value->title."</a>";
         $obj= new viewarticle();
         $check= $obj->viewscrapeimg($value->title);

         if($value->title == $check['name'])
         { $path=$APP->BASEURL."/pub/scrape_images/".$check['photoid'];
           $image = '<img src="'.$path.'" class="rounded img-thumbnail" height="150" width="150" alt="">';
           // die($value->category);
         }

         else{
           if($value->category!='News')
           {
             continue;
           }
          $url="";
         $html2 = file_get_html(''.$value->link.'');
         $body = $html2->find('div[class="td-post-content"]',0);
         $body->find('img[class="news-featured-image"]',0)->class='d-block';
         $url = $body->find('img[class="news-featured-image"]',0)->src;

         $filename = md5(time()).'-'.date("Ymd").'.jpg';
         $img = 'pub/scrape_images/'.$filename;
         file_put_contents($img, file_get_contents($url));
         $res = $obj->scrapeimg($value->title, $filename);

         $check= $obj->viewscrapeimg($value->title);

         $image = '<img src="'.$source->href.'" class="rounded img-thumbnail" height="150" width="150" alt="">';
       }
         ?>
         <div class="col-md-12 mt-2">
           <div class="card border-info shadow-sm">
             <div class="card-body">
               <div class="float-left">
                 <?php echo $content; ?>
               </div>
               <div class="float-right">
                  <?php echo ($image); ?>
               </div>
               <div class="clearfix">

               </div>
             </div>
           </div>
         </div>
       <?php
         $i++;
       }
        ?>
      </div>


      <div class="row">

      <?php
       foreach ($xml1->channel->item as $key => $value){
          //channel and item are the attributes of the object
          if($i==20)
          {
            break;
          }

          $content = ($i+1).". <a class='stretched-link' style='color: #0e68b0' href='$value->link'>".$value->title."</a>";
          $obj= new viewarticle();
          $check= $obj->viewscrapeimg($value->title);

          if($value->title == $check['name'])
          { $path=$APP->BASEURL."/pub/scrape_images/".$check['photoid'];
            $image = '<img src="'.$path.'" class="rounded img-thumbnail" height="150" width="150" alt="">';
          }
          else{
          $html = file_get_html(''.$value->link.'');
          $image=$html->find('div[class="td-post-featured-image"]',0);
          $source=$image->find('a',0);
          $url = $source->href;
          $filename = md5(time()).'-'.date("Ymd").'.jpg';
          $img = 'pub/scrape_images/'.$filename;
          file_put_contents($img, file_get_contents($url));

          $res = $obj->scrapeimg($value->title, $filename);

          $check= $obj->viewscrapeimg($value->title);

          $image = '<img src="'.$source->href.'" class="rounded img-thumbnail" height="150" width="150" alt="">';
        }
         ?>
         <div class="col-md-12 mt-2">
           <div class="card border-primary shadow-sm">
             <div class="card-body">
               <div class="float-left">
                 <?php echo $content; ?>
               </div>
               <div class="float-right">
                  <?php echo $image; ?>
               </div>
               <div class="clearfix">

               </div>
             </div>
           </div>
         </div>
       <?php
          $i++;
        } ?>

      </div>


      </div>
    </div>
  </div>
</div>
</div>
