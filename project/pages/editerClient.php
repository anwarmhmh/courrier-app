
<?php
   require_once('identifier.php');
    require_once('connexiondb.php');
    $id=isset($_GET['identifiant'])?$_GET['identifiant']:"";
    $requete="select * from client where identifiant='$id'";


    $resultatC = mysqli_query($conn, $requete);
    $client=$resultatC->fetch_assoc();
    $nomc=ucfirst($client['nom']);
    $adresse=$client['adresse'];
    $gsm=$client['gsm'];
    $email=$client['email'];
    $cp=$client['code_ville'];
    $modepass=$client['modepass'];
    $type_c =$client['type_c'];
?>
<! DOCTYPE HTML>
<HTML>
    <head>
        <meta charset="utf-8">
        <title>Edition d'un Client</title>
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="stylesheet" href="../css/stil.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/monstyle.css">
        <title>modifier information</title>
    </head>
    <body>
        <?php include("menu.php"); ?>
      <div class="form-container">
        <h2>Editer client :</h2>
        <form method="Post" action="updateClient.php" class="form">
            <div id="rd">
            <fieldset><legend> Selectionner Votre Type D'inscription</legend>
            <label> <input type="radio" value="P"  name="type_c" <?php if ($type_c=='P') { echo "checked";} ?> required>  pérsonne </label>
            <label> <input type="radio" value="A"  name="type_c" <?php if ($type_c=='A') { echo "checked";} ?>>  association </label>
            <label> <input type="radio" value="S"  name="type_c" <?php if ($type_c=='S') { echo "checked";} ?>>  société </label>
            </fieldset>
            </div>
            <div class="form-group">
                <label for="cin">intitulé Client    :  <?php echo $id ?> </label>
                <input type="hidden" name="identifiant" 
                                   class="form-control"
                                    value="<?php echo $id ?>"/>
            </div>

            <div class="form-group">
                <label for="nom">Nom:</label>
                <input type="text" id="nom" value="<?php echo $nomc?>" name="nom" required>
            </div>
            
            <div class="form-group">
                <label for="gsm">Tel</label>
                <input type="text" id="gsm" value="<?php echo  $gsm;?>"  name="gsm" required>
            </div>

            <div class="form-group">
                <label for="adresse">Adresse:</label>
                <input type="text" id="adresse" value="<?php echo  $adresse?>" name="adresse" required>
            </div>

            <div class="form-group">
                <label for="">code postale:</label>
                <input type="text" id="adresse" value="<?php echo  $cp; ?>" name="code_ville" required>    
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" value="<?php echo $email?>" name="email" required>
            </div>

            <div class="form-group">
                <label for="modepass">modepass:</label>
                <input type="modepass" id="modepass" value="<?php echo $modepass?>" name="modepass" required>
            </div>

            <div class="form-group">
                <button type="submit" class="button">enregistrer
                <i class="fa-solid fa-floppy-disk"></i>
                </button>
            </div>            
           
        </form>
     </div>
             
    </body>
</HTML>