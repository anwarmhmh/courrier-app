<?php

session_start();
$erreurinscrire = "";
if (isset($_SESSION['email_alert']))
{
    $erreurinscrire = $_SESSION['email_alert'];
}
session_destroy();


require_once("connexiondb.php");
$vville = "select * from ville";
$listv = mysqli_query($conn, $vville);




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="../css/monstyle.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <Script>

    /*function onlyOne(checkbox) {
    var checkboxes = document.getElementsByName('CH')
    checkboxes.forEach((item) => {
        if (item !== checkbox) item.checked = false
    })}*/
    
</Script>

</head>

<body>
    <div class="header">
        <div class="logo">Logo</div>
        
    </div>

    <div class="form-container" style="max-width: 700px;">
        <h1>Preinscription Form</h1>
            <?php if (!empty($erreurinscrire)) { ?>
                    <div class="alert alert-danger">
                        <?php echo $erreurinscrire ?>
                    </div>
                <?php } ?>

        <form method="post" action="ajouterC.php">
            <div id="rd" >
            <fieldset><legend> Selectionner Votre Type D'inscription</legend>
            <label> <input type="radio" name="type_c" value="P" required>  pérsonne </label>
            <label> <input type="radio" name="type_c" value="A">  association </label>
            <label> <input type="radio" name="type_c" value="S">  société </label>
            </fieldset>
            </div>
            
            <div class="form-row">
            <div class="form-group col-md-6">
                <label for="num">intitulé Client:</label>
                <input type="text" class="form-control" placeholder="CIN ,N°association ,N°societe" id="num" name="identifiant" required>

            </div>

            <div class="form-group col-md-6">
                <label for="nom">Nom:</label>
                <input type="text" class="form-control" id="nom" placeholder="Nom Complet" name="nom" required>
            </div>
            </div>

            <div class="form-row">
            <div class="form-group col-md-6">
                <label for="gsm">N° tél :</label>
                <input type="text" id="gsm" name="gsm" placeholder="0611223344" class="form-control" required>
            </div>
            <div class="form-group col-md-6">
                <label for="ville">Ville:</label>
                <select id="ville" name="ville" class="form-control">
                    <option value="">select ville</option>
                <?php
                  while($row = mysqli_fetch_array($listv)): ?>
     
                 <option class="dp" value= "<?php echo $row[0];?>"><?php echo $row[1];?></option>
     
                 <?php endwhile;
                ?>
                </select>
            </div>
            </div>

            <div class="form-row">
            <div class="form-group col-md-6">
                <label for="adresse">Adresse :</label>
                <input type="text" id="adresse" class="form-control" placeholder="Apartment, studio, or floor" name="adresse" required>
            </div>
            

            <div class="form-group col-md-6">
                <label for="email">Email:</label>
                <input type="email" class="form-control" placeholder="nom@exemple.com" id="email" name="email" required>
            </div>
            </div>

            <div class="form-group col-md-6">
                <button type="submit" class="button">Inscrire</button>
            </div>            
            <div class="form-group col-md-6">                
                <a href="login.php">J'ai un compte</a>
            </div>
        </form>
    </div>
</body>

</html>


