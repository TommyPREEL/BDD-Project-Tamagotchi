<?php
if(isset($_SESSION['error']))
{
  echo '<p id="error" class="d-flex justify-content-center error-form-create">'.$_SESSION['error'].'</p>';
  unset($_SESSION['error']);
}
?>