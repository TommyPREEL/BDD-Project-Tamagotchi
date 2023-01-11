<?php
session_start();
require_once("../assets/include/head.php");
require_once("../assets/classes/Tamagotchis.php");

$tamagotchis = AliveTamagotchis::getAllByUserId($_SESSION["user_id"]);
var_dump($tamagotchis);die('list ligne 7');
?>

<a href="tamagotchi_create.php">
  <button type="button" class="btn btn-outline-success d-flex justify-content-center create-tamagotchi">Create a new Tamagotchi ! <span class="material-symbols-outlined">pets</span></button>
</a>

<?php
if($tamagotchis == null){
  header("Location: tamagotchi_create.php");
  exit();
}else{ ?>
<div class="d-flex flex-wrap align-items-start">
  <?php foreach($tamagotchis as $tamagotchi) { ?>
  <div class="container">
    <section class="mx-auto my-5">
      <a href="tamagotchi_profil.php?tamagotchi_id=<?=$tamagotchi['user_id'];?>" >
        <div class="card">
            <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
              <img src="../assets/media/baby_yoda.png" class="img-fluid" />
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
                <div id="myBar" class="w3-container w3-green w3-center" style="width:<?= $tamagotchi["drink"]?>%"><?= $tamagotchi["drink"]?>%</div>
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
  <?php }} ?>
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