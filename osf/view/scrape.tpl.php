

<?php
$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
include "simple_html_dom.php";

 if ($_GET['scrape']=='phl')
{
    echo "<div class='container'>";
    $html = file_get_html('https://10times.com/philadelphia-us');

    $title= $html->find('h1', 0)->plaintext;
    echo "<br />";
    echo "<h4 style='text-align:center;'>".$title."</h4>";
    echo "<br />";

    $list= $html->find('tbody[id="content"]', 0);
    $list_array= $list->find('tr');
    // echo count($list_array);?>

    <?php
    for ($i=0;$i<sizeof($list_array);$i++) {
        $details= $list_array[$i];
        if (count($details->find('td'))==1) {
            continue;
        } else {?>
    <div class="card mt-3 slit-in-vertical" style=" width: 100%; overflow: hidden;">
      <div class="card-body">
          <?php
          echo $details->find('td', 1)->find('h2', 0);
          echo "Date and Time:".$details->find('td', 0)->plaintext;
          echo "<br />";
          echo "Event details:".$details->find('td', 1)->plaintext;
          echo "<p class='text-muted'>".$details->find('td', 2)->plaintext."</p>";
           ?>
      </div>
    </div>

    <?php }
    }
    echo "</div>";
}
else if ($_GET['scrape']=='occ')
{
    $html = file_get_html('https://www.occ.gov/news-issuances/index-news-issuances.html');
    $title= $html->find('h1', 0)->plaintext;
    echo "<br />";
    echo "<div class='container'>";

     if($_GET['type']=='news')
     { echo "<br />";

       echo "<h3 class='text-muted'>".$html->find('caption', 0)."</h3>";
       echo "<hr />";
       for ($i=0; $i <5 ; $i++) {
         $col="collapse".$i;
         ?>
          <div class="accordion" id="accordionExample">
           <div class="card">
              <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                  <button style='color: black' class="btn btn-link collapsed text-left" type="button" data-toggle="collapse" data-target="#<?php echo $col; ?>" aria-expanded="true" aria-controls="collapseOne">
                    <?php echo "<h5>".$html->find('table[id="5-most-recent-news-releases"]', 0)->find('tbody', 0)->find('tr', $i)->find('td[class="tcontent"]', 0)->plaintext."</h5>";
                    echo "<p class='text-muted'>Date: ".$html->find('table[id="5-most-recent-news-releases"]', 0)->find('tbody', 0)->find('tr', $i)->find('td[class="tdate"]', 0)."</p>";
                    echo "<p class='text-muted'>Identifier: ".$html->find('table[id="5-most-recent-news-releases"]', 0)->find('tbody', 0)->find('tr', $i)->find('td[class="tidentifier"]', 0)."</p>";
                     ?>
                  </button>
                </h2>
              </div>
              <div id="<?php echo $col; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                  <?php
                  $code = $html->find('table[id="5-most-recent-news-releases"]', 0)->find('tbody', 0)->find('tr', $i)->find('td[class="tidentifier"]', 0)->plaintext;
                  $code = trim(str_replace(',',"",$code)," ");
                  $link = $html->find('table[id="5-most-recent-news-releases"]', 0)->find('tbody', 0)->find('tr', $i)->find('td[class="tcontent"]', 0)->find('a',0)->href;
                  $link="https://www.occ.gov".$link;
                  $data = file_get_html($link);
                  $release=$data->find('div[id="newsRelease"]',0);
                  $date = $html->find('table[id="5-most-recent-news-releases"]', 0)->find('tbody', 0)->find('tr', $i)->find('td[class="tdate"]', 0)->plaintext;
                  $date = substr($date,0,10);
                  $date=str_replace("/", " ",$date);
                  $explodeDate = explode(' ', $date);
                  $datetime = date("Y-m-d H:i:s", strtotime(date($explodeDate[2].'-'.$explodeDate[0].'-'.$explodeDate[1]." 00:00:00")));

                  $title=$release->find('div[class="div-nr-title"]',0)->find('h2',0)->plaintext;
                  $test="SELECT * FROM app_ret WHERE title LIKE '".base64_encode(serialize($title))."' AND code = '".$code."' ORDER BY id DESC ";
                  $check=$DB->query($test);
                  $rows=$check->rowCount();
                  $body=$release->find('div',5);

                  if($rows==0)
                  {
                  echo "<p style='font-weight: bold'>".$title."</p>";

                  echo $datetime."<br />";
                  echo "<hr />";

                  $r=0;
                  while($body->find('ul',$r))
                  { $ar=0;
                    while($body->find('ul',$r)->find('li',$ar)){
                    $pt=$body->find('ul',$r)->find('li',$ar)->plaintext;
                    if(strpos($pt, "(PDF)")!==false)
                    {
                      $ref = $body->find('ul',$r)->find('li',$ar)->find('a',0)->href;
                      $body->find('ul',$r)->find('li',$ar)->find('a',0)->href='https://www.occ.gov'.$ref;
                    }
                    $ar++;
                  }
                    $r++;
                  }


                  $r=0;

                  while($body->find('a',$r))
                  {
                       $ref = $body->find('a',$r)->href;
                       if(strpos($ref,"https")!==false || strpos($ref,"http")!==false)
                       {

                       }
                       else{
                       $body->find('a',$r)->href='https://www.occ.gov'.$ref;}
                     $r++;
                   }


                  $body=serialize($body);
                  $body = base64_encode($body);
                  $sql="INSERT INTO app_ret (agency ,category , title, code ,releasedate ,content, url) VALUES ('1', 'News Releases','".base64_encode(serialize($title))."', '".$code."' ,'".$datetime."','".$body."','".$link."')";
                  $DB->exec($sql);
                  $sql2="SELECT * FROM app_ret WHERE title ='".$title."' AND agency LIKE '1' ORDER BY id DESC";
                  $res=$DB->query($sql2);
                  $row=$res->fetch(PDO::FETCH_ASSOC);

                  $date1=base64_decode($row['content']);
                  echo unserialize($date1);

                  }
                  else {

                    echo "<br />";
                    $row=$check->fetch(PDO::FETCH_ASSOC);
                    $date1=$row['content'];
                    $date1=base64_decode($date1);
                    echo unserialize($date1);
                    echo "<hr />";
                    echo "URL: <a href='".$row['url']."' >".$row['url']."</a>";
                  }
                  ?>
                </div>
              </div>
              </div>
            </div>
           <?php
           echo "<br />";
       }
       echo "<div class='text-center'>";
       echo "<a class='btn' href='". $_SERVER['HTTP_REFERER']."'><img src='https://img.icons8.com/ios-glyphs/30/000000/circled-left-2.png'>Back</a>";
       echo "</div>";
     }

     else if($_GET['type']=='bulletins')
     { echo "<br />";
       echo "<h3 class='text-muted'>".$html->find('caption', 1)."</h3>";
       echo "<hr />";

       for ($i=0; $i <5 ; $i++) {
         $col="collapse".$i;
         ?>
          <div class="accordion" id="accordionExample">
           <div class="card">
              <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                  <button style='color: black' class="btn btn-link collapsed text-left" type="button" data-toggle="collapse" data-target="#<?php echo $col; ?>" aria-expanded="true" aria-controls="collapseOne">
                    <?php echo "<h5>".$html->find('table[id="5_Most_Recent_Bulletins"]', 0)->find('tbody', 0)->find('tr', $i)->find('td[class="tcontent"]', 0)->plaintext."</h5>";
                    echo "<p class='text-muted'>Date: ".$html->find('table[id="5_Most_Recent_Bulletins"]', 0)->find('tbody', 0)->find('tr', $i)->find('td[class="tdate"]', 0)."</p>";
                    echo "<p class='text-muted'>Identifier: ".$html->find('table[id="5_Most_Recent_Bulletins"]', 0)->find('tbody', 0)->find('tr', $i)->find('td[class="tidentifier"]', 0)."</p>";
                     ?>
                  </button>
                </h2>
              </div>
              <div id="<?php echo $col; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                  <?php
                  $code = $html->find('table[id="5_Most_Recent_Bulletins"]', 0)->find('tbody', 0)->find('tr', $i)->find('td[class="tidentifier"]', 0)->plaintext;
                  $code = trim(str_replace(',',"",$code)," ");
                  $link = $html->find('table[id="5_Most_Recent_Bulletins"]', 0)->find('tbody', 0)->find('tr', $i)->find('td[class="tcontent"]', 0)->find('a',0)->href;
                  $link="https://www.occ.gov".$link;
                  $data = file_get_html($link);
                  $body=$data->find('div[id="Issuance"]',0);

                  $title=$html->find('table[id="5_Most_Recent_Bulletins"]', 0)->find('tbody', 0)->find('tr', $i)->find('td[class="tcontent"]', 0)->plaintext;
                  $test="SELECT * FROM app_ret WHERE title LIKE '".base64_encode(serialize($title))."' ";
                  $check=$DB->query($test);
                  $rows=$check->rowCount();

                  if($rows==0)
                  {
                  $date=$html->find('table[id="5_Most_Recent_Bulletins"]', 0)->find('tbody', 0)->find('tr', $i)->find('td[class="tdate"]', 0);
                  $date=str_replace("/", " ",$date);
                  $date= strip_tags(str_replace("&nbsp;< td>","",$date));            //used to remove all html tags
                  $explodeDate = explode(' ', $date);

                  $r=0;
                  while($body->find('ul',$r))
                  { $ar=0;
                    while($body->find('ul',$r)->find('li',$ar)){
                    $pt=$body->find('ul',$r)->find('li',$ar)->plaintext;
                    if(strpos($pt, "(PDF)")!==false)
                    {
                      $ref = $body->find('ul',$r)->find('li',$ar)->find('a',0)->href;
                      if(strpos($ref,"https")!==false)
                      {

                      }
                      else{
                      $body->find('ul',$r)->find('li',$ar)->find('a',0)->href='https://www.occ.gov'.$ref;}
                    }
                    $ar++;
                  }
                    $r++;
                  }

                  $r=0;

                  while($body->find('a',$r))
                  {
                       $ref = $body->find('a',$r)->href;
                       if(strpos($ref,"https")!==false || strpos($ref,"mailto")!==false || strpos($ref,"http")!==false || strpos($ref,"www")!==false)
                       {

                       }
                       else{
                       $body->find('a',$r)->href='https://www.occ.gov'.$ref;}
                     $r++;
                   }
                  $body->find('div[class="articleIdentifier"]',0)->innertext="";
                  $empty = $body->find('div[class="articleDateline"]',0)->plaintext;
                  $subject = (substr($empty,0,strpos($empty,"Date")));
                  $body->find('div[class="articleDateline"]',0)->innertext="";
                  $body=$subject.$body;

                  $body=serialize($body);
                  $body = base64_encode($body);
                  $sql="INSERT INTO app_ret (agency ,category , title, code ,releasedate ,content, url) VALUES ('1', 'Bulletins','".base64_encode(serialize($title))."', '".$code."' ,'".$datetime."','".$body."','".$link."')";
                  $DB->exec($sql);
                  $sql2="SELECT * FROM app_ret WHERE title ='".base64_encode(serialize($title))."' ";
                  $res=$DB->query($sql2);
                  $row=$res->fetch(PDO::FETCH_ASSOC);
                  $date1=$row['content'];
                  $date1=base64_decode($date1);
                  echo unserialize($date1);
                  }
                  else {

                    $row=$check->fetch(PDO::FETCH_ASSOC);

                    $date1=$row['content'];
                    $date1=base64_decode($date1);
                    echo unserialize($date1);
                    echo "<hr />";
                    echo "URL: <a href='".$row['url']."' >".$row['url']."</a>";
                  }
                  ?>
                </div>
              </div>
              </div>
            </div>
           <?php
           echo "<br />";
       }

       echo "<div class='text-center'>";
       echo "<a class='btn' href='". $_SERVER['HTTP_REFERER']."'><img src='https://img.icons8.com/ios-glyphs/30/000000/circled-left-2.png'>Back</a>";
       echo "</div>";
     }

     else if($_GET['type']=='alerts')
     { echo "<br />";
       echo "<h3 class='text-muted'>".$html->find('caption', 2)."</h3>";
       echo "<hr />";

       for ($i=0; $i <5 ; $i++) {
         $col="collapse".$i;
         ?>
          <div class="accordion" id="accordionExample">
           <div class="card">
              <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                  <button style='color: black' class="btn btn-link collapsed text-left" type="button" data-toggle="collapse" data-target="#<?php echo $col; ?>" aria-expanded="true" aria-controls="collapseOne">
                    <?php echo "<h5>".$html->find('table[id="alerts-5-most-recent"]', 0)->find('tbody', 0)->find('tr', $i)->find('td[class="tcontent"]', 0)->plaintext."</h5>";
                    echo "<p class='text-muted'>Date: ".$html->find('table[id="alerts-5-most-recent"]', 0)->find('tbody', 0)->find('tr', $i)->find('td[class="tdate"]', 0)."</p>";
                    echo "<p class='text-muted'>Identifier: ".$html->find('table[id="alerts-5-most-recent"]', 0)->find('tbody', 0)->find('tr', $i)->find('td[class="tidentifier"]', 0)."</p>";
                     ?>
                  </button>
                </h2>
              </div>
              <div id="<?php echo $col; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                  <?php
                  $link = $html->find('table[id="alerts-5-most-recent"]', 0)->find('tbody', 0)->find('tr', $i)->find('td[class="tcontent"]', 0)->find('a',0)->href;
                  $link="https://www.occ.gov".$link;
                  $data = file_get_html($link);
                  $body=$data->find('div[id="Issuance"]',0);

                  $title=$html->find('table[id="alerts-5-most-recent"]', 0)->find('tbody', 0)->find('tr', $i)->find('td[class="tcontent"]', 0)->plaintext;
                  $identifier=$html->find('table[id="alerts-5-most-recent"]', 0)->find('tbody', 0)->find('tr', $i)->find('td[class="tidentifier"]', 0)->plaintext;
                  $identifier = str_replace(",", "", $identifier);
                  $code = "Alert ".str_replace("Alert&nbsp;", "", $identifier);

                  $test="SELECT * FROM app_ret WHERE code LIKE '".$code."' ";
                  $check=$DB->query($test);
                  $rows=$check->rowCount();

                  if($rows==0)
                  {

                  $date=$html->find('table[id="alerts-5-most-recent"]', 0)->find('tbody', 0)->find('tr', $i)->find('td[class="tdate"]', 0);
                  $date=str_replace("/", " ",$date);
                  $date= strip_tags(str_replace("&nbsp;< td>","",$date));            //used to remove all html tags
                  $explodeDate = explode(' ', $date);
                  echo $datetime = date("Y-m-d H:i:s", strtotime(date($explodeDate[2].'-'.$explodeDate[0].'-'.$explodeDate[1]." 00:00:00")));
                  echo "<br /> <br>";

        				  echo "<p style='font-weight: bold'>".$title."</p>";

                  echo "<hr />";
                  $r=0;

                  while($body->find('ul',$r))
                  { $ar=0;
        					while($body->find('ul',$r)->find('li',$ar))
        					{
                     $pt=$body->find('ul',$r)->find('li',$ar)->plaintext;
                     if(strpos($pt, "(PDF)")!==false || strpos($pt, "(JPG)")!==false)
                     {
                       $ref = $body->find('ul',$r)->find('li',$ar)->find('a',0)->href;
                       if(strpos($ref,"https")!==false)
                       {

                       }
                       else{
                       $body->find('ul',$r)->find('li',$ar)->find('a',0)->href='https://www.occ.gov'.$ref;}
                     }
                     $ar++;
                    }
                     $r++;
                   }

                  $r=0;

                  while($body->find('a',$r))
                  {
                       $ref = $body->find('a',$r)->href;
                       if(strpos($ref,"https")!==false || strpos($ref,"mailto")!==false || strpos($ref,"http")!==false || strpos($ref,"www")!==false)
                       {

                       }
                       else{
                       $body->find('a',$r)->href='https://www.occ.gov'.$ref;}
                     $r++;
                   }
                   $body->find('div[class="articleIdentifier"]',0)->innertext="";
                   $empty = $body->find('div[class="articleDateline"]',0)->plaintext;
                   $subject = (substr($empty,0,strpos($empty,"Date")));
                   $body->find('div[class="articleDateline"]',0)->innertext="";
                   $body=$subject.$body;

                   $body=base64_encode(serialize($body));
                   $sql="INSERT INTO app_ret (agency ,category , title, code ,releasedate ,content, url) VALUES ('1', 'Alerts','".base64_encode(serialize($title))."', '".$code."' ,'".$datetime."','".$body."','".$link."')";
                   $DB->exec($sql);
                   $sql2="SELECT * FROM app_ret WHERE title ='".base64_encode(serialize($title))."' ";
                   $res=$DB->query($sql2);
                   $row=$res->fetch(PDO::FETCH_ASSOC);
                   $date1=$row['content']."<br />";
                   $date1=base64_decode($date1);
                   echo unserialize($date1);
                   }

					         else {

                    $row=$check->fetch(PDO::FETCH_ASSOC);;
                    $date1=$row['content'];
                    $date1=base64_decode($date1);
                    echo unserialize($date1);
                   }
                  ?>
                </div>
              </div>
              </div>
            </div>
           <?php
           echo "<br />";
       }



       echo "<div class='text-center'>";
       echo "<a class='btn' href='". $_SERVER['HTTP_REFERER']."'><img src='https://img.icons8.com/ios-glyphs/30/000000/circled-left-2.png'>Back</a>";
       echo "</div>";
     }

     else if($_GET['type']=='testimony')
     {
       echo "<br />";
       echo "<h3 class='text-muted'>".$html->find('h3', 1)->plaintext."</h3>";

       for ($i=0; $i <5 ; $i++)
       {
        echo "<hr />";
                 //echo "Date: ".$html->find('table', 5)->find('tbody', 0)->find('tr', $i)->find('td', 0)."<br />";
                 //echo "Testimony: <span style='font-weight: bold'".$html->find('table', 5)->find('tbody', 0)->find('tr', $i)->find('td', 1)."</span><br />";
         $date = $html->find('table', 5)->find('tbody', 0)->find('tr', $i)->find('td', 0);
         $body = $html->find('table', 5)->find('tbody', 0)->find('tr', $i)->find('td', 1);

         $date=str_replace("/", " ",$date);
         $date= strip_tags(str_replace("&nbsp;< td>","",$date));            //used to remove all html tags
         $explodeDate = explode(' ', $date);
         $datetime = date("Y-m-d H:i:s", strtotime(date($explodeDate[2].'-'.$explodeDate[0].'-'.$explodeDate[1]." 00:00:00")))."<br>";

          $testimony = $html->find('table', 5)->find('tbody', 0)->find('tr', $i)->find('td', 1)->plaintext;
          $position=strpos($testimony, "Oral");
          $testimony = substr($testimony, 0, $position);

          $test="SELECT * FROM app_ret WHERE title LIKE '".base64_encode(serialize($testimony))."' ";
          $check=$DB->query($test);
          $rows=$check->rowCount();

          if($rows==0)
          {

          $r=0;

          while($body->find('a',$r))
          {
               $ref = $body->find('a',$r)->href;
               if(strpos($ref,"https")!==false)
               {

               }
               else{
               $body->find('a',$r)->href='https://www.occ.gov'.$ref;}
             $r++;
           }

           $body=base64_encode(serialize($body));
           try{
           $sql="INSERT INTO app_ret (agency ,category , title,releasedate ,content, url) VALUES ('1', 'Congressional Testimony','".base64_encode(serialize($testimony))."', '".$datetime."','".$body."','https://www.occ.gov/news-issuances/congressional-testimony/index.html')";
           $DB->exec($sql);
         }
         catch(PDOException $e)
         {
           die($e->getMessage());
         }
           $sql2="SELECT * FROM app_ret WHERE title ='".base64_encode(serialize($testimony))."' ";
           $res=$DB->query($sql2);
           $row=$res->fetch(PDO::FETCH_ASSOC);
           echo date("F d, Y", strtotime($row['releasedate']))."<br />";
           $date1=$row['content']."<br />";
           $date1 = base64_decode($date1);
           echo unserialize($date1)."<br>";
           }
           else
           {
            $row=$check->fetch(PDO::FETCH_ASSOC);
            $date1=$row['content'];
            $date1 = base64_decode($date1);
            echo unserialize($date1);
           }
       }


       echo "<div class='text-center'>";
       echo "<a class='btn' href='". $_SERVER['HTTP_REFERER']."'><img src='https://img.icons8.com/ios-glyphs/30/000000/circled-left-2.png'>Back</a>";
       echo "</div>";
     }


     else if($_GET['type']=='speeches')
     { echo "<br />";
       echo "<h3 class='text-muted'>".$html->find('caption', 3)."</h3>";
       for ($i=0; $i <5 ; $i++)
       {

           echo "<hr />";

         $date = $html->find('table[id="5_Most_Recent_Statements-Speeches"]', 0)->find('tbody', 0)->find('tr', $i)->find('td[class="tdate"]', 0);
         $body = $html->find('table[id="5_Most_Recent_Statements-Speeches"]', 0)->find('tbody', 0)->find('tr', $i)->find('td[class="tcontent"]', 0);

         $date=str_replace("/", " ",$date);
         $date= strip_tags(str_replace("&nbsp;< td>","",$date));            //used to remove all html tags
         $explodeDate = explode(' ', $date);
         $datetime = date("Y-m-d H:i:s", strtotime(date($explodeDate[2].'-'.$explodeDate[0].'-'.$explodeDate[1]." 00:00:00")))."<br>";

          $speech = $html->find('table[id="5_Most_Recent_Statements-Speeches"]', 0)->find('tbody', 0)->find('tr', $i)->find('td[class="tcontent"]', 0)->plaintext;

          $test="SELECT * FROM app_ret WHERE title LIKE '".base64_encode(serialize($speech))."' ";
          $check=$DB->query($test);
          $rows=$check->rowCount();

          if($rows==0)
          {

          $r=0;

          while($body->find('a',$r))
          {
               $ref = $body->find('a',$r)->href;
               if(strpos($ref,"https")!==false)
               {

               }
               else{
               $body->find('a',$r)->href='https://www.occ.gov'.$ref;}
             $r++;
           }

           $body=base64_encode(serialize($body));
           $sql="INSERT INTO app_ret (agency ,category , title,releasedate ,content, url) VALUES ('1', 'Speeches','".base64_encode(serialize($speech))."', '".$datetime."','".$body."','https://www.occ.gov/news-issuances/speeches/index.html')";
           $DB->exec($sql);
           $sql2="SELECT * FROM app_ret WHERE title ='".base64_encode(serialize($speech))."' ";
           $res=$DB->query($sql2);
           $row=$res->fetch(PDO::FETCH_ASSOC);
           echo date("F d, Y", strtotime($row['releasedate']))."<br />";
           $date1=$row['content'];
           $date1 = base64_decode($date1);
           echo unserialize($date1)."<br>";
           }
           else
           {
            $row=$check->fetch(PDO::FETCH_ASSOC);
            $date1=$row['content'];
            $date1 = base64_decode($date1);
            echo unserialize($date1);
           }
       }

       echo "<br>";
       echo "<div class='text-center'>";
       echo "<a class='btn' href='". $_SERVER['HTTP_REFERER']."'><img src='https://img.icons8.com/ios-glyphs/30/000000/circled-left-2.png'>Back</a>";
       echo "</div>";
     }

     else if($_GET['type']=='public')
     {
      echo "<br>";
       $ref = $html->find('h3',2)->find('a',0)->href;
       $link = "https://occ.gov".$ref;
       $page=file_get_html($link);

       $test="SELECT * FROM app_ret WHERE category LIKE 'Public Service Announcements' ";
       $check=$DB->query($test);
       $rows=$check->rowCount();

       if($rows==0)
       {

         $r=0;

        while($page->find('main',0)->find('a',$r))
         {
           $ref = $page->find('main',0)->find('a',$r)->href;
           if(strpos($ref,"https")!==false)
           {

           }
           else{
           $page->find('main',0)->find('a',$r)->href='https://www.occ.gov'.$ref;}
         $r++;
        }
        $body = $page->find('main',0);

        $body=base64_encode(serialize($body));
        $sql="INSERT INTO app_ret (agency ,category,content, url) VALUES ('1', 'Public Service Announcements','".$body."','https://www.occ.gov/news-issuances/psa/index-psa.html')";
        $DB->exec($sql);
        $sql2="SELECT * FROM app_ret WHERE category LIKE 'Public Service Announcements' ";
        $res=$DB->query($sql2);
        $row=$res->fetch(PDO::FETCH_ASSOC);

        $date1=$row['content'];
        $date1 = base64_decode($date1);
        echo unserialize($date1)."<br>";
        }
        else
        {
         $row=$check->fetch(PDO::FETCH_ASSOC);
         $date1=$row['content'];
         $date1 = base64_decode($date1);
         echo unserialize($date1);
        }

       echo "<br>";
       echo "<div class='text-center'>";
       echo "<a class='btn' href='". $_SERVER['HTTP_REFERER']."'><img src='https://img.icons8.com/ios-glyphs/30/000000/circled-left-2.png'>Back</a>";
       echo "</div>";
     }

    //I have deleted the lines of code for OTS, since the page hasnt beeen updated since 2011 and that I already have the database in my localhost. Search for the file: OTS statements to find the delete lines of code

     else
    {

    echo "<br />";
    $head_image=$html->find('td[class="header-logo"]', 0);
    echo "<h4 style='text-align:center;'>".$head_image."</h4>";

    echo "<br />";
    echo "<h5>".$title."</h5>";

    echo "<br />"; ?>

    <a href="<?php echo $APP->BASEURL ?>/index.php?ID=19&scrape=occ&type=news" class="btn col-12 btn-outline-primary btn-light">
     <?php echo $html->find('caption', 0); ?>
   </a>
   <br><br>
   <a href="<?php echo $APP->BASEURL ?>/index.php?ID=19&scrape=occ&type=bulletins" class="btn col-12 btn-outline-primary btn-light">
    <?php echo $html->find('caption', 1); ?>
  </a><br><br>
  <a href="<?php echo $APP->BASEURL ?>/index.php?ID=19&scrape=occ&type=alerts" class="btn col-12 btn-outline-primary btn-light">
   <?php echo $html->find('caption', 2); ?>
 </a><br><br>
 <a href="<?php echo $APP->BASEURL ?>/index.php?ID=19&scrape=occ&type=testimony" class="btn col-12 btn-outline-primary btn-light">
  <?php $var=$html->find('h3', 1)->plaintext;
    echo $var; ?>
  </a><br><br>
  <a href="<?php echo $APP->BASEURL ?>/index.php?ID=19&scrape=occ&type=speeches" class="btn col-12 btn-outline-primary btn-light">
  <?php echo $html->find('caption', 3); ?>
</a><br><br>
<a href="<?php echo $APP->BASEURL ?>/index.php?ID=19&scrape=occ&type=public" class="btn col-12 btn-outline-primary btn-light">
  <?php $var=$html->find('h3', 2)->plaintext;
    echo $var; ?>
</a><br><br>
<!-- <a href="<?php echo $APP->BASEURL ?>/index.php?ID=19&scrape=occ&type=OTS" class="btn col-12 btn-outline-primary btn-light">
  <?php $var=$html->find('strong', 6)->plaintext;
    echo $var; ?> -->
</a><br><br>
 <?php
  }
   echo "</div>";
}
elseif($_GET['scrape']=='frs')
{
  ?>
    <br>
    <h1>Federal Reserve System</h1><br>
    <?php

    if(!isset($_GET['type'])){?>
    <div class="container">
      <li><a href= <?php echo $APP->BASEURL."/index.php?ID=19&scrape=frs&type=press" ?> > Press releases</a></li>
    </div>

    <?php }

    if($_GET['type']=='press'){
    $html=file_get_html('https://www.federalreserve.gov/newsevents/pressreleases/2019-press.htm');
    $body = $html->find('div[class="col-xs-12 col-sm-8 col-md-8"]',0);
    $row=$body->find('div[class="row"]');
    echo "<div class='container'>";
      foreach ($row as $key => $value)
      {
        $title = $value->find('a',0)->find('em',0)->plaintext;

        try{
        $sql2="SELECT * FROM app_ret WHERE title LIKE '".base64_encode(serialize($title))."' AND agency LIKE '2' ";
        $res=$DB->query($sql2);
        }
        catch(PDOException $e)
        {

        }

        if($res->rowCount() == 0)
        {
        $date = $value->find('div[class="col-xs-3 col-md-2 eventlist__time"]',0)->plaintext;
        $date=str_replace("/", " ",$date);
        $date = trim($date," ");
        $explodeDate = explode(' ', $date);
        $datetime = date("Y-m-d H:i:s", strtotime(date($explodeDate[2].'-'.$explodeDate[0].'-'.$explodeDate[1]." 00:00:00")));


        $link = "https://www.federalreserve.gov".$value->find('a',0)->href;
        $type = $value->find('strong',0)->plaintext;
        $regulation = file_get_html($link);

        $last = $regulation->find('div[id="lastUpdate"]',0)->plaintext;
        $dt = substr($last,13);
        $pos = strpos($dt, "," ,0)+6;
        $dt=str_replace(",","",trim(substr($dt,0,$pos)," "));
        $date=strtotime($dt);
        $cur_date=date("Y-m-d H:i:s",$date);

        $req_reg = $regulation->find('div[class="col-xs-12 col-sm-8 col-md-8"]',0);

        $r=0;
        while($req_reg->find('a',$r))
        {
               $ref = $req_reg->find('a',$r)->href;
               if(strpos($ref,"https")!==false)
               {

               }
               else{
               $req_reg->find('a',$r)->href='https://www.federalreserve.gov'.$ref;
               $link=$req_reg->find('a',$r)->href;
             }
             $r++;
        }
        $r=0;
        while($req_reg->find('img',$r))
        {
               $ref = $req_reg->find('img',$r)->src;
               if(strpos($ref,"https")!==false || strpos($ref,"http")!==false)
               {

               }
               else
               {
                $req_reg->find('img',$r)->src='https://www.federalreserve.gov'.$ref;
                $link=$req_reg->find('img',$r)->src;
               }
             $r++;
        }
        try{
        $sql="INSERT INTO app_ret (agency ,category ,subcategory, title,releasedate ,url,content,lastupdated) VALUES ('2' ,'Press Releases','".$type."','".base64_encode(serialize($title))."','".$datetime."','".$link."','".base64_encode(serialize($req_reg))."','".$cur_date."') ";
        $DB->exec($sql);
      }
      catch(PDOException $e)
      {

      }
        if($key==15)
        {
          break;
        }
    }
    else
      { $sql3="SELECT * FROM app_ret WHERE agency LIKE '2' ORDER BY releasedate DESC LIMIT 10";
        $re = $DB->query($sql3);
        $press = $re->fetchAll(PDO::FETCH_ASSOC);
        foreach ($press as $key => $value)
         {
          $col="collapse".$key;
          ?>
          <div class="accordion" id="accordionExample">
           <div class="card">
              <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                  <button style='color: black' class="btn btn-link collapsed text-left" type="button" data-toggle="collapse" data-target="#<?php echo $col; ?>" aria-expanded="true" aria-controls="collapseOne">
                    <?php echo "<h5>".unserialize(base64_decode($value['title']))."</h5>";
                    echo "<p class='text-muted'>Date: ".$value['releasedate']."</p>";
                    echo "<p class='text-muted'>".$value['subcategory']."</p>";
                     ?>
                  </button>
                </h2>
              </div>
              <div id="<?php echo $col; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                  <?php
                    $unser = base64_decode($value['content']);
                    echo unserialize($unser);
                    echo "<br /><p class='text-muted'>Last Updated: ".$value['lastupdated']."</p>";
                  ?>
                </div>
              </div>
              </div>
            </div>
            <br>
          <?php

        }
        break;
      }
    }
    echo "</div>";
  }
}

  elseif ($_GET['scrape']=='fdic')
  {
    echo "<br>";
    echo "<h3>Federal Deposit Insurance Corporation</h3>";
    echo "<br>";
    if(!isset($_GET['type'])){?>
    <div class="container">
      <li><a href= <?php echo $APP->BASEURL."/index.php?ID=19&scrape=fdic&type=press" ?> > Press releases</a></li>
      <li><a href= <?php echo $APP->BASEURL."/index.php?ID=19&scrape=fdic&type=fil" ?> > Financial Institution Letters</a></li>
      <li><a href= <?php echo $APP->BASEURL."/index.php?ID=19&scrape=fdic&type=sat" ?> > Speeches & Testimony</a></li>
    </div>

    <?php }
    if($_GET['type']=='press')
    {
    echo "<div class='container'>";
    echo "<h5>Press Releases</h5>";
      $html=file_get_html('https://www.fdic.gov/news/news/press/2019/');
      echo "<br>";
      $body = $html->find('ul[class="press_releases"]',0)->find('li',0);

      $row=$body->find('li');
      foreach ($row as $key => $value)
      {
        $title = $value->find('a',0)->plaintext;

        $dt = $value->find('span[class="title"]',0)->plaintext;
        $pos = strpos($dt, "," ,0)+6;
        $dt=str_replace(",","",trim(substr($dt,0,$pos)," "));
        $date=strtotime($dt);
        $cur_date=date("Y-m-d H:i:s",$date);

        $sql2="SELECT * FROM app_ret WHERE releasedate LIKE '".$cur_date."' AND title LIKE '".base64_encode(serialize($title))."' ";
        $res=$DB->query($sql2);

        if($res->rowCount() == 0)
        {
        $link = "https://www.fdic.gov/news/news/press/2019/".$value->find('a',0)->href;

        $regulation = file_get_html($link);

        $last = substr($regulation->find('div[class="date"]',0)->plaintext,13);
        $date=str_replace("/", " ",$last);
        $date = trim($date," ");
        $explodeDate = explode(' ', $date);
        $datetime = date("Y-m-d ", strtotime(date($explodeDate[2].'-'.$explodeDate[0].'-'.$explodeDate[1])));

        $req_reg = $regulation->find('div[id="content"]',0);
        $req_reg->find('h1',0)->innertext="";
        $req_reg->find('h2',0)->innertext="";

        $che = $req_reg->find('p');
        $code = $req_reg->find('p',(count($che))-1)->find('strong',0)->plaintext;

        if(strpos($code,"FDIC")!==false)
        {
          $code = substr($req_reg->find('p',(count($che))-1)->find('strong',0)->plaintext,6);
        }
        $req_reg->find('p',(count($che))-1)->find('strong',0)->innertext="";

        $r=0;
        while($req_reg->find('a',$r))
        {
               $ref = $req_reg->find('a',$r)->href;
               $che = $req_reg->find('a',$r)->plaintext;
               if(strpos($ref,"https")!==false || strpos($ref,"mailto")!==false || strpos($ref,"http")!==false)
               {

               }
               elseif( strpos($che,"PDF")!==false){
               $req_reg->find('a',$r)->href='https://www.fdic.gov/news/news/press/2019/'.$ref;
               $link=$req_reg->find('a',$r)->href;
               }
               else
               {
                $req_reg->find('a',$r)->href='https://www.fdic.gov'.$ref;
                $link=$req_reg->find('a',$r)->href;
               }
             $r++;
        }

        $text = $req_reg->find('div[class="for_release"]',0)->plaintext;
        if(strpos($text,"IMMEDIATE")!==false)
        {
          $req_reg->find('div[class="for_release"]',0)->innertext = ""."<strong>FOR IMMEDIATE RELEASE</strong>";
        }
        else {
                  $req_reg->find('div[class="pr_date"]',0)->innertext = "";
        }


        $sql = "INSERT INTO app_ret (agency ,category,title,code,releasedate ,url,content,lastupdated) VALUES ('4' ,'Press Releases','".base64_encode(serialize($title))."', '".$code."' ,'".$cur_date."','".$link."','".base64_encode(serialize($req_reg))."','".$datetime."')";
        $DB->exec($sql);
        if($key == 15)
        {
          break;
        }
      }
      else
      {
        $sql3="SELECT * FROM app_ret WHERE agency LIKE '4' ORDER BY releasedate DESC LIMIT 10";
        $re = $DB->query($sql3);
        $press = $re->fetchAll(PDO::FETCH_ASSOC);
        foreach ($press as $key => $value)
         {
          $col="collapse".$key;
          ?>
          <div class="accordion" id="accordionExample">
           <div class="card">
              <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                  <button style='color: black' class="btn btn-link collapsed text-left" type="button" data-toggle="collapse" data-target="#<?php echo $col; ?>" aria-expanded="true" aria-controls="collapseOne">
                    <?php echo "<h5>".unserialize(base64_decode($value['title']))."</h5>";
                    echo "Code: ".$value['code']."<br /><br />";
                    echo "<p class='text-muted'>Date: ".$value['releasedate']."</p>";
                     ?>
                  </button>
                </h2>
              </div>
              <div id="<?php echo $col; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                  <?php
                    echo unserialize(base64_decode($value['content']));
                    echo "<strong>Last Updated:</strong> ".$value['lastupdated']."<br />";
                    echo "<br />Link: <a href='".$value['url']."'>".$value['url']."</a>";
                  ?>
                </div>
              </div>
              </div>
            </div>
            <br>
          <?php

        }
        break;
      }

     }
     echo "</div>";
    }

    elseif ($_GET['type']=='fil')
    {
        echo "<div class='container'>";
            $html=file_get_html('https://www.fdic.gov/news/news/financial/index.html');
            echo "<h4>Financial Institution Letters: </h4>";
            echo "<br>";
            $body = $html->find('table[id="table"]',0);
            $row = $body->find('tbody',0)->find('tr');

            foreach ($row as $key => $value)
            {
              $title = $value->find('a',0)->plaintext;

              $dt = $value->find('td',1)->plaintext;
              $dt = str_replace("-", " ", $dt);
              $date=strtotime($dt);
              $cur_date=date("Y-m-d H:i:s",$date);

              $deactiv = $value->find('td',3)->plaintext;
              $status = $value->find('td',2);
              $sql2="SELECT * FROM app_ret WHERE releasedate LIKE '".$cur_date."' AND title LIKE '".base64_encode(serialize($title))."' ";
              $res=$DB->query($sql2);

              if($res->rowCount() == 0)
              {
              $url = $value->find('a',0)->href;

              $regulation = file_get_html($url);

              $req_reg = $regulation->find('div[id="content"]',0);
              $che = $req_reg->find('div[class="number_and_date"]',0)->plaintext;
              $che = trim($che," ");
              $pos = strpos($che," ");
              $code = substr($che,0,$pos-2);

              $req_reg->find('h1',0)->innertext="";
              $req_reg->find('h2',0)->innertext="";

              $last = substr($regulation->find('div[class="date"]',0)->plaintext,13);
              $date=str_replace("/", " ",$last);
              $date = trim($date," ");
              $explodeDate = explode(' ', $date);
              $datetime = date("Y-m-d ", strtotime(date($explodeDate[2].'-'.$explodeDate[0].'-'.$explodeDate[1])));

              $r=0;
              while($req_reg->find('a',$r))
              {
                     $ref = $req_reg->find('a',$r)->href;
                     $che = $req_reg->find('a',$r)->plaintext;
                     if(strpos($ref,"https")!==false || strpos($ref,"mailto")!==false || strpos($ref,"http")!==false)
                     {

                     }
                     elseif( strpos($che,"PDF")!==false){
                     $req_reg->find('a',$r)->href='https://www.fdic.gov/news/news/financial/2019/'.$ref;
                     $link=$req_reg->find('a',$r)->href;
                     }
                     else
                     {
                      $req_reg->find('a',$r)->href='https://www.fdic.gov'.$ref;
                      $link=$req_reg->find('a',$r)->href;
                     }
                   $r++;
              }

              $req_reg->find('div[class="number_and_date"]',0)->innertext="";

              $sql="INSERT INTO app_ret (agency ,category,title,code,releasedate ,url,content,lastupdated) VALUES ('4' ,'Financial Institution Letters','".base64_encode(serialize($title))."', '".$code."' ,'".$cur_date."','".$url."','".base64_encode(serialize($req_reg))."','".$datetime."')";
              $DB->exec($sql);
              if($key==15)
              {
                break;
              }
            }
            else
            { $sql3="SELECT * FROM app_ret WHERE agency LIKE '4' AND category LIKE 'Financial Institution Letters' ORDER BY releasedate LIMIT 10";
              $re = $DB->query($sql3);
              $press = $re->fetchAll(PDO::FETCH_ASSOC);
              foreach ($press as $key => $value)
               {
                $col="collapse".$key;
                ?>
                <div class="accordion" id="accordionExample">
                 <div class="card">
                    <div class="card-header" id="headingOne">
                      <h2 class="mb-0">
                        <button style='color: black' class="btn btn-link collapsed text-left" type="button" data-toggle="collapse" data-target="#<?php echo $col; ?>" aria-expanded="true" aria-controls="collapseOne">
                          <?php echo "<h5>".unserialize(base64_decode($value['title']))."</h5>";
                          echo "<p class='text-muted'>Date: ".$value['releasedate']."</p>";
                           ?>
                        </button>
                      </h2>
                    </div>
                    <div id="<?php echo $col; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                      <div class="card-body">
                        <?php
                          echo unserialize(base64_decode($value['content']));
                          echo "Last Updated: ".$value['lastupdated'];
                          echo "<br />Link: <a href='".$value['url']."'>".$value['url']."</a>";
                        ?>
                      </div>
                    </div>
                    </div>
                  </div>
                  <br>
                <?php

              }
              break;
            }
           }
        echo "</div>";
      }

    elseif ($_GET['type']=='sat')
    {
        echo "<div class='container'>";
            $html=file_get_html('https://www.fdic.gov/news/news/speeches/');
            echo "<h4>Speeches and Testimony:</h4>";
            echo "<br>";
            $body = $html->find('table',0);
            $row = $body->find('tr');

            foreach ($row as $key => $value)
            {
              $title = $value->find('td',1);
              $name = $value->find('td',1)->plaintext;

              $dt = $value->find('td',0)->plaintext;
              $pos = strpos($dt, "," ,0)+6;
              $dt=str_replace(",","",trim(substr($dt,0,$pos)," "));
              $date=strtotime($dt);
              $cur_date=date("Y-m-d H:i:s",$date);

              $sql2="SELECT * FROM app_ret WHERE releasedate LIKE '".$cur_date."' AND title LIKE '".base64_encode(serialize($name))."' ";
              $res=$DB->query($sql2);

              if($res->rowCount() == 0)
              {
              $link = $title->find('a',0)->href;
              $url = "https://www.fdic.gov".$link;

              $regulation = file_get_html($url);

              $req_reg = $regulation->find('div[id="content"]',0);
              $req_reg->find('h1',0)->innertext="";
              $req_reg->find('h2',1)->innertext="";
              $req_reg->find('h2',0)->innertext="";

              $last = substr($regulation->find('div[class="date"]',0)->plaintext,13);
              $date=str_replace("/", " ",$last);
              $date = trim($date," ");
              $explodeDate = explode(' ', $date);
              $datetime = date("Y-m-d ", strtotime(date($explodeDate[2].'-'.$explodeDate[0].'-'.$explodeDate[1])));

              $r=0;
              while($req_reg->find('a',$r))
              {
                     $ref = $req_reg->find('a',$r)->href;
                     $che = $req_reg->find('a',$r)->plaintext;
                     if(strpos($ref,"https")!==false || strpos($ref,"mailto")!==false || strpos($ref,"http")!==false)
                     {

                     }
                     elseif( strpos($che,"PDF")!==false){
                     $req_reg->find('a',$r)->href='https://www.fdic.gov/news/news/speeches/'.$ref;
                     $link=$req_reg->find('a',$r)->href;
                     }
                     else
                     {
                      $req_reg->find('a',$r)->href='https://www.fdic.gov'.$ref;
                      $link=$req_reg->find('a',$r)->href;
                     }
                   $r++;
              }

              $sql = "INSERT INTO app_ret (agency ,category,title,releasedate ,url,content,lastupdated) VALUES ('4' ,'Speeches & Testimony','".base64_encode(serialize($name))."','".$cur_date."','".$url."','".base64_encode(serialize($req_reg))."','".$datetime."')";
              $DB->exec($sql);
              if($key==10)
              {
                break;
              }
            }
            else
            { $sql3="SELECT * FROM app_ret WHERE agency LIKE '4' AND category LIKE 'Speeches & Testimony' ORDER BY releasedate DESC LIMIT 10";
              $re = $DB->query($sql3);
              $press = $re->fetchAll(PDO::FETCH_ASSOC);
              foreach ($press as $key => $value)
               {
                $col="collapse".$key;
                ?>
                <div class="accordion" id="accordionExample">
                 <div class="card">
                    <div class="card-header" id="headingOne">
                      <h2 class="mb-0">
                        <button style='color: black' class="btn btn-link collapsed text-left" type="button" data-toggle="collapse" data-target="#<?php echo $col; ?>" aria-expanded="true" aria-controls="collapseOne">
                          <?php echo "<h5>".unserialize(base64_decode($value['title']))."</h5>";
                          echo "<p class='text-muted'>Date: ".$value['releasedate']."</p>";
                           ?>
                        </button>
                      </h2>
                    </div>
                    <div id="<?php echo $col; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                      <div class="card-body">
                        <?php
                          echo unserialize(base64_decode($value['content']));
                          echo "Last Updated: ".$value['lastupdated'];
                          echo "<br />Link: <a href='".$value['url']."'>".$value['url']."</a>";
                        ?>
                      </div>
                    </div>
                    </div>
                  </div>
                  <br>
                <?php

              }
              break;
            }
           }
        echo "</div>";
      }

    }

  elseif($_GET['scrape']=='exim')
  {
    echo "<br><h3>Export Import Bank Of United States</h3>";
    echo "<br><br>";
    $html=file_get_html('https://www.exim.gov/news');
    $body = $html->find('div[class="view-content"]',0);
    $row=$body->find('div[class="views-field views-field-title"]');

    echo "<div class='container'>";

      foreach ($row as $key => $value)
      {
        $link = "https://www.exim.gov".$value->find('a',0)->href;
        $title = $value->find('a',0)->plaintext;

        $regulation = file_get_html($link);
        $dt = $regulation->find('div[class="field-label"]',0)->find('span',0)->plaintext;
        $pos = strpos($dt, "," ,0)+6;
        $dt=str_replace(",","",trim(substr($dt,0,$pos)," "));
        $date=strtotime($dt);
        $cur_date=date("Y-m-d H:i:s",$date);

        $sql2="SELECT * FROM app_ret WHERE title LIKE '".base64_encode(serialize($title))."' AND releasedate = '".$cur_date."' ";
        $res=$DB->query($sql2);

        if($res->rowCount() == 0)
        {
        $req_reg = $regulation->find('article[class="node node-news view-mode-full node-by-viewer clearfix"]',0);

        $r=0;
        while($req_reg->find('a',$r))
        {
               $ref = $req_reg->find('a',$r)->href;
               $che = $req_reg->find('a',$r)->plaintext;
               if(strpos($ref,"https")!==false || strpos($ref,"mailto")!==false || strpos($ref,"http")!==false || strpos($ref,"www")!==false)
               {

               }
               // elseif( strpos($che,"PDF")!==false){
               // $req_reg->find('a',$r)->href='https://www.fdic.gov/news/news/speeches/'.$ref;
               // $link=$req_reg->find('a',$r)->href;
               // }
               else
               {
                $req_reg->find('a',$r)->href='https://www.exim.gov'.$ref;
                $link=$req_reg->find('a',$r)->href;
               }
             $r++;
        }
        $r=0;
        while($req_reg->find('img',$r))
        {
               $ref = $req_reg->find('img',$r)->src;
               if(strpos($ref,"https")!==false || strpos($ref,"http")!==false)
               {

               }
               // elseif( strpos($che,"PDF")!==false){
               // $req_reg->find('a',$r)->href='https://www.fdic.gov/news/news/speeches/'.$ref;
               // $link=$req_reg->find('a',$r)->href;
               // }
               else
               {
                $req_reg->find('img',$r)->src='https://www.exim.gov'.$ref;
                $link=$req_reg->find('img',$r)->src;
               }
             $r++;
        }
        $req_reg->find('div[class="field-label"]',0)->innertext="<strong>FOR IMMEDIATE RELEASE</strong>";
        $sql = "INSERT INTO app_ret (agency ,category,title,releasedate ,url,content) VALUES ('5' ,'News','".base64_encode(serialize($title))."','".$cur_date."','".$link."','".base64_encode(serialize($req_reg))."')";
        $DB->exec($sql);
        if($key==10)
        {
          break;
        }
      }
      else
      { $sql3="SELECT * FROM app_ret WHERE agency LIKE '5' ORDER BY releasedate DESC ";
        $re = $DB->query($sql3);
        $press = $re->fetchAll(PDO::FETCH_ASSOC);
        foreach ($press as $key => $value)
         {
          $col="collapse".$key;
          ?>
          <div class="accordion" id="accordionExample">
           <div class="card">
              <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                  <button style='color: black' class="btn btn-link collapsed text-left" type="button" data-toggle="collapse" data-target="#<?php echo $col; ?>" aria-expanded="true" aria-controls="collapseOne">
                    <?php echo "<h5>".unserialize(base64_decode($value['title']))."</h5>";
                    echo "<p class='text-muted'>Date: ".$value['releasedate']."</p>";
                     ?>
                  </button>
                </h2>
              </div>
              <div id="<?php echo $col; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                  <?php
            			  echo unserialize(base64_decode($value['content']));
                    echo "Link : <a href='".$value['url']."' >".$value['url']."</a>";
                  ?>
                </div>
              </div>
              </div>
            </div>
            <br>
          <?php

        }
        break;
      }
    }
    echo "</div>";
  }

  elseif($_GET['scrape']=='fca')
  {
    echo "<br><h3>Farm Credit Administration</h3>";
    echo "<br><br>";
    $html=file_get_html('https://www.fca.gov/newsroom/news');
    $body = $html->find('div[class="usa-width-two-thirds"]',0);
    $row=$body->find('div[class="usa-grid usa-border-bottom"]');

    echo "<div class='container text-center'>";

      foreach ($row as $key => $value)
      {
        $link = $value->find('a',0)->href;
        $title = $value->find('a',0)->plaintext;
        $code = "";

        if(strpos($link,"NR-")!==false)
        {
        $code = substr($link,strpos($link, "NR-"),8);                 //extracting the code of the agency release from the link
        }

        $dt = $value->find('span[class="usa-news-date"]',0)->plaintext;
        $pos = strpos($dt, "," ,0)+6;
        $dt=str_replace(",","",trim(substr($dt,0,$pos)," "));
        $date=strtotime($dt);
        $cur_date=date("Y-m-d H:i:s",$date);

        $sql2="SELECT * FROM app_ret WHERE title LIKE '".base64_encode(serialize($title))."' AND releasedate = '".$cur_date."' ";
        $res=$DB->query($sql2);

        if($res->rowCount() == 0)
        {
        $sql = "INSERT INTO app_ret (agency,code ,category,title,releasedate ,url) VALUES ('7' ,'".$code."','News Releases','".base64_encode(serialize($title))."','".$cur_date."','".$link."')";
        $DB->exec($sql);
        if($key==29)
        {
          break;
        }
      }
      else
      { $sql3="SELECT * FROM app_ret WHERE agency LIKE '7' ORDER BY releasedate DESC ";
        $re = $DB->query($sql3);
        $press = $re->fetchAll(PDO::FETCH_ASSOC);
        foreach ($press as $key => $value)
         { $yes = unserialize(base64_decode($value['title']));;
           echo "<a class='btn col-12 btn-outline-primary' href='".$value['url']."'>'".$yes."'</a>";
           echo "<br><br>";
        }
        break;
      }

    }
    echo "</div>";
  }

  elseif ($_GET['scrape']=='cftc')
  {
    echo "<br><h3>Commodity Future Trading Commision</h3>";
    echo "<br><br>";

    echo "<div class='container'>";
    if ($_GET['type']=='pr')
    {
      $html = file_get_html('https://www.cftc.gov/PressRoom/PressReleases');
      $body = $html->find('div[class="view-content"]',0)->find('tbody',0);
      $row = $body->find('tr');
      echo "<h4>Press Releases: </h4>";
      foreach ($row as $key => $value)
      {
        $date = $value->find('td',0)->plaintext;
        $date=str_replace("/", " ",$date);
        $date = trim($date," ");
        $explodeDate = explode(' ', $date);
        $datetime = date("Y-m-d H:i:s", strtotime(date($explodeDate[2].'-'.$explodeDate[0].'-'.$explodeDate[1]." 00:00:00")));

        $title = $value->find('td',1)->find('a',0)->plaintext;

        $che = $value->find('a',0)->href;
        $value->find('a',0)->href = "https://www.cftc.gov".$che;
        $link = $value->find('a',0)->href;

        $code = trim($value->find('td',1)->plaintext," ");
        $code = trim(substr($code, strlen($code)-8)," ");

        $content = file_get_html($link);

        $content = $content->find('div[class="press-release"]',0);
        // $text = $content->find('h1',0)->innertext;
        $content->find('h1',0)->innertext = "";
        $content->find('div[class="field field--name-field-release-number field--type-text field--label-inline"]',0)->innertext="";
        $content->find('p',0)->innertext="";

        $r=0;
        while($content->find('a',$r))
        {
               $ref = $content->find('a',$r)->href;
               $che = $content->find('a',$r)->plaintext;
               if(strpos($ref,"https")!==false || strpos($ref,"mailto")!==false || strpos($ref,"http")!==false || strpos($ref,"www")!==false)
               {

               }
               // elseif( strpos($che,"PDF")!==false){
               // $req_reg->find('a',$r)->href='https://www.fdic.gov/news/news/speeches/'.$ref;
               // $link=$req_reg->find('a',$r)->href;
               // }
               else
               {
                $content->find('a',$r)->href='https://www.cftc.gov'.$ref;
                $link=$content->find('a',$r)->href;
               }
             $r++;
        }
        $r=0;
        while($content->find('img',$r))
        {
               $ref = $content->find('img',$r)->src;
               if(strpos($ref,"https")!==false || strpos($ref,"http")!==false)
               {

               }
               // elseif( strpos($che,"PDF")!==false){
               // $req_reg->find('a',$r)->href='https://www.fdic.gov/news/news/speeches/'.$ref;
               // $link=$req_reg->find('a',$r)->href;
               // }
               else
               {
                $content->find('img',$r)->src='https://www.cftc.gov'.$ref;
                $link=$content->find('img',$r)->src;
               }
             $r++;
        }

        $sql2="SELECT * FROM app_ret WHERE title LIKE '".base64_encode(serialize($title))."' AND releasedate = '".$datetime."' ";
        $res=$DB->query($sql2);
        if($res->rowCount() == 0 )
        {
        $sql = "INSERT INTO app_ret (agency,code ,category,title,releasedate,content ,url) VALUES ('370' ,'".$code."','Press Releases','".base64_encode(serialize($title))."','".$datetime."','".base64_encode(serialize($content))."','".$link."')";
        $DB->exec($sql);
        if($key == 10)
        {break;}
      }
      else {

          $sql3="SELECT * FROM app_ret WHERE agency LIKE '370' AND category LIKE 'Press Releases' ORDER BY releasedate DESC ";
          $re = $DB->query($sql3);
          $press = $re->fetchAll(PDO::FETCH_ASSOC);
          foreach ($press as $key => $value)
           {
            $col="collapse".$key;
            ?>
            <div class="accordion" id="accordionExample">
             <div class="card">
                <div class="card-header" id="headingOne">
                  <h2 class="mb-0">
                    <button style='color: black' class="btn btn-link collapsed text-left" type="button" data-toggle="collapse" data-target="#<?php echo $col; ?>" aria-expanded="true" aria-controls="collapseOne">
                      <?php echo "<h5>".unserialize(base64_decode($value['title']))."</h5>";
                      echo "Code: ".$value['code']."<br /><br />";
                      echo "<p class='text-muted'>Date: ".$value['releasedate']."</p>";
                       ?>
                    </button>
                  </h2>
                </div>
                <div id="<?php echo $col; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                  <div class="card-body">
                    <?php
                		  echo unserialize(base64_decode($value['content']));
                      echo "Link : <a href='".$value['url']."' >".$value['url']."</a>";
                    ?>
                  </div>
                </div>
                </div>
              </div>
              <br>
            <?php

          }
          break;
        }
      }
    }
    elseif ($_GET['type']== 'sat')
    {
      $html = file_get_html('https://www.cftc.gov/PressRoom/SpeechesTestimony/index.htm');
      $body = $html->find('div[class="view-content"]',0)->find('tbody',0);
      $row = $body->find('tr');
      echo "<h4>Speeches and Testimony: </h4>";
      foreach ($row as $key => $value)
      {
        $date = $value->find('td',0)->plaintext;
        $date=str_replace("/", " ",$date);
        $date = trim($date," ");
        $explodeDate = explode(' ', $date);
        $datetime = date("Y-m-d H:i:s", strtotime(date($explodeDate[2].'-'.$explodeDate[0].'-'.$explodeDate[1]." 00:00:00")));

        $title = $value->find('td',1)->find('a',0)->plaintext;

        $che = $value->find('a',0)->href;
        $value->find('a',0)->href = "https://www.cftc.gov".$che;
        $url = $value->find('a',0)->href;

        // $code = trim($value->find('td',1)->plaintext," ");
        // $code = trim(substr($code, strlen($code)-8)," ");

        $content = file_get_html($url);
        $content = $content->find('div[class="region region-content"]',0);
        $content->find('span',0)->innertext="";
        $content->find('p',0)->innertext="";
        // $text = $content->find('h1',0)->innertext;
        foreach ($content->find('h1') as $key => $value) {
          $content->find('h1',$key)->innertext = "";
        }
        foreach ($content->find('h3') as $key => $value) {
          $content->find('h3',$key)->innertext = "";
        }
        $r=0;
        while($content->find('a',$r))
        {
               $ref = $content->find('a',$r)->href;
               $che = $content->find('a',$r)->plaintext;
               if(strpos($ref,"https")!==false || strpos($ref,"mailto")!==false || strpos($ref,"http")!==false || strpos($ref,"www")!==false ||strpos($ref,"file:")!==false)
               {

               }
               // elseif( strpos($che,"PDF")!==false){
               // $req_reg->find('a',$r)->href='https://www.fdic.gov/news/news/speeches/'.$ref;
               // $link=$req_reg->find('a',$r)->href;
               // }
               else
               {
                $content->find('a',$r)->href='https://www.cftc.gov'.$ref;
                $link=$content->find('a',$r)->href;
               }
             $r++;
        }
        $r=0;
        while($content->find('img',$r))
        {
               $ref = $content->find('img',$r)->src;
               if(strpos($ref,"https")!==false || strpos($ref,"http")!==false)
               {

               }
               // elseif( strpos($che,"PDF")!==false){
               // $req_reg->find('a',$r)->href='https://www.fdic.gov/news/news/speeches/'.$ref;
               // $link=$req_reg->find('a',$r)->href;
               // }
               else
               {
                $content->find('img',$r)->src='https://www.cftc.gov'.$ref;
                $link=$content->find('img',$r)->src;
               }
             $r++;
        }

        $sql2="SELECT * FROM app_ret WHERE title LIKE '".base64_encode(serialize($title))."' AND releasedate = '".$datetime."' ";
        $res=$DB->query($sql2);
        if($res->rowCount() == 0 ){
        $sql = "INSERT INTO app_ret(agency,category,title,releasedate,content ,url) VALUES ('370','Speeches & Testimony','".base64_encode(serialize($title))."','".$datetime."','".base64_encode(serialize($content))."','".$url."')";
        $DB->exec($sql);
        if($key == 10)
        {break;}
      }
      else {
        $sql3="SELECT * FROM app_ret WHERE agency LIKE '370' AND category LIKE 'Speeches & Testimony' ORDER BY releasedate DESC ";
          $re = $DB->query($sql3);
          $press = $re->fetchAll(PDO::FETCH_ASSOC);
          foreach ($press as $key => $value)
           {
            $col="collapse".$key;
            ?>
            <div class="accordion" id="accordionExample">
             <div class="card">
                <div class="card-header" id="headingOne">
                  <h2 class="mb-0">
                    <button style='color: black' class="btn btn-link collapsed text-left" type="button" data-toggle="collapse" data-target="#<?php echo $col; ?>" aria-expanded="true" aria-controls="collapseOne">
                      <?php echo "<h5>".unserialize(base64_decode($value['title']))."</h5>";
                      echo "<p class='text-muted'>Date: ".$value['releasedate']."</p>";
                       ?>
                    </button>
                  </h2>
                </div>
                <div id="<?php echo $col; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                  <div class="card-body">
                    <?php
			                echo unserialize(base64_decode($value['content']));
                      echo "Link : <a href='".$value['url']."' >".$value['url']."</a>";
                    ?>
                  </div>
                </div>
                </div>
              </div>
              <br>
            <?php

          }
          break;
        }
      }
    }

    elseif ($_GET['type']== 'ev')
    {
      $html = file_get_html('https://www.cftc.gov/PressRoom/Events');
      $body = $html->find('div[class="view-content"]',0)->find('tbody',0);

      $row = $body->find('tr');

      foreach ($row as $key => $value)
      {
        $date = $value->find('td',0)->plaintext;
        $date=str_replace("/", " ",$date);
        $date = trim($date," ");
        $explodeDate = explode(' ', $date);
        $datetime = date("Y-m-d H:i:s", strtotime(date($explodeDate[2].'-'.$explodeDate[0].'-'.$explodeDate[1]." 00:00:00")));

        $title = $value->find('td',1)->find('a',0)->plaintext;

        $che = $value->find('a',0)->href;
        $value->find('a',0)->href = "https://www.cftc.gov".$che;
        $url = $value->find('a',0)->href;

        // $code = trim($value->find('td',1)->plaintext," ");
        // $code = trim(substr($code, strlen($code)-8)," ");

        $content = file_get_html($url);
        $content = $content->find('div[class="region region-content"]',0);

        // $text = $content->find('h1',0)->innertext;
        foreach ($content->find('h1') as $key => $value) {
          $content->find('h1',$key)->innertext = "";
        }

        $r=0;
        while($content->find('a',$r))
        {
               $ref = $content->find('a',$r)->href;
               $che = $content->find('a',$r)->plaintext;
               if(strpos($ref,"https")!==false || strpos($ref,"mailto")!==false || strpos($ref,"http")!==false || strpos($ref,"www")!==false ||strpos($ref,"file:")!==false)
               {

               }
               // elseif( strpos($che,"PDF")!==false){
               // $req_reg->find('a',$r)->href='https://www.fdic.gov/news/news/speeches/'.$ref;
               // $link=$req_reg->find('a',$r)->href;
               // }
               else
               {
                $content->find('a',$r)->href='https://www.cftc.gov'.$ref;
                $link=$content->find('a',$r)->href;
               }
             $r++;
        }
        $r=0;
        while($content->find('img',$r))
        {
               $ref = $content->find('img',$r)->src;
               if(strpos($ref,"https")!==false || strpos($ref,"http")!==false)
               {

               }
               // elseif( strpos($che,"PDF")!==false){
               // $req_reg->find('a',$r)->href='https://www.fdic.gov/news/news/speeches/'.$ref;
               // $link=$req_reg->find('a',$r)->href;
               // }
               else
               {
                $content->find('img',$r)->src='https://www.cftc.gov'.$ref;
                $link=$content->find('img',$r)->src;
               }
             $r++;
        }

        $sql2="SELECT * FROM app_ret WHERE title LIKE '".base64_encode(serialize($title))."' AND releasedate = '".$datetime."' ";
        $res=$DB->query($sql2);
        if($res->rowCount() == 0 ){
        $sql = "INSERT INTO app_ret (agency,category,title,releasedate,content ,url) VALUES ('370','Events','".base64_encode(serialize($title))."','".$datetime."','".base64_encode(serialize($content))."','".$url."')";
        $DB->exec($sql);
        if($key == 10)
        {break;}
      }
      else {
        $sql3="SELECT * FROM app_ret WHERE agency LIKE '370' AND category LIKE 'Events' ORDER BY releasedate DESC ";
          $re = $DB->query($sql3);
          $press = $re->fetchAll(PDO::FETCH_ASSOC);
          foreach ($press as $key => $value)
           {
            $col="collapse".$key;
            ?>
            <div class="accordion" id="accordionExample">
             <div class="card">
                <div class="card-header" id="headingOne">
                  <h2 class="mb-0">
                    <button style='color: black' class="btn btn-link collapsed text-left" type="button" data-toggle="collapse" data-target="#<?php echo $col; ?>" aria-expanded="true" aria-controls="collapseOne">
                      <?php echo "<h5>".unserialize(base64_decode($value['title']))."</h5>";
                      echo "<p class='text-muted'>Date: ".$value['releasedate']."</p>";
                       ?>
                    </button>
                  </h2>
                </div>
                <div id="<?php echo $col; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                  <div class="card-body">
                    <?php
                      echo unserialize(base64_decode($value['content']))."<br />";
                      echo "Link : <a href='".$value['url']."' >".$value['url']."</a>";
                    ?>
                  </div>
                </div>
                </div>
              </div>
              <br>
            <?php

          }
          break;
        }
      }
    }

    elseif ($_GET['type']== 'pd')
    {
      $html = file_get_html('https://www.cftc.gov/Media/Podcast/index.htm');
      $body = $html->find('div[class="view-content"]',0);

      $row = $body->find('div[class="views-row"]');

      foreach ($row as $key => $value)
      {
        $date = $value->find('div[class="field-content"]',0)->plaintext;
        $date=str_replace("/", " ",$date);
        $date = trim($date," ");
        $explodeDate = explode(' ', $date);
        $datetime = date("Y-m-d H:i:s", strtotime(date($explodeDate[2].'-'.$explodeDate[0].'-'.$explodeDate[1]." 00:00:00")));

        $title = $value->find('div[class="views-field views-field-title"]',0)->plaintext;

        $url = $value->find('div[class="views-field views-field-field-audio-link"]',0)->find('a',0)->href;

        $content = $value->find('div[class="views-field views-field-body"]',0);

        $r=0;
        while($content->find('a',$r))
        {
               $ref = $content->find('a',$r)->href;
               $che = $content->find('a',$r)->plaintext;
               if(strpos($ref,"https")!==false || strpos($ref,"mailto")!==false || strpos($ref,"http")!==false || strpos($ref,"www")!==false ||strpos($ref,"file:")!==false)
               {

               }
               else
               {
                $content->find('a',$r)->href='https://www.cftc.gov'.$ref;
                $link=$content->find('a',$r)->href;
               }
             $r++;
        }

        $sql2="SELECT * FROM app_ret WHERE title LIKE '".base64_encode(serialize($title))."' AND releasedate = '".$datetime."' ";
        $res=$DB->query($sql2);
        if($res->rowCount() == 0 ){
        $sql = "INSERT INTO app_ret (agency,category,title,releasedate,content ,url) VALUES ('370','Podcasts','".base64_encode(serialize($title))."','".$datetime."','".base64_encode(serialize($content))."','".$url."')";
        $DB->exec($sql);
        if($key == 10)
        {break;}
      }
      else {
        $sql3="SELECT * FROM app_ret WHERE agency LIKE '370' AND category LIKE 'Podcasts' ORDER BY releasedate DESC ";
          $re = $DB->query($sql3);
          $press = $re->fetchAll(PDO::FETCH_ASSOC);
          foreach ($press as $key => $value)
           {
            $col="collapse".$key;
            ?>
            <div class="accordion" id="accordionExample">
             <div class="card">
                <div class="card-header" id="headingOne">
                  <h2 class="mb-0">
                    <button style='color: black' class="btn btn-link collapsed text-left" type="button" data-toggle="collapse" data-target="#<?php echo $col; ?>" aria-expanded="true" aria-controls="collapseOne">
                      <?php echo "<h5>".unserialize(base64_decode($value['title']))."</h5>";
                      echo "<p class='text-muted'>Date: ".$value['releasedate']."</p>";
                       ?>
                    </button>
                  </h2>
                </div>
                <div id="<?php echo $col; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                  <div class="card-body">
                    <?php
                      echo unserialize(base64_decode($value['content']))."<br />";
                      echo "Link : <a href='".$value['url']."' >".$value['url']."</a>";
                    ?>
                  </div>
                </div>
                </div>
              </div>
              <br>
            <?php

          }
          break;
        }
      }
    }

    else{
    ?>
    <li><a href="<?php echo $APP->BASEURL ?>/index.php?ID=19&scrape=cftc&type=pr">Press Releases</a></li>
    <li><a href="<?php echo $APP->BASEURL ?>/index.php?ID=19&scrape=cftc&type=sat">Speeches & Testimony</a></li>
    <li><a href="<?php echo $APP->BASEURL ?>/index.php?ID=19&scrape=cftc&type=ev">Events</a></li>
    <li><a href="<?php echo $APP->BASEURL ?>/index.php?ID=19&scrape=cftc&type=pd">Podcasts</a></li>
    <?php


  }
  echo "</div>";
  }

  elseif ($_GET['scrape'] == 'hud')
  {
    echo "<br><h3>DEPARTMENT OF HOUSING AND URBAN DEVELOPMENT</h3>";
    echo "<br><br>";

    echo "<div class='container'>";
    if ($_GET['type']=='pr')
    { echo "<h5>Press Releases: </h5><br />";
      $html = file_get_html('https://www.hud.gov/press');
      $body = $html->find('div[id="po-first-sm-col"]',0);
      $row = $body->find('div[class="po-column-text"]');

      foreach ($row as $key => $value)
      {
        $date = $value->find('div[id="arrow_pr_oval"]',0)->plaintext;
        $date=str_replace("/", " ",$date);
        $date = trim($date," ");
        $explodeDate = explode(' ', $date);
        $datetime = date("Y-m-d H:i:s", strtotime(date($explodeDate[2].'-'.$explodeDate[0].'-'.$explodeDate[1]." 00:00:00")));

        $title = $value->find('a',0)->plaintext;

        $che = $value->find('a',0)->href;
        $value->find('a',0)->href = "https://www.hud.gov".$che;
        $url = $value->find('a',0)->href;

        $content = file_get_html($url);

        $code = $content->find('span[class="easy-breadcrumb_segment easy-breadcrumb_segment-title"]',0)->plaintext;

        $content = $content->find('div[class="field-items"]',0);

        $r=0;
        while($content->find('a',$r))
        {
               $ref = $content->find('a',$r)->href;
               $che = $content->find('a',$r)->plaintext;
               if(strpos($ref,"https")!==false || strpos($ref,"mailto")!==false || strpos($ref,"http")!==false || strpos($ref,"www")!==false)
               {

               }
               // elseif( strpos($che,"PDF")!==false){
               // $req_reg->find('a',$r)->href='https://www.fdic.gov/news/news/speeches/'.$ref;
               // $link=$req_reg->find('a',$r)->href;
               // }
               else
               {
                $content->find('a',$r)->href='https://www.hud.gov'.$ref;
                $link=$content->find('a',$r)->href;
               }
             $r++;
        }
        $r=0;
        while($content->find('img',$r))
        {
               $ref = $content->find('img',$r)->src;
               if(strpos($ref,"https")!==false || strpos($ref,"http")!==false)
               {

               }
               // elseif( strpos($che,"PDF")!==false){
               // $req_reg->find('a',$r)->href='https://www.fdic.gov/news/news/speeches/'.$ref;
               // $link=$req_reg->find('a',$r)->href;
               // }
               else
               {
                $content->find('img',$r)->src='https://www.hud.gov'.$ref;
                $link=$content->find('img',$r)->src;
               }
             $r++;
        }

        $sql2="SELECT * FROM app_agencies WHERE title LIKE '".serialize(base64_encode($title))."' AND releasedate = '".$datetime."' ";
        $res=$DB->query($sql2);
        if($res->rowCount() == 0 ){
        $sql = "INSERT INTO app_agencies (agency,code ,category,title,releasedate,content ,url) VALUES ('HUD' ,'".$code."','Press Releases','".serialize(base64_encode($title))."','".$datetime."','".serialize(base64_encode($content))."','".$url."')";
        $DB->exec($sql);
        if($key == 30)
        {break;}
      }
      else {
        $sql3="SELECT * FROM app_agencies WHERE agency LIKE 'HUD' AND category LIKE 'Press Releases' ORDER BY releasedate DESC ";
          $re = $DB->query($sql3);
          $press = $re->fetchAll(PDO::FETCH_ASSOC);
          foreach ($press as $key => $value)
           {
            $col="collapse".$key;
            ?>
            <div class="accordion" id="accordionExample">
             <div class="card">
                <div class="card-header" id="headingOne">
                  <h2 class="mb-0">
                    <button style='color: black' class="btn btn-link collapsed text-left" type="button" data-toggle="collapse" data-target="#<?php echo $col; ?>" aria-expanded="true" aria-controls="collapseOne">
                      <?php echo "<h5>".base64_decode(unserialize($value['title']))."</h5>";
                      echo "<p class='text-muted'>Date: ".$value['releasedate']."</p>";
                      echo "<p class='text-muted'>Code: ".$value['code']."</p>";
                       ?>
                    </button>
                  </h2>
                </div>
                <div id="<?php echo $col; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                  <div class="card-body">
                    <?php
                      echo base64_decode(unserialize($value['content']))."<br />";
                      echo "Link : <a href='".$value['url']."' >".$value['url']."</a>";
                    ?>
                  </div>
                </div>
                </div>
              </div>
              <br>
            <?php

          }
          break;
        }
      }
    }

    elseif ($_GET['type']=='test')
    {
      echo "<h5>Testimonies: </h5><br />";
        $html = file_get_html('https://www.hud.gov/press');
        $body = $html->find('div[id="po-second-sm-col"]',0);
        $row = $body->find('div[class="po-column-text"]');

        foreach ($row as $key => $value)
        {
          $date = $value->find('div[id="arrow_pr_oval"]',0)->plaintext;
          $date=str_replace("/", " ",$date);
          $date = trim($date," ");
          $explodeDate = explode(' ', $date);
          $datetime = date("Y-m-d H:i:s", strtotime(date($explodeDate[2].'-'.$explodeDate[0].'-'.$explodeDate[1]." 00:00:00")));

          $title = $value->find('a',0)->plaintext;

          $url = $value->find('a',0)->href;
          if(strpos($url,'https')!==false)
          {

          }
          else
          {
            $url ="https://www.hud.gov".$url;
          }

          $sql2="SELECT * FROM app_agencies WHERE title LIKE '".serialize(base64_encode($title))."' AND releasedate = '".$datetime."' ";
          $res=$DB->query($sql2);
          if($res->rowCount() == 0 )
          {
          $sql = "INSERT INTO app_agencies (agency,category,title,releasedate,url) VALUES ('HUD','Testimonies','".serialize(base64_encode($title))."','".$datetime."','".$url."')";
          $DB->exec($sql);
          if($key == 30)
          {break;}
          }
        else {
          $sql3="SELECT * FROM app_agencies WHERE agency LIKE 'HUD' AND category LIKE 'Testimonies' ORDER BY releasedate DESC ";
            $re = $DB->query($sql3);
            $press = $re->fetchAll(PDO::FETCH_ASSOC);
            foreach ($press as $key => $value)
             {
              $col="collapse".$key;
              ?>
              <div class="accordion" id="accordionExample">
               <div class="card">
                  <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                      <button style='color: black' class="btn btn-link collapsed text-left" type="button" data-toggle="collapse" data-target="#<?php echo $col; ?>" aria-expanded="true" aria-controls="collapseOne">
                        <?php echo "<h5>".base64_decode(unserialize($value['title']))."</h5>";
                        echo "<p class='text-muted'>Date: ".$value['releasedate']."</p>";
                         ?>
                      </button>
                    </h2>
                  </div>
                  <div id="<?php echo $col; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">
                      <?php
                        echo base64_decode(unserialize($value['content']))."<br />";
                        echo "Testimony : <a href='".$value['url']."' >".$value['url']."</a>";
                      ?>
                    </div>
                  </div>
                  </div>
                </div>
                <br>
              <?php

            }
            break;
          }
        }
    }
    elseif ($_GET['type']=='srs') {
      echo "<h5>Speeches, Remarks, Statements: </h5><br />";
        $html = file_get_html('https://www.hud.gov/press');
        $body = $html->find('div[id="po-third-sm-col"]',0);
        $row = $body->find('div[class="po-column-text"]');

        foreach ($row as $key => $value)
        {
          $date = $value->find('div[id="arrow_pr_oval"]',0)->plaintext;
          $date=str_replace("/", " ",$date);
          $date = trim($date," ");
          $explodeDate = explode(' ', $date);
          $datetime = date("Y-m-d H:i:s", strtotime(date($explodeDate[2].'-'.$explodeDate[0].'-'.$explodeDate[1]." 00:00:00")));

          $title = $value->find('a',0)->plaintext;

          $url = $value->find('a',0)->href;
          if(strpos($url,'https')!==false)
          {

          }
          else
          {
            $url ="https://www.hud.gov".$url;
          }

          $content = file_get_html($url);

          $code = $content->find('span[class="easy-breadcrumb_segment easy-breadcrumb_segment-title"]',0)->plaintext;

          $content = $content->find('div[class="field-items"]',0);

          $r=0;
          while($content->find('a',$r))
          {
                 $ref = $content->find('a',$r)->href;
                 $che = $content->find('a',$r)->plaintext;
                 if(strpos($ref,"https")!==false || strpos($ref,"mailto")!==false || strpos($ref,"http")!==false || strpos($ref,"www")!==false)
                 {

                 }
                 // elseif( strpos($che,"PDF")!==false){
                 // $req_reg->find('a',$r)->href='https://www.fdic.gov/news/news/speeches/'.$ref;
                 // $link=$req_reg->find('a',$r)->href;
                 // }
                 else
                 {
                  $content->find('a',$r)->href='https://www.hud.gov'.$ref;
                  $link=$content->find('a',$r)->href;
                 }
               $r++;
          }
          $r=0;
          while($content->find('img',$r))
          {
                 $ref = $content->find('img',$r)->src;
                 if(strpos($ref,"https")!==false || strpos($ref,"http")!==false)
                 {

                 }
                 // elseif( strpos($che,"PDF")!==false){
                 // $req_reg->find('a',$r)->href='https://www.fdic.gov/news/news/speeches/'.$ref;
                 // $link=$req_reg->find('a',$r)->href;
                 // }
                 else
                 {
                  $content->find('img',$r)->src='https://www.hud.gov'.$ref;
                  $link=$content->find('img',$r)->src;
                 }
               $r++;
          }

          $sql2="SELECT * FROM app_agencies WHERE title LIKE '".serialize(base64_encode($title))."' AND releasedate = '".$datetime."' ";
          $res=$DB->query($sql2);
          if($res->rowCount() == 0 )
          {
          $sql = "INSERT INTO app_agencies (agency,code,category,title,content,releasedate,url) VALUES ('HUD','".$code."','Speeches,Remarks,Statements','".serialize(base64_encode($title))."','".serialize(base64_encode($content))."','".$datetime."','".$url."')";
          $DB->exec($sql);
          if($key == 30)
          {break;}
          }
        else {
          $sql3="SELECT * FROM app_agencies WHERE agency LIKE 'HUD' AND category LIKE 'Speeches,Remarks,Statements' ORDER BY releasedate DESC ";
            $re = $DB->query($sql3);
            $press = $re->fetchAll(PDO::FETCH_ASSOC);
            foreach ($press as $key => $value)
             {
              $col="collapse".$key;
              ?>
              <div class="accordion" id="accordionExample">
               <div class="card">
                  <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                      <button style='color: black' class="btn btn-link collapsed text-left" type="button" data-toggle="collapse" data-target="#<?php echo $col; ?>" aria-expanded="true" aria-controls="collapseOne">
                        <?php echo "<h5>".base64_decode(unserialize($value['title']))."</h5>";
                        echo "<p class='text-muted'>Date: ".$value['releasedate']."</p>";
                        echo "<p class='text-muted'>Code: ".$value['code']."</p>";
                         ?>
                      </button>
                    </h2>
                  </div>
                  <div id="<?php echo $col; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">
                      <?php
                        echo base64_decode(unserialize($value['content']))."<br />";
                        echo "Link : <a href='".$value['url']."' >".$value['url']."</a>";
                      ?>
                    </div>
                  </div>
                  </div>
                </div>
                <br>
              <?php

            }
            break;
          }
        }
    }

    else{
    ?>
    <li><a href="<?php echo $APP->BASEURL ?>/index.php?ID=19&scrape=hud&type=pr">Press Releases</a></li>
    <li><a href="<?php echo $APP->BASEURL ?>/index.php?ID=19&scrape=hud&type=test">Testimonies</a></li>
    <li><a href="<?php echo $APP->BASEURL ?>/index.php?ID=19&scrape=hud&type=srs">Speeches, Remarks, Statements</a></li>
    <?php
  }
  echo "</div>";
  }

