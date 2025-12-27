<?php
    require_once("identifier.php");
    require_once("connexiondb.php");

    $Npsw=$_POST['psw2'];


    if(isset($_SESSION['user']['CIN'])){

        $CIN=$_SESSION['user']['CIN'];
        $_SESSION['user']['modepass']==$Npsw;
        $requete = $conn->prepare("update utilisateur set modepass='$Npsw'  where CIN='$CIN'");
    if ( $requete->execute() === TRUE) {
        $_SESSION['status']="vous avez editer votre mot de passe"   ; 
        header('Location: profil.php');
    } else {
        $_SESSION['status']="vous n'avez pas editer votre mot de passe"   ; 
        header('Location: profil.php');
    }
    }
    else
    {
      $CIN=$_SESSION['user']['identifiant'];
      $_SESSION['user']['modepass']==$Npsw;
        $requete = $conn->prepare("update client set modepass='$Npsw'  where identifiant='$CIN'");
    if ( $requete->execute() === TRUE) {
        $_SESSION['status']="vous avez editer votre mot de passe"   ; 
        header('Location: profil.php');
    } else {
        $_SESSION['status']="vous n'avez pas editer votre mot de passe"   ; 
        header('Location: profil.php');
    }

    }


?>