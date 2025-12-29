<?php

session_start();
    require_once('connexiondb.php');

    


    $identifiant=isset($_POST['identifiant'])?$_POST['identifiant']:"";
    $nom=isset($_POST['nom'])?strtoupper($_POST['nom']):"";
    $gsm=isset($_POST['gsm'])?$_POST['gsm']:"";
    $adresse=isset($_POST['adresse'])?$_POST['adresse']:"";
    $ville=isset($_POST['ville'])?$_POST['ville']:"";
    $email=isset($_POST['email'])?$_POST['email']:"";
    $type_c=isset($_POST["type_c"])?$_POST["type_c"]:"";

    $sql="select * from client where identifiant='$identifiant'";
    
   

    $result=mysqli_query($conn,$sql);
    $existe=mysqli_num_rows($result);

    if ($existe>0) {
    $_SESSION['email_alert']="<strong>Erreur!!   :</strong> Votre information incoreccte";        
    header("location:inscrire.php");
    }
    else{  
        $requete="insert into client(identifiant,nom,adresse,gsm,code_ville,email,type_c) values(?,?,?,?,?,?,?)";
        $result=mysqli_query($conn,$requete);
        header("location: login");
        }  
    
    //        $_SESSION['email_alert']="<strong>Erreur!!   :</strong> se";       

?>