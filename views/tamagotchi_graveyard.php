<?php
session_start();
require_once("../assets/include/head.php");
require_once("../assets/classes/Tamagotchis.php");
require_once("../assets/classes/DeadTamagotchis.php");

$tamagotchis = DeadTamagotchis::getAllDead($_SESSION["user_id"]);
if(count($tamagotchis) == 0)
{
  echo '<p class="d-flex justify-content-center">Aucun de vos Tamagotchis n\'est mort !</p>';
}

?>
<div class="d-flex flex-wrap align-items-start">

<?php foreach ($tamagotchis as $tamagotchi) { ?>
  <div class="container">
    <section class="mx-auto my-5">
        <div class="card">
          <div class="d-flex justify-content-center bg-image hover-overlay ripple" data-mdb-ripple-color="light">
            <img src="../assets/media/grave.png" class="img-fluid img-grave"/>
            <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
          </div>
          <div class="card-body">
            <h4 class="card-title font-weight-bold d-flex justify-content-center"><?php echo $tamagotchi['name']." (lv.".$tamagotchi['level'].")"?></h4>
            <span><h5>Creation Date : <?= $tamagotchi['creation_date'] ?></h5></span>
            <span><h5>Dead Date : <?= $tamagotchi['death_date'] ?></h5></span>
            <span><h5>Death Reason : <?= $tamagotchi['reason'] ?></h5></span>
          </div>
        </div>
    </section>
  </div>
<?php } ?>
</div>
<?php require("../assets/include/footer.php"); ?>