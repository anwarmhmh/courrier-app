<?php
    require_once("identifier.php");
    require_once("connexiondb.php");

    $psw=$_SESSION['user']['modepass'];
    if(isset($_SESSION['user']['CIN'])){
        $CIN=$_SESSION['user']['CIN'];
    }
    else
    {
      $CIN=$_SESSION['user']['identifiant'];
    }



?>
<!DOCTYPE html>
<html>
<head>
<script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
<link rel="stylesheet" href="../css/styles.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link rel="stylesheet" href="../css/monstyle.css">
<title> mot de passe</title>
<script>
     window.onload = function() {
    document.getElementById('inputs').addEventListener('click', function(event) {
        if (event.target.classList.contains('toggle-password')) {
            var input = event.target.previousElementSibling;
            if (input.type === 'password') {
                input.type = 'text';
            } else {
                input.type = 'password';
            }
        }
    });
}
    function myf() {
        let mess=""
        document.getElementById('checkBtn').addEventListener('click', function() {
    if (document.getElementById('psw2').value === document.getElementById('psw3').value) {
        if (document.getElementById('psw1').value==='<?php echo $psw ?>') {
            document.getElementById('checkBtn').setAttribute("type", "submit");
            document.getElementById('myForm').setAttribute("Action", "updatepsw.php");
            document.getElementById('checkBtn').click();
        }
        else{ 
            mess=" le mot de passe actuel saisser incorect "
        }
    } else {
            mess ="le nouveau mot de passe et la confermation sons deferent"
    }
    if ( mess !== "") {
    // variable exists, now display it in HTML
    document.getElementById('variableContainer').innerHTML = mess;
    document.getElementById('variableContainer').hidden=false;
    } 
    else{
        document.getElementById('variableContainer').hidden=true;
    }
});}
</script>
<style>
        .password-input {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<?php include("menu.php"); ?>
    <form action="" method="Post" id="myForm" class=" g-3 d-flex justify-content-center"  >
        <fieldset class="row mb-1 border border-1 border-primary m-5 rounded-3">
            <legend class="p-5"><h1>Mes informations :</h1>
            <div class="alert alert-warning" id="variableContainer" role="alert" hidden>
  
            </div>
        <div class="form-group col-md-7 " id='inputs'>
            <label>CIN        :    <big> <?php echo $CIN; ?></big></label>
            <div id="inputs">
        <div class="password-input">
            <label for="psw1">mot passe actuel :</label>
            <input type="password" id="psw1"   placeholder="mot passe actuel"/>
            <button type="button"  class="btn btn-outline-dark toggle-password"><i class="fa-solid fa-eye "></i></button>
        </div>
        <div class="password-input">
            <label for="psw2">Nouveau mot de passe :</label>
            <input type="password" class="input-group " id="psw2" name="psw2"  placeholder="Nouveau mot de passe" />
            <button type="button"  class="btn btn-outline-dark toggle-password"><i class="fa-solid fa-eye "></i></button>
        </div>
        <div class="password-input">
            <label for="psw3">Retapez le Nouveau mot de passe :</label>
            <input type="password" id="psw3"  placeholder="Conferme Nouveau mot de passe"/>
            <button type="button"  class="btn btn-outline-dark toggle-password"><i class="fa-solid fa-eye "></i></button>
        </div>
    </div>
        </div>
  <button type="button" class="btn btn-outline-info" id="checkBtn" onclick="myf()">Change </button>
</form>
</body>