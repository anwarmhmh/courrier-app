
<?php

    require_once('identifier.php');
    require_once("connexiondb.php");

    $nomU=isset($_GET['nomC'])?$_GET['nomC']:"";
    $CIN=isset($_GET['CIN'])?$_GET['CIN']:"";

    $currentU=  $_SESSION['user']['code_centre'];

    $size=isset($_GET['size'])?$_GET['size']:6;
    $page=isset($_GET['page'])?$_GET['page']:1;
    $offset=($page-1)*$size;

    
      $requete="SELECT * FROM utilisateur 
      WHERE code_centre ='$currentU' AND nom like '%$nomU%' and
      CIN like '%$CIN%' and role='collecteur'  
      limit $size
      offset $offset ";
      
      $requeteCount="select count(*) countU from utilisateur 
      WHERE code_centre ='$currentU' AND nom like '%$nomU%' and
      CIN like '%$CIN%' and role='collecteur' ";
  
  
    $resultatU = mysqli_query($conn, $requete);
  
    $resultatCount = mysqli_query($conn, $requeteCount);
    $tabCount=$resultatCount->fetch_assoc();
    $nbrU=$tabCount['countU'];

    $reste=$nbrU % $size;   // % operateur modulo: le reste de la division 
                                 //euclidienne de $nbrclient par $size
    if($reste===0) //$nbrclient est un multiple de $size
        $nbrPage=$nbrU/$size;   
    else
        $nbrPage=floor($nbrU/$size)+1;  // floor : la partie entière d'un nombre décimal

       
  ?>
<!DOCTYPE html>
<html>
<head>
<script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
<link rel="stylesheet" href="../css/styles.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link rel="stylesheet" href="../css/monstyle.css">
<title>Collecteur</title>
</head>
<body>
<?php include("menu.php"); ?>

<div class="container">
            <div class="panel panel-success margetop60">
          
				<div class="panel-heading">
                <fieldset class=" row mb-3 border border-1 border-primary m-5 p-2 ">
                        <legend>Rechercher des Collecteurs</legend>
				<div class="panel-body">
					
					<form method="get" action="collecteur.php" class="form-inline">
					
						            

                        <input type="text" name="CIN" 
                                   placeholder="CIN du Collecteur"
                                   class="form-control  w-50"
                                   value="<?php echo  $CIN ?>"/>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            
                            <input type="text" name="nomU" 
                                   placeholder="Nom de Collecteur"
                                   class="form-control  w-50"
                                   value="<?php echo $nomU ?>"/>
                                   
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
                <div class="panel-heading">Liste des Collecteurs << <?php echo $nbrU ?> Collecteur (s)  >> <?php if (!empty($erreurLogin)) { ?>
                    <div class="alert alert-danger">
                        
                    </div>
                <?php } ?></div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                            <th>CIN</th><th>Nom</th> <th>N° tél</th><th>email</th>
                                <?php if ($_SESSION['user']['role']== 'admin') {?>
                                	<th>Actions</th>
                                <?php }?>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php while($u=$resultatU->fetch_assoc()){ ?>
                                <tr>
                                    <td><?php echo $u['CIN'] ?> </td>
                                    <td><?php echo $u['nom'] ?> </td> 
                                    <td><?php echo $u['gsm'] ?> </td>
                                    <td><?php echo $u['email'] ?> </td>

                                    
                                     <?php if ($_SESSION['user']['role']== 'admin') {?>
                                        <td>
                                            <a href="editerCollecteur.php?CIN=<?php echo $u['CIN'] ?>">
                                            <i class="fa fa-pencil-square" ></i></a>                                             
                                            &nbsp;
                                            
                                        </td>
                                    <?php }?>
                                
                                </tr>
                            <?PHP } ?>
                       </tbody>
                    </table>
                <div>
                    <ul class="pagination">
                        <?php for($i=1;$i<=$nbrPage;$i++){ ?>
                            <button type="button" class="btn btn-outline-primary">
                            <li class="<?php if($i==$page) echo 'active' ?>"> 
            <a style="color: black;" href="Client.php?page=<?php echo $i;?>&nom=<?php echo $nomC ?>&type_c=<?php echo $type_c ?>">
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

