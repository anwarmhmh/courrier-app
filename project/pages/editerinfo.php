<?php 
    require_once("identifier.php");
    require_once("connexiondb.php");
    $imgup=0;

    $cin = isset($_GET["CIN"]) ? $_GET["CIN"] :"";
    $nom = isset($_GET["Nom"]) ? $_GET["Nom"] :"";
    $gsm = isset($_GET["gsm"]) ? $_GET["gsm"] :"";
    $email = isset($_GET["email"]) ? $_GET["email"] :"";

    
    

    $requete="update utilisateur set nom=?,gsm=?,email=? where CIN=?";

    $params=array($nom,$gsm,$email,$cin);

    $resultat=$conn->prepare($requete);

    $resultat->execute($params);

    $_SESSION['status'] =" vous Edeter votre compte avec secsse "; 

    

    header("location:profil.php") ;  

?>

    