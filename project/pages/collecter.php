<?php  
    require_once("identifier.php");
    require_once("connexiondb.php");

    $code_envoi= isset($_GET['code_commande'])? $_GET['code_commande']:"";
    $page= isset($_GET['page'])? $_GET['page']:1;
    $CIN = $_SESSION["user"]['CIN'];

    $query="select  count(code_col) countC from collection where code_commande='$code_envoi'";  

    $result = $conn->query($query);
    $tabCount = $result->fetch_assoc();
    $nbrcol = $tabCount['countC'];
    
    if ($nbrcol == 0) {

    $query="insert into collection(code_commande,CIN)  values(?,?)";

        $param=array($code_envoi,$CIN);
        $result=$conn->prepare($query);
        $result->execute($param);

        $messag="vou pouvez collecter cette commande";

        header("location: commande.php?messag=$messag");
    }
    else {
        $messag= " la commande est deja collecter";
        header("location: commande.php?messag=$messag");
    }
    
?>