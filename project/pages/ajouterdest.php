
<?php
    // Including necessary files
    require_once("identifier.php");
    require_once("connexiondb.php");

    // Getting values from GET request
   

    if ($_SESSION['type_envoi']=="CL") {
        $c = "Colis <i class='fa-solid fa-box fa-2x'></i> ";
    }   elseif ($_SESSION['type_envoi']=="CR") {
        $c ="Courrier <i class='fa-solid fa-envelope fa-2x'></i> ";
    }
    
  
    $nom=isset($_GET['nom'])?$_GET['nom']:"";
    $email=isset($_GET['email'])?$_GET['email']:"";
    $gsm=isset($_GET['gsm'])?$_GET['gsm']:"";
    $adresse=isset($_GET['adresse'])?$_GET['adresse']:"";
    $ville=isset($_GET['ville'])?$_GET['ville']:"";
    $T_C=isset($_GET['tempscollect'])?$_GET['tempscollect']:"";


    


?>

<html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/stil.css">
    <title>Information de destinataire</title>
</head>
<body>
    <?php include "menu1.php"; ?> 
    <div class="container">  
        <h3 style="text-align: center;">Facture et destinataire </h3><br/>
        <?php 
            if ($_SESSION['tottaxe'] !=0) {?>
        <div class="alert alert-success" role="alert">
  <h4 class="alert-heading">Facture :</h4>
  <p>Vous Avez choiser d'envoyer 
    <?php 
        echo $c 
    ?> 
    avec une Options <?php echo $_SESSION['Fragile']  ?>
    </p>
  <hr>
  <p class="mb-0">pour contenu est fait cet envoi remplir les informations de distenaire et vous pouvez payer <?php ECHO "<BIG>". $_SESSION['tottaxe'] ?>DH</p>
</div><?php } ?>

        <?php 
            if ($nom !='') {?>
        <div class="alert alert-success" role="alert">
  <h4 class="alert-heading">Destainaire :</h4>
  <p>
  Appuyez sur le bouton en dessous pour confirmer votre commande.
    </p>
  <hr>
  <p class="mb-0"> Pour faire ce envoi a  <?php ECHO "<BIG>". $nom ?></p>
</div><?php } ?>

   
  <div class="form-group row  p-5" >
    <div class="col-sm-10">
    <a style="text-decoration:none; color:green;" href="confirmer.php?nom=<?php echo $nom?>&email=<?php echo $email?>&adresse=<?php echo $adresse?>&ville=<?php echo $ville?>&gsm=<?php echo $gsm?>&tempscollect=<?php echo $T_C?>"><i class="fa-solid fa-check"></i> Confermer </a>
    </div>
  </div>

<?php  if ($_SESSION['tottaxe'] !=0) 
  { ?>
<div class="form-group row  p-5" >
    <div class="col-sm-10">
      <a style="text-decoration:none; color:red;" href="dest.php"><i class="fa-solid fa-arrow-left"></i> Précédent</a>
    </div>
  </div><?php } ?>
</body>
