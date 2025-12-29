<?php 
    require_once("identifier.php");
    require_once("connexiondb.php");

    
    

    $type_envoi=isset($_GET["type_envoi"]) ? $_GET["type_envoi"] :"";
    $Fragel=isset($_GET["Fragel"]) ? $_GET["Fragel"] :"";
    $Pois=isset($_GET["Pois"]) ? $_GET["Pois"] :0;

    if ($Fragel==="Fragile") {
        $query1="select * from service_optionnel where code_service='$Fragel'";
        $result1 = $conn->query($query1);
        $row1 = $result1->fetch_assoc() ;
        $taxe1=$row1['taxe_o'] ;
        
    }else{
        $taxe1=0;
    }


    $query="select * from tarif where  $Pois BETWEEN poids_du AND poids_au and code_p =  '$type_envoi' ";


    $result = $conn->query($query);



if ($result->num_rows > 0) {
   $row = $result->fetch_assoc() ;
   $taxe=$row['taxe'];
   $_SESSION['code_tarif']=$row['code_tarif'];
   $_SESSION['tottaxe']=$taxe1+$taxe;
   $_SESSION['TAXEPOIS']=$taxe;
   $_SESSION['Fragile']=$Fragel;
   $_SESSION['type_envoi']=$type_envoi;
   $_SESSION['taxe1']=$taxe1;
   $_SESSION['Pois']=$Pois;
        header("location: envoi.php");
    }
else {  
          header("location: http://localhost/prj_liv/pages/envoi.php?taxe=0");
}

?>