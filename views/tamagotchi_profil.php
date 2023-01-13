<?php
session_start();
require_once("../assets/include/head.php");
require_once("../assets/classes/Tamagotchis.php");
require_once("../assets/classes/AliveTamagotchis.php");
require_once("../assets/classes/DeadTamagotchis.php");
require_once("../assets/classes/LifeOfTamagotchis.php");
$_SESSION['tamagotchi_id'] = $_GET['tamagotchi_id'];

$deadTamagotchi = DeadTamagotchis::getTamagotchiDead($_SESSION["user_id"],$_GET['tamagotchi_id']);
$tamagotchi = AliveTamagotchis::getInfoTamagotchiById($_SESSION["user_id"], $_GET['tamagotchi_id']);
$data = LifeOfTamagotchis::getJSONInfoTamagotchiById($_GET['tamagotchi_id']);
$data = json_encode($data);


if($deadTamagotchi != null)
{
    header('Location: tamagotchis_list.php');
    exit();
}
?>

<div class="toggle-buttons">
    <button id="toggle-button-bars" class="btn btn-light toggle toggle-selected">Stats</button>
    <button id="toggle-button-lines" class="btn toggle btn-light">History</button>
</div>

<div class="d-flex flex-row">

    <div class="container">
        <div class="card col">
        
            <div id="stats-bars" style="display: block;">
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
        <div id="stats-history" style="display: none;">
            <canvas id="tamagotchis_chart"></canvas>
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
  
<script>


var button_bars = document.getElementById("toggle-button-bars");
var button_lines = document.getElementById("toggle-button-lines");
var bars = document.getElementById("stats-bars");
var lines = document.getElementById("stats-history");

button_lines.addEventListener("click", function() {
    bars.style.display = "none";
    lines.style.display = "block";
    button_bars.classList.remove("toggle-selected");
    button_lines.classList.add("toggle-selected");
  });
  button_bars.addEventListener("click", function() {
    bars.style.display = "block";
    lines.style.display = "none";
    button_lines.classList.remove("toggle-selected");
    button_bars.classList.add("toggle-selected");
});


    let data = JSON.parse('<?php echo $data; ?>');
    const columnName = ['hungry', 'drink', 'sleep', 'boredom']
    for(key in data) {
        if(Number(key) || Number(key) === 0)
            delete data[key];
        if(columnName.includes(key))
            data[key] = JSON.parse(data[key])
    }



    const context = document.getElementById('tamagotchis_chart');
  
    chart = new Chart(context, {
        type: 'line',
        data: {
            labels: data.drink.map((_, index) => index),
            datasets: [{
            label: 'Drink',
            data: data.drink,
            borderWidth: 2,
            pointBackgroundColor: 'rgba(0,0,0,0)',
            pointBorderColor: 'rgba(0,0,0,0)',
            tension: 0.1,
            }, {
            label: 'Hungry',
            data: data.hungry,
            borderWidth: 2,
            pointBackgroundColor: 'rgba(0,0,0,0)',
            pointBorderColor: 'rgba(0,0,0,0)',
            tension: 0.1,
            }, {
            label: 'Sleep',
            data: data.sleep,
            borderWidth: 2,
            pointBackgroundColor: 'rgba(0,0,0,0)',
            pointBorderColor: 'rgba(0,0,0,0)',
            tension: 0.1,
            }, {
            label: 'Boredom',
            data: data.boredom,
            borderWidth: 2,
            pointBackgroundColor: 'rgba(0,0,0,0)',
            pointBorderColor: 'rgba(0,0,0,0)',
            tension: 0.1,
            }]
        },
        options: {
            responsive: true,
            plugins: {
            title: {
                display: true,
                text: "Tamagotchi's Adventure",
                font: {size: 24}
            },
            subtitle: {
                display: true,
                text: "Statistics",
                font: {size: 9}
            }
            },
            scales: {
            y: {
                beginAtZero: true,
            },
            }
        }
    });
   </script>