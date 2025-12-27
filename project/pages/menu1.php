<?php
require_once('identifier.php');
    require_once("connexiondb.php");  
    
    if (isset($_SESSION["user"]) ) {
      $user = $_SESSION["user"];
    }
?>
<div class="wrapper">
    <div class="sidebar">
       <a href="#"><h2><img src="../images/11.png" width="150" height="100" alt="" srcset=""></h2></a> 
        <ul>
            <li><a href="envoi.php"><i class="fa-regular fa-plus"></i><i class="fa-regular fa-paper-plane"></i> &nbsp; nouveau Envoi</a></li>
            <li><a href="commande.php"><i class="fa fa-list" aria-hidden="true"></i> &nbsp;Mes Commandes</a></li>
            <li><a href="profil.php"><i class="fas fa-user"></i>profil</a></li>
        </ul> 
        <div>
          <?php
          if (isset($user)) {echo"<div class='alert alert-primary' role='alert'>
           Bienvenu : <br>".$user["nom"].
          "</div>"; }
          ?>
        </div>
        <div class="social_media">
           <big style="color: #fff;">Déconnexion</big><a href="SeDeconnecter.php"><i class="fa-solid fa-right-from-bracket"></i></a>
      </div>
    </div>
</div>