elseif ($_GET['scrape']=='nych')
{
  echo "<br><h3>NYC Housing Authority</h3>";
  echo "<br><br>";

  echo "<div class='container'>";
  if ($_GET['type']=='pr')
  {
    echo "<h5>Speeches, Remarks, Statements: </h5><br />";
      $html = file_get_html('https://www1.nyc.gov/site/nycha/about/press/press-releases.page');
      $body = $html->find('div[class="span6 about-description"]',0);
      $row = $body->find('p');

      foreach ($row as $key => $value)
      {
        $date = $value->find('i',0)->plaintext;
        $pos = strpos($date,",");
        $dt = substr($date,$pos+2);
        $pos = strpos($dt, "," ,0)+6;
        $dt=str_replace(",","",trim(substr($dt,0,$pos)," "));
        $date=strtotime($dt);
        $cur_date=date("Y-m-d H:i:s",$date);

        $title = $value->find('a',0)->plaintext;

        $url = $value->find('a',0)->href;

        if(strpos($url,'https')!==false)
        {

        }
        else
        {
          $url ="https://www1.nyc.gov".$url;
        }

        $content = file_get_html($url);
        if(strpos($url,"news")!==false)
        {
          $content = $content->find('div[class="col-content"]',0);
        }
        else{
        $content = $content->find('div[class="span6 about-description"]',0);}

        $r=0;
        while($content->find('a',$r))
        {
               $ref = $content->find('a',$r)->href;
               $che = $content->find('a',$r)->plaintext;
               if(strpos($ref,"https")!==false || strpos($ref,"mailto")!==false || strpos($ref,"http")!==false || strpos($ref,"www")!==false)
               {

               }
               // elseif( strpos($che,"PDF")!==false){
               // $req_reg->find('a',$r)->href='https://www.fdic.gov/news/news/speeches/'.$ref;
               // $link=$req_reg->find('a',$r)->href;
               // }
               else
               {
                $content->find('a',$r)->href='https://www1.nyc.gov'.$ref;
                $link=$content->find('a',$r)->href;
               }
             $r++;
        }
        $r=0;
        while($content->find('img',$r))
        {
               $ref = $content->find('img',$r)->src;
               if(strpos($ref,"https")!==false || strpos($ref,"http")!==false)
               {

               }
               // elseif( strpos($che,"PDF")!==false){
               // $req_reg->find('a',$r)->href='https://www.fdic.gov/news/news/speeches/'.$ref;
               // $link=$req_reg->find('a',$r)->href;
               // }
               else
               {
                $content->find('img',$r)->src='https://www1.nyc.gov'.$ref;
                $link=$content->find('img',$r)->src;
               }
             $r++;
        }

        $sql2="SELECT * FROM app_agencies WHERE title LIKE '".base64_encode(serialize($title))."' AND releasedate = '".$cur_date."' ";
        $res=$DB->query($sql2);
        if($res->rowCount() == 0 )
        {
        $sql = "INSERT INTO app_agencies (agency,category,title,content,releasedate,url) VALUES ('NYCHA','Press Releases','".base64_encode(serialize($title))."','".base64_encode(serialize($content))."','".$cur_date."','".$url."')";
        $DB->exec($sql);
        if($key == 50)
        {break;}
        }
      else {
        $sql3="SELECT * FROM app_agencies WHERE agency LIKE 'NYCHA' AND category LIKE 'Press Releases' ORDER BY releasedate DESC LIMIT 15";
          $re = $DB->query($sql3);
          $press = $re->fetchAll(PDO::FETCH_ASSOC);
          foreach ($press as $key => $value)
           {
            $col="collapse".$key;
            ?>
            <div class="accordion" id="accordionExample">
             <div class="card">
                <div class="card-header" id="headingOne">
                  <h2 class="mb-0">
                    <button style='color: black' class="btn btn-link collapsed text-left" type="button" data-toggle="collapse" data-target="#<?php echo $col; ?>" aria-expanded="true" aria-controls="collapseOne">
                      <?php echo "<h5>".unserialize(base64_decode($value['title']))."</h5>";
                      echo "<p class='text-muted'>Date: ".$value['releasedate']."</p>";
                       ?>
                    </button>
                  </h2>
                </div>
                <div id="<?php echo $col; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                  <div class="card-body">
                    <?php
                      echo unserialize(base64_decode($value['content']))."<br />";
                      echo "Link : <a href='".$value['url']."' >".$value['url']."</a>";
                    ?>
                  </div>
                </div>
                </div>
              </div>
              <br>
            <?php

          }
          break;
        }
      }
    }

    elseif ($_GET['type']=='sat') {
      echo "<h5>Speeches and Testimonies: </h5><br />";
        $html = file_get_html('https://www1.nyc.gov/site/nycha/about/speeches-and-testimonies.page');
        $body = $html->find('div[class="span6 about-description"]',0);
        $row = $body->find('p');

        foreach ($row as $key => $value)
        {

          $date = $value->find('i',0)->plaintext;
          $pos = strpos($date,",");
          $dt = substr($date,$pos+2);
          $pos = strpos($dt, "," ,0)+6;
          $dt=str_replace(",","",trim(substr($dt,0,$pos)," "));
          $date=strtotime($dt);
          $cur_date=date("Y-m-d H:i:s",$date);

          $title = $value->find('a',0)->plaintext;

          $date = str_replace("." ," ",trim(substr($title,strlen($title)-9),")"));
          $date = trim($date," ");
          $explodeDate = explode(' ', $date);
          $datetime = date("Y-m-d H:i:s", strtotime(date($explodeDate[2].'-'.$explodeDate[0].'-'.$explodeDate[1]." 00:00:00")));

          $url = $value->find('a',0)->href;

          if(strpos($url,'https')!==false)
          {

          }
          else
          {
            $url ="https://www1.nyc.gov".$url;
          }

          $sql2="SELECT * FROM app_agencies WHERE title LIKE '".base64_encode(serialize($title))."' AND releasedate = '".$datetime."' ";
          $res=$DB->query($sql2);
          if($res->rowCount() == 0 )
          {
          $sql = "INSERT INTO app_agencies (agency,category,title,releasedate,url) VALUES ('NYCHA','Speeches and Testimonies','".base64_encode(serialize($title))."','".$datetime."','".$url."')";
          $DB->exec($sql);
          if($key == 5)
          {break;}
          }
        else {
          $sql3="SELECT * FROM app_agencies WHERE agency LIKE 'NYCHA' AND category LIKE 'Speeches and Testimonies' ORDER BY releasedate DESC";
            $re = $DB->query($sql3);
            $press = $re->fetchAll(PDO::FETCH_ASSOC);
            foreach ($press as $key => $value)
             {
              $col="collapse".$key;
              ?>
              <div class="accordion" id="accordionExample">
               <div class="card">
                  <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                      <button style='color: black' class="btn btn-link collapsed text-left" type="button" data-toggle="collapse" data-target="#<?php echo $col; ?>" aria-expanded="true" aria-controls="collapseOne">
                        <?php echo "<h5>".unserialize(base64_decode($value['title']))."</h5>";
                        echo "<p class='text-muted'>Date: ".$value['releasedate']."</p>";
                         ?>
                      </button>
                    </h2>
                  </div>
                  <div id="<?php echo $col; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">
                      <?php
                        echo "Link : <a href='".$value['url']."' >".$value['url']."</a>";
                      ?>
                    </div>
                  </div>
                  </div>
                </div>
                <br>
              <?php

            }
            break;
          }
        }
    }

    else{
    ?>
      <li><a href="<?php echo $APP->BASEURL ?>/index.php?ID=19&scrape=nych&type=pr">Press Releases</a></li>
      <li><a href="<?php echo $APP->BASEURL ?>/index.php?ID=19&scrape=nych&type=sat">Speeches & Testimony</a></li>
      <?php
      }
  echo "</div>";
}



  else
  {
      echo "check";
    }
 ?>

