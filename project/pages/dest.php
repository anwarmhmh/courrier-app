
<?php
    // Including necessary files
    require_once("identifier.php");
    require_once("connexiondb.php");

    // Getting values from GET request
   


    $vville = "select * from ville";
    $listv = mysqli_query($conn, $vville);

    if ($_SESSION['type_envoi']=="CL") {
        $c = "Colis <i class='fa-solid fa-box fa-2x'></i> ";
    }   elseif ($_SESSION['type_envoi']=="CR") {
        $c ="Courrier <i class='fa-solid fa-envelope fa-2x'></i> ";
    }




?>

<html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/stil.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>destinataire</title>
</head>
<body>
    <?php include "menu1.php"; ?> 
    <div class="container">  
        <h3 style="text-align: center;">Facture de Votre envoi </h3><br/>
        <?php 
            if ($_SESSION['tottaxe'] !=0) {?>
        <div class="alert alert-success" role="alert">
  <h4 class="alert-heading">Facture :</h4>
  <p>Vous Avez choiser d'envoyer 
    <?php 
        echo $c 
    ?> 
    avec une Options <?php echo $_SESSION['Fragile'] ?>
    </p>
  <hr>
  <p class="mb-0">  pour contunu est fait ce envoi remplire les informations de distenaire et vou pouvez payer <?php ECHO "<BIG>". $_SESSION['tottaxe'];?>DH</p>
</div><?php } ?>

    <form class="d-flex justify-content-center " action="ajouterdest.php" method="GET" >
    <fieldset> 
    <legend class="p-5"><h2>Information sur votre commande :</h2></legend>
    <fieldset>
    <div class="row">
    <div class="col-md-4">
        <label for="nom" class="form-label">Nom Complete :</label>
        <input type="text" class="form-control" name="nom" placeholder="Nom Complete" id="nom" requried>
  </div>
    <div class="col-md-4">
        <label for="inputCity" class="form-label">N° tél :</label>
        <input type="text" class="form-control" placeholder="0611223344" id="gsm" name="gsm" requried>
  </div>
</div>
<div class="row">
    <div class="col-md-4">
        <label for="email" class="form-label">email :</label>
        <input type="text" class="form-control" name="email" placeholder="exemple@ex.ma" id="email">
  </div>
  <div class="col-md-4">
    <label for="ville" class="form-label">Ville :</label>
    <select  id="ville" name="ville" class="form-select">
      <option selected>select ville</option>
      
        <?php
            while($row = mysqli_fetch_array($listv)): ?>
     
            <option class="dp" value= "<?php echo $row[1];?>"><?php echo $row[1];?></option>
     
            <?php endwhile;
        ?>
       
    </select>
  </div>
  </div>
  <div class="row ">
  <div class="col-8">
    <label for="adresse" class="form-label">Address :</label>
    <input type="text" class="form-control" id="adresse" name="adresse" placeholder="1234 Rue St">
  </div>
  <div class="col-8">
    <label for="adresse" class="form-label">heure de collect :</label>
    <input type="time" class="form-control" id="adresse" name="tempscollect" >
  </div>
  </div></form>
  <div class="form-group row  p-5" >
    <div class="col-sm-10">
      <button type="submit" onclick="return confirm('Etes vous sur de passe votre commande')" class="btn btn-outline-success" > Envoyer  <i class="fa-regular fa-paper-plane"></i></button>
    </div>
  </div>

<?php  if (isset($_SESSION['tottaxe'])) 
  { ?>
<div class="form-group row  p-5" >
    <div class="col-sm-10">
      <a style="text-decoration:none; color:green;" href="envoi.php"><i class="fa-solid fa-arrow-left"></i> Précédent</a>
    </div>
  </div><?php } ?>
</body>
