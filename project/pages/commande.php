<?php
require_once('identifier.php');
require_once("connexiondb.php");

$size = isset($_GET['size']) ? $_GET['size'] : 4;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$type_envoi = isset($_GET['type_envoi']) ? $_GET['type_envoi'] : 'all';
$identifiant=isset($_GET['identifiant'])?$_GET['identifiant']:"";

$offset = ($page - 1) * $size;

if (isset($_SESSION["user"]['identifiant'])) {
   
    $CIN = $_SESSION["user"]['identifiant'];


    if ($type_envoi == "all") {
        $requete = "select * from commande where identifiant = '$CIN' 
        group by date_l desc 
        limit $size
        offset $offset";

        $requeteCount = "select count(*) countC from commande
        where identifiant = '$CIN'";
    } else{
        $requete = "select * from commande where identifiant = '$CIN' and code_p='$type_envoi'
        group by date_l desc 
        limit $size
        offset $offset";

        $requeteCount = "select count(*) countC from commande
        where identifiant = '$CIN' and code_p = '$type_envoi'";

    }

    
 
}elseif(isset($_SESSION["user"]['CIN'])){
    
    $CIN=$_SESSION["user"]["CIN"];
    $currentU=  $_SESSION['user']['code_centre'];

    if ($type_envoi=="all") {
        $requete = "SELECT distinct  cm.* FROM commande AS cm
        JOIN client AS cl ON cm.identifiant = cl.identifiant
        JOIN centre AS cen ON cl.code_ville = cen.code_ville
        JOIN utilisateur AS u ON cen.code_centre = u.code_centre
        WHERE cen.code_centre ='$currentU' and cm.identifiant like '%$identifiant%'
        group by date_l  
        limit $size
        offset $offset " ;
      $requeteCount = "select  count(distinct code_commande) countC from commande AS cm
      JOIN client AS cl ON cm.identifiant = cl.identifiant
      JOIN centre AS cen ON cl.code_ville = cen.code_ville
      JOIN utilisateur AS u ON cen.code_centre = u.code_centre
      WHERE cen.code_centre ='$currentU'and cm.identifiant like '%$identifiant%' ";
    }else{
        $requete = "SELECT distinct  cm.* FROM commande AS cm
        JOIN client AS cl ON cm.identifiant = cl.identifiant
        JOIN centre AS cen ON cl.code_ville = cen.code_ville
        JOIN utilisateur AS u ON cen.code_centre = u.code_centre
        WHERE cen.code_centre ='$currentU' AND cm.code_p='$type_envoi' and cm.identifiant like '%$identifiant%'
        limit $size
        offset $offset " ;
      $requeteCount = "select  count(distinct code_commande) countC from commande AS cm
      JOIN client AS cl ON cm.identifiant = cl.identifiant
      JOIN centre AS cen ON cl.code_ville = cen.code_ville
      JOIN utilisateur AS u ON cen.code_centre = u.code_centre
      WHERE cen.code_centre ='$currentU' AND cm.code_p='$type_envoi' and cm.identifiant like '%$identifiant%' ";
    }
}
$resultat = mysqli_query($conn, $requete);

    $resultatCount = $conn->query($requeteCount);
    $tabCount = $resultatCount->fetch_assoc();
    $nbrcmd = $tabCount['countC'];

    if ($nbrcmd==0) {
        $message=" N'avais pas de commande ";
    }

    $reste = $nbrcmd % $size;   // % operateur modulo: le reste de la division 
    //euclidienne de $nbrFiliere par $size
    if ($reste === 0)
    {
        $nbrPage = $nbrcmd / $size;//$nbrFiliere est un multiple de $size

    } 
    else{     
        $nbrPage = floor($nbrcmd / $size) + 1;  // floor : la partie entière d'un nombre décimal
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/stil.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Commade</title>
</head>

<body>
    <?php if(isset($_SESSION["user"]['identifiant'])){include("menu1.php");}else{include("menu.php");} ?>
    <div class="container">
        <div class="panel panel-success margetop60">
            <div class="panel-heading">
            <?php if ($nbrcmd==!0 || isset($_SESSION["user"]['CIN'])) {?>
                <fieldset class=" row mb-3 border border-1 border-primary m-2 p-2 ">
                    <legend>Rechercher des Commandes</legend>
				    <div class="panel-body">
                        <form method="get" action="commande.php" class="form-inline">
                            <div class="form-group p-2">
                                <p> selectioner type de votre envoi rechercher :</p>
                                <hr>
                                <div class="form-check">
                                    <input class="form-check-input" id="cl" type="radio" value="CL" name="type_envoi">
                                    <label class="form-check-label" for="cl">
                                        Colis <i class='fa-solid fa-box fa-2x'></i></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" id="cr" type="radio" value="CR" name="type_envoi">
                                    <label class="form-check-label" for="cr">
                                    Courrier <i class='fa-solid fa-envelope fa-2x'></i></label>                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" id="tout" type="radio" value="all" name="type_envoi" >
                                    <label  class="form-check-label" for="tout">Tous mes commandes </label>
                                </div>
                                <hr>
                                <?php if (isset($_SESSION["user"]['CIN'])){ ?>
                                <input type="text" name="identifiant" 
                                   placeholder="Identifiant du client"
                                   class="form-control w-50"
                                   value="<?php echo  $identifiant ?>"/>
                                   <?php }?>
                                   <button type="submit" class="btn btn-success ">
                                        <i class="fa-solid fa-magnifying-glass"></i> Chercher
                                    </button>
                            </div>
                            <?php }?>
                                <?php  if (isset($_GET['messag'])){ ?>
                                <div class="alert alert-secondary" role="alert">
                                    <?php echo      $_GET['messag']. "   ";}?>
                                </div>
                   
                                &nbsp;&nbsp;
                        </form> 
                    </fieldset>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">Liste des Commandes << <?php echo $nbrcmd ?> commande (s) >></div>
                    <div class="panel-body">
                        <table class="table table-success table-striped">
                            <thead>
                                <tr>
                                    <th>code_envoi</th>
                                    <th>Nom</th>
                                    <th>adresse</th>
                                    <th>ville </th>
                                    <th>N° tél</th>
                                    <th>email</th>
                                    <th>Date Commande</th>
                                    <th>Temps de collect</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ( $command = $resultat->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $command["code_commande"] ?></td>
                                    <td> <?php echo $command["nom_d"] ?> </td>
                                    <td><?php echo $command["adresse_d"] ?></td>
                                    <td><?php echo $command["ville_d"] ?></td>
                                    <td>0<?php echo $command["GSM_d"] ?></td>
                                    <td><?php echo $command["email_d"] ?></td>
                                    <td><?php echo $command["date_l"] ?></td>
                                    <td><?php echo $command["temps_collecte"] ?></td>
                                    <td> 
                                        <?php if (isset($_SESSION["user"]['CIN'])){ $code_commande=$command["code_commande"];
                                            $query ="select * from collection where code_commande='$code_commande'";
                                            $result = $conn->query($query);
                                            if ($result->num_rows==0) {?>
                                        <a onclick="return confirm('Etes vous sur de Collecter Cette commande ')" href="collecter.php?code_commande=<?php echo $command["code_commande"]?>">
                                                    Col</a> <?php } }?>
                                        <a href="boncmd.php?code_commande=<?php echo $command["code_commande"] ?>">
                                        <i class="fa-solid fa-download"></i></a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php if (isset($message)) {
                        echo "<div class='alert alert-secondary' role='alert'>
                        $message</div>";}  ?>
                        <div>
                            <ul class="pagination">
                                <?php for($i=1;$i<=$nbrPage;$i++){ ?>
                                    <button type="button" class="btn btn-outline-primary">
                                        <li class="<?php if($i==$page) echo 'active' ?>"> 
                                            <a  style="color: black;" href="commande.php?page=<?php echo $i;?>&type_envoi=<?php echo $type_envoi ?>"><?php echo $i; ?></a> 
                                        </li>
                                    </button>
                                <?php } ?>
                            </ul>
                        </div>
                    </div> 
                </div>    
            </div>
    </div>
</body>  
