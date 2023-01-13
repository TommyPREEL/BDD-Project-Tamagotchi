<?php if (isset($_SESSION["user_id"])) { ?>
<nav class="d-flex align-items-center justify-content-center navbar navbar-expand-lg navbar-light bg-light nav-bar">
    <div class="d-flex align-items-center justify-content-center">
        <ul class="navbar-nav">
            <!-- <li class="nav-item">
                <a class="nav-link" href="../views/tamagotchis_list.php"><img class="img-tamagotchi" src="../assets/media/tamagotchi.png"/></a>
            </li> -->
            <li class="nav-item">
                <a class="nav-link d-flex" href="../views/tamagotchis_list.php">Tamagotchis List</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../views/tamagotchi_graveyard.php">Graveyard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../actions/action_logout.php">Deconnexion</a>
            </li>
        </ul>
    </div>
</nav>
<?php } ?>