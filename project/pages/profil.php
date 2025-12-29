<?php
    require_once("identifier.php");
    require_once("connexiondb.php");
    if(isset($_SESSION['user']['CIN'])){
      $CIN=$_SESSION['user']['CIN'];
      $query= "select * from utilisateur where CIN='$CIN'";
      $resultatU = mysqli_query($conn, $query);
      $user=$resultatU->fetch_assoc();
      $_SESSION['user']=$user;
    }else
    {
      $CIN=$_SESSION['user']['identifiant'];
      $query= "select * from client where identifiant='$CIN'";
      $resultatU = mysqli_query($conn, $query);
      $user=$resultatU->fetch_assoc();
      $_SESSION['user']=$user;
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
<title>Mes Informations</title>
</head>
<body>
<?php if (isset($_SESSION['user']['CIN'])){include("menu.php"); }
      elseif (isset($_SESSION['user']['identifiant'])) {include("menu1.php");} ?>
    <form action="editerinfo.php" method="get" enctype="multipart/form-data" id=" form" class="d-flex justify-content-center">
        <fieldset class="row mb-3 border border-1 border-primary m-5 rounded-3">
            <legend class="p-5"><h1>Mes informations  :</h1>
            
    <div class="form-row w-100">
    <?php  if (isset($_SESSION['status'])) 
      {?>
        <div class="alert alert-success" role="alert">
  <h4 class="alert-heading"><?php echo  $_SESSION['user']['nom'] ?></h4>
  <p></p>
  <hr>
  <p class="mb-0"> <?php echo($_SESSION['status']);?></p>
</div>
        <?php
      isset($_SESSION['status']);
      }?>
      
    <div class="form-group col-md-10">
      <label for="inputEmail4">CIN        :    <big> <?php echo $CIN; ?></big></label>
      <input type="hidden" class="form-control" name="CIN" value="<?php echo$CIN?>" id="CIN" placeholder="CIN"  >
    </div>
    <div class="form-group col-md-10">
      <label for="inputEmail4">Nom :</label>
      <input type="text" class="form-control"  name="Nom" id="Nom" value="<?php echo $_SESSION['user']['nom']?>" placeholder="Nom" disabled >
    </div>
    <div class="form-group col-md-10">
      <label for="gsm">N° tél :</label>
      <input type="tel" class="form-control" name="gsm" id="gsm" value="<?php echo $_SESSION['user']['gsm']?>" placeholder="N° tél " disabled >
    </div>
    <div class="form-group col-md-10">
      <label for="email">Email :</label>
      <input type="email" class="form-control" name="email" value="<?php echo $_SESSION['user']['email']?>" id="email" placeholder="Email" disabled >
    </div>
    <?php if (isset($_SESSION['user']['identifiant'])) {?>
     <div class="form-group col-md-10">
      <label for="email">Adresse :</label>
      <input type="text" class="form-control" name="adresse" value="<?php echo $_SESSION['user']['adresse']?>" id="adresse" placeholder="Email" disabled >
    </div>
    <?php }?>
  </div> <br>

  <button  type="submet" class="btn btn-outline-primary" id="show" disabled >Enregestrer  <i class="fa-solid fa-user-pen"></i></button>&nbsp;&nbsp;&nbsp;&nbsp;<hr>
</form>
<a href="changemodepass.php">Changer mot de passe</a>
</fieldset>
<fieldset class="position-absolute start-50 translate-middle border border-1 border-primary">
<div class="form-check form-switch">
  <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
  <label class="form-check-label" for="flexSwitchCheckDefault">Je Peux Modifier</label>
</div>
</fieldset>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    var flexSwitchCheckDefault = document.getElementById('flexSwitchCheckDefault');
    flexSwitchCheckDefault.addEventListener('change', function() {
        var forms = document.getElementsByTagName('form');
        for (var i = 0; i < forms.length; i++) {
            var inputs = forms[i].getElementsByTagName('input');
            for (var j = 0; j < inputs.length; j++) {
                inputs[j].disabled = !this.checked;
            }
        }
    });
});
document.addEventListener('DOMContentLoaded', function(){
    document.getElementById('flexSwitchCheckDefault').addEventListener('change', function() {
        var showButton = document.getElementById('show');
        if (this.checked) {
            showButton.disabled = false;
        } else {
            showButton.disabled = true;
        }
    });
});
    </script>
</body>