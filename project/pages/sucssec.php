<?php
    require_once('identifier.php');
    require_once("connexiondb.php");

    $code_envoi=isset($_GET['code_envoi'])?$_GET['code_envoi']:"";
    $nom=isset($_GET['nom'])?$_GET['nom']:"";
    $email=isset($_GET['email'])?$_GET['email']:"";
    $gsm=isset($_GET['gsm'])?$_GET['gsm']:"";
    $adresse=isset($_GET['adresse'])?$_GET['adresse']:"";
    $ville=isset($_GET['ville'])?$_GET['ville']:"";

        
        $Pois= isset($_SESSION['Pois'])?$_SESSION['Pois']: $_GET['Pois'];
        $taxe = isset($_SESSION['TAXEPOIS']) ? $_SESSION['TAXEPOIS']: $_GET['taxe'];
        $taxe_o = isset($_SESSION['taxe1']) ?$_SESSION['taxe1']:$_GET['taxe_o'];
        $Fragile = isset($_SESSION['Fragile'])? $_SESSION['Fragile'] :$_GET['code_service'];
        $tottaxe =isset($_SESSION['tottaxe'])?$_SESSION['tottaxe']: $_GET['tottaxe'];
        

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/stil.css">
    <title>Ma Commande</title>
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</head>
<body>
<?php if(isset($_SESSION["user"]['identifiant'])){include("menu1.php");}else{include("menu.php");} ?>
     <div class="container">
        <?php 
            if ($code_envoi !="" && isset($_SESSION['tottaxe'])) {?>
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">succès <i class="fa-solid fa-check-double"></i></h4>
            <p>Vous Avez faire votre envoi avec succès </p>
            <hr>
            <p class="mb-0"> Pour le suiver de votre envoi  :     <?php ECHO "<BIG>". $code_envoi."</BIG>" ;  ?> </p>
        </div><?php } ?>

    <div class="m-4 p-5" id="cmd">
        <hr>
        <div class="row p-4">
            <div class="col-md-3">
                <label >Code D'envoi   :</label>
            </div>
            <div class="col-md-2">
                <label>"<?php echo $code_envoi?>"</label>
            </div>
        </div>
        <div class="row p-4"><?php if ($Pois!=0) {?>
            <div class="col-md-2">
                <label >Poids :</label>
            </div>
            <div class="col-md-2">
                <label><?php echo $_SESSION['Pois']?> KG</label>
            </div>|||<?php }?>
            <div class="col-md-3">
                <label >Taxe De Poids :</label>
            </div>
           
            <div class="col-md-2">
                <label><?php echo $taxe ?>  DH</label>
            </div>
        </div>
        <div class="row p-4">
            <div class="col-md-4">
                <label >Nom destinataire :</label>
            </div>
            <div class="col-md-2">
                <label><?php echo $nom?></label>
            </div>|||
            <div class="col-md-2">
                <label >N° tél :</label>
            </div>
            <div class="col-md-2">
                <label><?php echo '0'.$gsm?></label>
            </div>
        </div>
        <div class="row p-4">
            <div class="col-md-4">
                <label >Email destinataire :</label>
            </div>
            <div class="col-md-3">
                <label><?php echo $email?></label>
            </div>
        </div>
        <div class="row p-4">
            <div class="col-md-4">
                <label>adresse destinataire :</label>
            </div>
            <div class="col-md-5">
                <label><?php echo $adresse?></label>
            </div>
        </div><?php if ($Fragile!="") {?>
        <div class="row p-4">
            <div class="col-md-3">
                <label>Option D'envoi :</label>
            </div>
            <div class="col-md-2">
                <label><?php echo $Fragile?></label>
            </div>
            |||
            <div class="col-md-3">
                <label>Taxe D'option :</label>
            </div>
            <div class="col-md-2">
                <label><?php echo $taxe_o?> DH</label>
            </div>
        </div>
        <?php }?>
        <div class="row p-4">
            <div class="col-md-2">
                <label>Prix Total</label>
            </div>
            <div class="col-md-2">
                <label><?php echo $tottaxe?> DH</label>
            </div>
        </div>
        <hr>
    </div>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-outline-info " id="download">Telecharger PDF <i class="fa-solid fa-download"></i></button>
        

		<script>
      document.querySelector('#download').onclick = function(){
        var element = document.querySelector('#cmd');
				html2pdf().from(element).save();
      }
		</script>
    </div>
    
</body>