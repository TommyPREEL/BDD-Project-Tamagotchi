<?php
session_start();
include 'header.php';
require_once '../database/Tamagotchis.php';
$_SESSION['tamagotchi_id'] = $_GET['tamagotchi_id'];

$tamagotchi = Tamagotchis::getAllByTamagotchiId($_SESSION["user_id"], $_GET['tamagotchi_id']);
if($tamagotchi['dead_date'] != null)
{
    header('Location: tamagotchis_list.php');
    exit();
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<link href="../style/style.css" rel="stylesheet">

<div class="d-flex flex-row">

    <div class="container">

        <div class="card col">

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

    <div class="container">

        <div class="card col col-lg-12">

            <h4 class="card-title font-weight-bold d-flex justify-content-center"><a><?php echo $tamagotchi['name']?></a></h4>

            <h4 class="card-title font-weight-bold d-flex justify-content-center"><a><?php echo "Level : ".$tamagotchi['level']?></a></h4>


            <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">

                <img src="../media/baby_yoda.png" class="img-fluid" />
                <a href="#!">
                    <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                </a>

            </div>

        </div>

    </div>

    <div class="container">

        <div class="col col-lg-10">

            <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">

                <a href="tamagotchi_graveyard.php">
                <img src="../media/graveyard.jpg" class="img-fluid" />
                <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                </a>

            </div>

        </div>  

    </div>

</div>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

<div class="d-flex justify-content-center" style="width:100%;">
    <a href="../actions/action_tamagotchi.php?action=eat"><div class="d-flex action-card action-card-eat align-items-center justify-content-between"><span>Eat</span><span class="material-symbols-outlined">restaurant</span></div></a>
    <a href="../actions/action_tamagotchi.php?action=drink"><div class="d-flex action-card action-card-drink align-items-center justify-content-between"><span>Drink</span><span class="material-symbols-outlined">water_drop</span></div></a>
    <a href="../actions/action_tamagotchi.php?action=sleep"><div class="d-flex action-card action-card-sleep align-items-center justify-content-between"><span>Sleep</span><span class="material-symbols-outlined">bedtime</span></div></a>
    <a href="../actions/action_tamagotchi.php?action=play"><div class="d-flex action-card action-card-play align-items-center justify-content-between"><span>Play</span><span class="material-symbols-outlined">sports_basketball</span></div></a>
</div>



     <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">