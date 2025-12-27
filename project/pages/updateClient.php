<?php
    require_once('identifier.php');

    require_once('connexiondb.php');

   

    $identifiant=isset($_POST['identifiant'])?$_POST['identifiant']:"";

    $nom=isset($_POST['nom'])?$_POST['nom']:"";

    $gsm=isset($_POST['gsm'])?($_POST['gsm']):"";

    $adresse=isset($_POST['adresse'])?($_POST['adresse']):"";
    
    $code_ville=isset($_POST['code_ville'])?($_POST['code_ville']):0;
    
    $email=isset($_POST['email'])?($_POST['email']):"";

    $modepass=isset($_POST['modepass'])?($_POST['modepass']):"";

    $type_c=isset($_POST['type_c'])?$_POST['type_c']:"";
    
    
    $requete="update client set nom=?,gsm=?,adresse=?,code_ville=?,email=?,modepass=?,type_c=? where identifiant=?";

    $params=array($nom,$gsm,$adresse,$code_ville,$email,$modepass,$type_c,$identifiant);

    $resultat=$conn->prepare($requete);

    $resultat->execute($params);
    $_SESSION['status'] =" vous Edeter le compte avec secsse "; 

    header('location:client.php');
?>