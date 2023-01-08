<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<link href="../style/style.css" rel="stylesheet">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<?php
include 'header.php';
?>
  <div class="container">
    <section class="mx-auto my-5" style="max-width: 23rem;">
      <div class="card">
          <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
            <img src="../media/baby_yoda.png" class="img-fluid" />
            <a href="#!">
              <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
            </a>
            <form action="../actions/action_create.php" method="post">
                <div class="form-group">
                    <label for="name">Tamagotchi name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Hamtaro">
                    <button type="submit" class="btn btn-outline-success d-flex justify-content-center" style="width:100%;"><span class="material-symbols-outlined">add_circle</span>Create a new Tamagotchi !</button>
                </div>
            </form>
      </div>
    </section>
  </div>