<style media="screen">

    @media screen and (min-width: 1280px) {
      #chart-parent-div {
        width: 50% !important;
      }
    }

</style>
  <div class="text-focus-in container">
    <br>
    <ul class="breadcrumb">
        <li><a href="<?php echo $APP->BASEURL?>">Home</a> <span class="divider">/</span></li>
        <li class="active">Article List</li>
    </ul>
    <div class="row">
      <div class="col-md-12">
        <div class="card shadow-sm text-center">
          <div class="card-body" style="font-family: 'Quicksand', sans-serif; font-size: 2rem;">
            Articles list
            <br>
            <a class="blink-1 stretched-link" href="<?php echo $APP->BASEURL ?>/admin/article/index.php?page=1" class="btn btn-primary"><img src="https://img.icons8.com/ios/50/000000/nui2-filled.png"></a>
          </div>
        </div>
      </div>
    </div>
    <div class="text-center mt-5">
      <?php if ($_SESSION['USERID']==1) { ?>
      <h2>Graphical Representation</h2>
      <div class="w-100 mx-auto" id="chart-parent-div">
        <canvas id="myChart"style="width: 100%;"></canvas>
      </div>
      <br>
      <div class="row">
        <div class="col-lg-6 text-left text-md-right">
          <?php $sql="SELECT * FROM app_article WHERE status='3' ";
          $res=$DB->query($sql);
          echo "Articles published : ".$res->rowCount()."";
           ?>
        </div>
        <div class="col-lg-6 text-left">
          <?php $sql="SELECT * FROM app_article WHERE status='1' ";
          $res=$DB->query($sql);
          echo "Articles submitted : ".$res->rowCount();
           ?>
        </div>
      </div>
    <?php } ?>
    </div>

  </div>
<?php
  $obj=new viewarticle();

  $months_to_show = 6;
  $date = '';
  $article_count = '';
  for ($i=0; $i < $months_to_show+1 ; $i++) {
      $date .= "'".date("M Y", strtotime("-".$i." months"))."',";
      if ($i==0) {
          $count = $obj->countart((date("M Y", strtotime("+".(1)." months"))), (date("M Y", strtotime("-".($i)." months")))); //for initial case, the period between the current month and next month.
      } else {
          $count = $obj->countart((date("M Y", strtotime("-".($i-1)." months"))), (date("M Y", strtotime("-".($i)." months"))));
      }
      $article_count .= $count.',';
  }
  $article_count = trim($article_count, ',');
?>

<script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $date; ?>],
        datasets: [{
            label: 'No of articles',
            data: [<?php echo $article_count ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>
