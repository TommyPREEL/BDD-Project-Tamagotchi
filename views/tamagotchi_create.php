<?php 
session_start();
require("../assets/include/head.php");
?>

<div class="container">
  <section class="mx-auto my-5" style="max-width: 23rem;">
    <div class="card">
      <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
        <img src="../assets/media/baby_yoda.png" class="img-fluid" />

        <form name="form_create" id="form_create" action="../actions/action_create.php" method="post">
          <div class="form-group">
            <label for="name">Tamagotchi name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Hamtaro">
            <button type="submit" id="submit" name="submit" class="btn btn-outline-success d-flex justify-content-center" style="width:100%;"><span class="material-symbols-outlined">add_circle</span>Create a new Tamagotchi !</button>
          </div>
        </form>
    </div>
  </section>
</div>
<p id="error" class="d-flex justify-content-center error-form-create"></p>

<?php require("../assets/include/footer.php"); ?>