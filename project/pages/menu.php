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
            <li><a href="Client.php"><i class="fa fa-list" aria-hidden="true"></i> &nbsp; Client</a></li>

          <?php
            if ($user['role'] ==="collecteur"){
              echo "<li><a href='commande.php'><i class='fa fa-list' aria-hidden='true'></i>Commandes</a></li>";
            }elseif($user['role'] ==="admin"){
              echo '<li><a href="collecteur.php"><i class="fa fa-list" aria-hidden="true"></i> &nbsp;collecteur</a></li>';
            }
          ?>
            <li><a href="collect.php"><i class="fa-solid fa-link"></i>Collecte</a></li>
            <li><a href="profil.php"><i class="fas fa-user"></i>Profil</a></li>
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
