<?php
session_start();
require_once "../database/Tamagotchis.php";
include 'header.php';

$tamagotchis = Tamagotchis::getAllByUserId($_SESSION["user_id"]);
?>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<link href="../style/style.css" rel="stylesheet">

<a href="tamagotchi_create.php">
  <button type="button" class="btn btn-outline-success d-flex justify-content-center create-tamagotchi">Create a new Tamagotchi ! <span class="material-symbols-outlined">pets</span></button>
</a>

<?php
if($tamagotchis == null){
  header("Location: tamagotchi_create.php");
  exit();
}else{
?>
<div class="d-flex flex-wrap align-items-start">
<?php
foreach($tamagotchis as $tamagotchi)
{


?>


  <div class="container">
    <section class="mx-auto my-5">
      <a href="tamagotchi_profil.php?tamagotchi_id=<?=$tamagotchi['id'];?>" >
        <div class="card">
            <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
              <img src="../media/baby_yoda.png" class="img-fluid" />
              <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
            </div>
            <div class="card-body">
              <h4 class="card-title font-weight-bold d-flex justify-content-center"><?php echo $tamagotchi['name']." (lv.".$tamagotchi['level'].")"?></h4>
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
            </div>
        </div>
      </a>
    </section>
  </div>







<?php
}}
?>

</div>


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