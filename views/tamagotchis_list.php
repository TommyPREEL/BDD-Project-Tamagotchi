<?php
session_start();
require_once "../database/Tamagotchis.php";

$tamagotchis = Tamagotchis::getAllByUserId($_SESSION["user_id"]);
foreach($tamagotchis as $tamagotchi)
{


?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<link href="../style/style.css" rel="stylesheet">
<div class="container">
  <section class="mx-auto my-5" style="max-width: 23rem;">
      
    <div class="card">
      <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
        <img src="../media/baby_yoda.png" class="img-fluid" />
        <a href="#!">
          <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
        </a>
      </div>
      <div class="card-body">
        <h5 class="card-title font-weight-bold"><a><?php echo $tamagotchi['name']?></a></h5>
        <h6><a>Hungry</a></h6>
        <div class="w3-light-grey">
          <div id="myBar" class="w3-container w3-green w3-center" style="width:<?= $tamagotchi["hungry"]?>%"><?= $tamagotchi["hungry"]?>%</div>
        </div>
        <h6><a>Thirsty</a></h6>
        <div class="w3-light-grey">
          <div id="myBar" class="w3-container w3-green w3-center" style="width:<?= $tamagotchi["thirsty"]?>%"><?= $tamagotchi["thirsty"]?>%</div>
        </div>
        <h6><a>Sleep</a></h6>
        <div class="w3-light-grey">
          <div id="myBar" class="w3-container w3-green w3-center" style="width:<?= $tamagotchi["sleep"]?>%"><?= $tamagotchi["sleep"]?>%</div>
        </div>
        <h6><a>Boredom</a></h6>
        <div class="w3-light-grey">
          <div id="myBar" class="w3-container w3-green w3-center" style="width:<?= $tamagotchi["boredom"]?>%"><?= $tamagotchi["boredom"]?>%</div>
        </div>
        <p class="lead"><strong>Tonight's availability</strong></p>
        <ul class="list-unstyled list-inline d-flex justify-content-between">
          <li class="list-inline-item me-0">
            <div class="chip me-0">5:30PM</div>
          </li>
          <li class="list-inline-item me-0">
            <div class="chip bg-secondary text-white me-0">7:30PM</div>
          </li>
          <li class="list-inline-item me-0">
            <div class="chip me-0">8:00PM</div>
          </li>
          <li class="list-inline-item me-0">
            <div class="chip me-0">9:00PM</div>
          </li>
        </ul>
        <a href="#!" class="btn btn-link link-secondary p-md-1 mb-0">Button</a>
      </div>
    </div>
    
  </section>
</div>






<?php
}
?>


<div class="container">
  <p>Hungry</p>
  <div class="progressbar-wrapper">
    <div title="downloaded" class="progressbar mp4"><?php $tamagotchi["hungry"]?>
    </div>
  </div>

  <p>Thirsty</p>
  <div class="progressbar-wrapper">
    <div title="downloaded" class="progressbar mp4">100%
    </div>
  </div>

  <p>Hungry</p>
  <div class="progressbar-wrapper">
    <div title="downloaded" class="progressbar mp4">100%
    </div>
  </div>

  <p>Hungry</p>
  <div class="progressbar-wrapper">
    <div title="downloaded" class="progressbar mp4">100%
    </div>
  </div>
​
     
</div>

<p>musique.mp3</p>
     <div class="progressbar-wrapper">
      <div title="downloading" class="progressbar mp3">60%</div>
     </div>





     <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">


<div class="w3-light-grey">
  <div id="myBar" class="w3-container w3-green w3-center" style="width:<?= $tamagotchis[0]["hungry"]?>%"><?= $tamagotchis[0]["hungry"]?>%</div>
</div>
<br>







<button class="w3-button w3-green" onclick="move()">Click Me</button> 

</div>

<script>
function move() {
  var elem = document.getElementById("myBar");   
  var width = 20;
  var id = setInterval(frame, 10);
  function frame() {
    if (width >= 100) {
      clearInterval(id);
    } else {
      width++; 
      elem.style.width = width + '%'; 
      elem.innerHTML = width * 1  + '%';
    }
  }
}
</script>