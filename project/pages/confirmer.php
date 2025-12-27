<?php 
 require_once("identifier.php");
 require_once("connexiondb.php");
 
 
    $nom=isset($_GET['nom'])?$_GET['nom']:"";
    $email=isset($_GET['email'])?$_GET['email']:"";
    $gsm=isset($_GET['gsm'])?$_GET['gsm']:"";
    $adresse=isset($_GET['adresse'])?$_GET['adresse']:"";
    $ville=isset($_GET['ville'])?$_GET['ville']:"";
    $T_C=isset($_GET['tempscollect'])?$_GET['tempscollect']:"";

    if (isset($_SESSION["user"]) ) {
        $user = $_SESSION["user"];
        $identifiant=isset($user['identifiant'])?$user['identifiant']:"";
      }
      
    $code_p=$_SESSION['type_envoi'];
    
    $code_t=$_SESSION['code_tarif'];


      $query="select compteur from produit where code_p='$code_p'";

      $result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {

      $result = $conn->query($query);
      $row = $result->fetch_assoc();
      $compteur=$row['compteur'];
      $code_envoi=$code_p.'0'.$compteur.'Ma';

      $query1= "update produit set compteur=compteur+1 where code_p='$code_p'";
      if ($conn->query($query1) === TRUE) {
        try {
          
          $requete="insert into commande(code_commande,code_p,code_tarif,identifiant,nom_d,adresse_d,ville_d,GSM_d,email_d,temps_collecte) values (?,?,?,?,?,?,?,?,?,?)";
        $params=array($code_envoi,$code_p,$code_t,$identifiant,$nom,$adresse,$ville,$gsm,$email,$T_C);
        $resultat=$conn->prepare($requete);
        $resultat->execute($params);

        if ($_SESSION['Fragile']==="Fragile") {
          $opt=$_SESSION['Fragile'];
          $query1="insert into service_commande(code_commande,code_service) values (?,?)";
          $param=array($code_envoi,$opt);
          $result=$conn->prepare($query1);
          $result->execute($param);
      }
       
        header("location: sucssec.php?code_envoi=$code_envoi&nom=$nom&email=$email&adresse=$adresse&ville=$ville&gsm=$gsm&tempscollect=$T_C");
        } catch (\Throwable $th) {
          ECHO 'eroor';
        }
        
      } 
}else{ECHO 'eroor1';}

      
    
        


?>