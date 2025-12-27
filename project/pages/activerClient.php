<?php
    session_start();

    require_once('identifier.php');

    require_once('connexiondb.php');

    $identifiant=isset($_GET['identifiant'])?$_GET['identifiant']:"";
    $statu=isset( $_GET['statu'])?$_GET['statu']:"";
    
    if ($statu== "active")
    {
        $requete="update client set statu='desactive' where identifiant='$identifiant'";
        $_SESSION['status'] =" vous desactiver le compte avec secsse "; 

    }elseif ($statu== "desactive")
    {
        $requete="update client set statu='active' where identifiant='$identifiant'";
        $_SESSION['status'] =" vous activer le compte avec secsse  "; 

       }
    

    if ($conn->query($requete) === TRUE) {

        header('location:Client.php');
       
      } else {}
     

    
?>