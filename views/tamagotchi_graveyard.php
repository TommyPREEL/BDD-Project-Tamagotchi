<?php
session_start();
require_once "../database/Tamagotchis.php";
include 'header.php';

$tamagotchis = Tamagotchis::getAllDead($_SESSION["user_id"]);
?>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<link href="../style/style.css" rel="stylesheet">


<div class="d-flex flex-wrap align-items-start">
<?php
foreach($tamagotchis as $tamagotchi)
{
?>
  <div class="container">
    <section class="mx-auto my-5">
        <div class="card">
            <div class="d-flex justify-content-center bg-image hover-overlay ripple" data-mdb-ripple-color="light">
              <img src="../media/grave.png" class="img-fluid img-grave"/>
              <!-- <div class="teste"></div> -->
              <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
            </div>
            <div class="card-body">
                <h4 class="card-title font-weight-bold d-flex justify-content-center"><?php echo $tamagotchi['name']." (lv.".$tamagotchi['level'].")"?></h4>
                <span><h5>Creation Date : <?= $tamagotchi['creation_date'] ?></h5></span>
                <span><h5>Dead Date : <?= $tamagotchi['dead_date'] ?></h5></span>
                <span><h5>Death Reason : <?= $tamagotchi['death_reason'] ?></h5></span>
              </div>
            </div>
        </div>
    </section>
  </div>
<?php
}
?>
</div>