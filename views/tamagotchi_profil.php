<?php
session_start();
require_once("../assets/include/head.php");
require_once("../assets/classes/Tamagotchis.php");
$_SESSION['tamagotchi_id'] = $_GET['tamagotchi_id'];

$tamagotchi = Tamagotchis::getAllByTamagotchiId($_SESSION["user_id"], $_GET['tamagotchi_id']);
if($tamagotchi['dead_date'] != null)
{
    header('Location: tamagotchis_list.php');
    exit();
}
?>

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
                <img src="../assets/media/baby_yoda.png" class="img-fluid" />
            </div>
        </div>
    </div>

    <div class="container">
        <div class="col col-lg-10">
            <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                <a href="tamagotchi_graveyard.php">
                    <img src="../assets/media/graveyard.jpg" class="img-fluid" />
                </a>
            </div>
        </div>  
    </div>
</div>

<div class="d-flex justify-content-center" style="width:100%;">
    <a href="../actions/action_tamagotchi.php?action=eat"><div class="d-flex action-card action-card-eat align-items-center justify-content-between"><span>Eat</span><span class="material-symbols-outlined">restaurant</span></div></a>
    <a href="../actions/action_tamagotchi.php?action=drink"><div class="d-flex action-card action-card-drink align-items-center justify-content-between"><span>Drink</span><span class="material-symbols-outlined">water_drop</span></div></a>
    <a href="../actions/action_tamagotchi.php?action=sleep"><div class="d-flex action-card action-card-sleep align-items-center justify-content-between"><span>Sleep</span><span class="material-symbols-outlined">bedtime</span></div></a>
    <a href="../actions/action_tamagotchi.php?action=play"><div class="d-flex action-card action-card-play align-items-center justify-content-between"><span>Play</span><span class="material-symbols-outlined">sports_basketball</span></div></a>
</div>

<?php require("../assets/include/footer.php"); ?>