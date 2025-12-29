
<?php

    require_once('identifier.php');
    require_once("connexiondb.php");

    $role=$_SESSION['user']['role'];
    if($role=='collecteur'){

    $code_envoi=isset($_GET['code_envoi'])?$_GET['code_envoi']:"";
    $CIN= $_SESSION["user"]['CIN'];
    $identifiant=isset($_GET['identifiant'])?$_GET['identifiant']:"";

    $size=isset($_GET['size'])?$_GET['size']:6;
    $page=isset($_GET['page'])?$_GET['page']:1;
    $offset=($page-1)*$size;

    if($code_envoi==""){
      $requete=" SELECT c.* FROM collection  as c
      join commande as co on c.code_commande = co.code_commande
      where CIN = '$CIN' and co.identifiant like '%$identifiant%'
      group by date_col desc
      limit $size
      offset $offset" ;
      $requeteCount="select count(code_col) countCOL from collection as c
      join commande as co on c.code_commande = co.code_commande 
      where CIN = '$CIN' and co.identifiant like '%$identifiant%'";
    }else{
        $requete=" SELECT c.* FROM collection  as c
        join commande as co on c.code_commande = co.code_commande
        where CIN = '$CIN' and co.code_commande like '%$code_envoi%'
        and co.identifiant like '%$identifiant%'
        group by date_col desc    
        limit $size
        offset $offset" ;
        $requeteCount="select count(code_col) countCOL from collection as c
        join commande as co on c.code_commande = co.code_commande 
        where CIN = '$CIN' and co.identifiant like '%$identifiant%'
        and co.code_commande like '%$code_envoi%' ";
    }
   
  
     }

    elseif($role=='admin') {
        
        $code_ce= $_SESSION["user"]['code_centre'];
        $identifiant=isset($_GET['identifiant'])?$_GET['identifiant']:"";
    
        $size=isset($_GET['size'])?$_GET['size']:6;
        $page=isset($_GET['page'])?$_GET['page']:1;
        $offset=($page-1)*$size;
    
        if($identifiant==""){

          $requete=" SELECT c.*,u.nom,u.gsm FROM collection  as c
          join utilisateur as u on c.CIN = u.CIN 
          where code_centre = '$code_ce'
          group by date_col desc
          limit $size
          offset $offset" ;
          $requeteCount="select count(code_col) countCOL from collection as c
          join utilisateur as u on c.CIN = u.CIN 
          where code_centre = '$code_ce'";

        }else{

            $requete=" SELECT c.*,u.nom,u.gsm FROM collection  as c
            join utilisateur as u on c.CIN = u.CIN 
            where code_centre = '$code_ce' and c.CIN like '%$identifiant%'
            group by date_col desc
            limit $size
            offset $offset" ;
            $requeteCount="select count(code_col) countCOL from collection as c
            join utilisateur as u on c.CIN = u.CIN 
            where code_centre = '$code_ce' and c.CIN like '%$identifiant%' ";

        }
        
         }
    
      
      $resultatC = mysqli_query($conn, $requete);
      
      $resultatCount = mysqli_query($conn, $requeteCount);
      $tabCount=$resultatCount->fetch_assoc();
      $nbrc=$tabCount['countCOL'];
    
      $reste = $nbrc % $size;   // % operateur modulo: le reste de la division 
        //euclidienne de $nbrFiliere par $size
        if ($reste === 0) //$nbrFiliere est un multiple de $size
            $nbrPage = $nbrc / $size;
        else
            $nbrPage = floor($nbrc/ $size) + 1;  // floor : la partie entière d'un nombre décimal    
  ?>
<!DOCTYPE html>
<html>
<head>
<script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
<link rel="stylesheet" href="../css/styles.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link rel="stylesheet" href="../css/monstyle.css">

</head>
<body>
<?php include("menu.php"); ?>
<div class="container">
            <div class="panel panel-success margetop60">
          
				<div class="panel-heading">
                    <fieldset class=" row mb-3 border border-1 border-primary m-5 p-2 ">
                        <legend>Rechercher des Collectes</legend>
				<div class="panel-body">
					
					<form method="get" action="collect.php" class="form-inline ">
                        <input type="text" name="identifiant" 
                                   placeholder="Identifiant "
                                   class="form-control w-25"
                                   value="<?php echo $identifiant ?>"/>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <?php if($role=="collecteur") { ?>
                            <input type="text" name="code_envoi" 
                                   placeholder="Code de commande "
                                   class="form-control w-50"
                                   value=""/> <?php }?>
                                   <br>
				        <button type="submit" class="btn btn-outline-success p-1">
                        <i class="fa fa-search"></i>
                            Chercher...
                        </button> 
                            </fieldset>    
					</form>


				</div>
			</div>
           <?php  if (isset($_SESSION['status'])) 
      {?>
        <div class="alert alert-success" role="alert">
  <h4 class="alert-heading"><?php echo  $_SESSION['user']['nom'] ?></h4>
  <p></p>
  <hr>
  <p class="mb-0"> <?php echo($_SESSION['status']);?></p>
</div>
        <?php
        unset($_SESSION['status']);
      }?>
            
            
            <div class="panel panel-primary">
                <div class="panel-heading"> Liste des collectes << <?php echo $nbrc ?> collection (s) >> <?php if (!empty($erreurLogin)) { ?>
                    <div class="alert alert-danger">
                        
                    </div>
                <?php } ?></div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                            <?php if($role=="admin"){ ?>
                                    <th>Nom </th>
                                    <th>N° tél de collecteur</th>
                                    <?php }?>
                                    <th>code collection</th>
                                    <th>code_commane</th>
                                    <th>date de collection </th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php while($collection=$resultatC->fetch_assoc()){?>
                                <tr>
                                    <?php if($role=="admin"){ ?>
                                    <td><?php echo $collection['nom'] ?> </td>
                                    <td>0<?php echo $collection['gsm'] ?> </td>
                                    <?php }?>
                                    <td><?php echo $collection['code_col'] ?> </td>
                                    <td><?php echo $collection['code_commande'] ?> </td>
                                    <td><?php echo $collection['date_col'] ?> </td>
                                </tr>
                            <?PHP } ?>
                       </tbody>
                    </table>
                <div>
                    <ul class="pagination">
                        <?php for($i=1;$i<=$nbrPage;$i++){ ?>
                            <button type="button" class="btn btn-outline-primary">
                                    <a style="color: black;" href="collect.php?page=<?php echo $i;?>&identifiant=<?php echo $identifiant?>">
                                    <?php echo $i; ?>
                                </a> 
                             </li></button>&nbsp
                        <?php } ?>
                    </ul>
                </div>
                </div>
            </div>
        </div>
  
</body>
</html>

