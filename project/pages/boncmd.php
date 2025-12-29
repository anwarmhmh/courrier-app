<?php 
    require_once('identifier.php');
    require_once("connexiondb.php");

    $code_envoi= isset($_GET['code_commande'])? $_GET['code_commande']:"";
    
    if(isset($code_envoi)){

        $query="select * from service_commande where code_commande='$code_envoi'"; 
            $result= mysqli_query($conn, $query);
            $result->fetch_assoc();
        if (mysqli_num_rows($result) > 0) {
            $query="select c.*, t.taxe , sc.code_service , so.taxe_o from commande as c join tarif as t on c.code_tarif =t.code_tarif
                join service_commande as sc on c.code_commande=sc.code_commande join service_optionnel as so
                on sc.code_service = so.code_service WHERE c.code_commande='$code_envoi' ";
            $result= mysqli_query($conn, $query);
            $commande = $result->fetch_assoc();
            $taxe=$commande['taxe'];
            $taxe_o=$commande['taxe_o'];
            $tottaxe=$taxe+$taxe_o;
            $nom=$commande['nom_d'];
            $email=$commande['email_d'];
            $gsm=$commande['GSM_d'];
            $adresse=$commande['adresse_d'];
            $ville=$commande['ville_d'];  
            $Fragile=$commande['code_service']; 
            $Pois=0;

            header("Location: sucssec.php?code_envoi=$code_envoi&taxe=$taxe&nom=$nom&email=$email&gsm=$gsm&adresse=$adresse&ville=$ville&taxe_o=$taxe_o&taxe=$taxe&tottaxe=$tottaxe&code_service=$Fragile&Pois=$Pois");

       
        }else {

            $query="select c.*, t.taxe  from commande as c join tarif as t on c.code_tarif =t.code_tarif
                    WHERE c.code_commande='$code_envoi' ";
            $result= mysqli_query($conn, $query);
            $commande = $result->fetch_assoc();

            $taxe=$commande['taxe'];
            $taxe_o=0;
            $tottaxe=$taxe+$taxe_o;
            $nom=$commande['nom_d'];
            $email=$commande['email_d'];
            $gsm=$commande['GSM_d'];
            $adresse=$commande['adresse_d'];
            $ville=$commande['ville_d'];  
            $Fragile=""; 
            $Pois=0;


            header("Location: sucssec.php?code_envoi=$code_envoi&taxe=$taxe&nom=$nom&email=$email&gsm=$gsm&adresse=$adresse&ville=$ville&taxe_o=$taxe_o&taxe=$taxe&tottaxe=$tottaxe&code_service=$Fragile&Pois=$Pois");
        }
       

    }


?>