<?php
    require_once('identifier.php');
    require_once("connexiondb.php");
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/stil.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Envoi</title>
</head>
<body>
     <?php include("menu1.php")  ?>
     <div class="container">
<form  class="d-flex justify-content-center" action="Facture.php" method="get" id="contact_form">
  <fieldset > 
    <legend class="p-5"><h1>Information sur votre commande :</h1></legend>
    <fieldset class="row mb-3 border border-1 border-primary m-5 p-2">
    <legend class="col-form col-sm-3 ">Type D'envoi</legend>
    <div class="col-sm-5 ">
      <div class="form-check ">
        <input class="form-check-input" type="radio"  name="type_envoi" id="Colis" value="CL" required>
        <label class="form-check-label" for="Colis">
        <i class="fa-solid fa-box"></i>Colis
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="type_envoi" id="Courrier" value="CR" >
        <label class="form-check-label" for="Courrier">
        <i class="fa-solid fa-envelope"></i>Courrier
        </label>
      </div>
  </fieldset>
    <fieldset class="row mb-3 border border-1 border-primary m-5 p-2">
    <legend class="col-form col-sm-3 ">Fragilité</legend>
    <div class="col-sm-5">
      <div class="form-check">
        <input class="form-check-input" type="radio" name="Fragel" id="Fragel" value="Fragile">
        <label class="form-check-label" for="Fragel">
        Fragile
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio"  name="Fragel" id="incassable" value="incassable" required>
        <label class="form-check-label" for="incassable">
        incassable
        </label>
      </div>
  </fieldset>
  <fieldset class="row mb-3  m-5"   >
    <legend class="col-sm-3">Poids</legend>
    <div class="col w-25" >
    <input style="max-width: 100px;" id="Pois" name="Pois" type="number" class="form-control" placeholder="(Kg)" step="0.01" min="0" max="5">
    </div>
  </fieldset></form>
  <div class="form-group row  p-5" >
    <div class="col-sm-10">
      <button type="submit" class="btn btn-outline-success" >Calculer Le mantant  <i class="fa-solid fa-calculator"></i></button>
    </div>
  </div>
  <?php  if (isset($_SESSION['tottaxe'])) 
  { ?>
  <div class="alert alert-secondary" role="alert">
  <?php 
    echo " Vous pouvez Payer    :". $_SESSION['tottaxe']. "  DH ";
  } 
 ?>
</div>

<?php  if (isset($_SESSION['tottaxe'])) 
  { ?>
<div class="form-group row  p-5" >
    <div class="col-sm-10">
      <a style="text-decoration:none;" href="dest.php">Suivant<i class="fa-solid fa-arrow-right"></i></a>
    </div>
  </div><?php } ?>
  </fieldset>
</body>
</html>