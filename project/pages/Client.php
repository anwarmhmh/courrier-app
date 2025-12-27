
<?php

    require_once('identifier.php');
    require_once("connexiondb.php");

    $nomC=isset($_GET['nomC'])?$_GET['nomC']:"";
    $identifiant=isset($_GET['identifiant'])?$_GET['identifiant']:"";
    $type_c=isset($_GET['type_c'])?$_GET['type_c']:"all";

    $currentU=  $_SESSION['user']['code_centre'];

    $size=isset($_GET['size'])?$_GET['size']:8;
    $page=isset($_GET['page'])?$_GET['page']:1;
    $offset=($page-1)*$size;

    if($type_c=="all"){
      $requete="SELECT distinct  c.* FROM client AS c
      JOIN centre AS cen ON c.code_ville = cen.code_ville
      JOIN utilisateur AS u ON cen.code_centre = u.code_centre
      WHERE cen.code_centre ='$currentU' AND c.nom like '%$nomC%' and
      c.identifiant like '%$identifiant%' group by date_in desc 
      limit $size
      offset $offset " ;
      
      $requeteCount="select count(distinct identifiant) countC from client AS c
      JOIN centre AS cen ON c.code_ville = cen.code_ville
      JOIN utilisateur AS u ON cen.code_centre = u.code_centre
      WHERE cen.code_centre ='$currentU' AND c.nom like '%$nomC%' and
      c.identifiant like '%$identifiant%' ";
      ;
  }else{
       $requete="select c.* from client AS c
       JOIN centre AS cen ON c.code_ville = cen.code_ville
       JOIN utilisateur AS u ON cen.code_centre = u.code_centre
       WHERE cen.code_centre ='$currentU' and type_c='$type_c' AND c.nom like '%$nomC%' and
       c.identifiant like '%$identifiant%'  group by date_in
       limit $size
       offset $offset";
      
      $requeteCount="select count(distinct identifiant) countC from client AS c
      JOIN centre AS cen ON c.code_ville = cen.code_ville
      JOIN utilisateur AS u ON cen.code_centre = u.code_centre
      WHERE cen.code_centre ='$currentU' AND c.nom like '%$nomC%' and
      c.identifiant like '%$identifiant%' and type_c='$type_c'" ;
  }
  
  $resultatC = mysqli_query($conn, $requete);
  
  $resultatCount = mysqli_query($conn, $requeteCount);
  $tabCount=$resultatCount->fetch_assoc();
  $nbrc=$tabCount['countC'];

  $reste = $nbrc % $size;   // % operateur modulo: le reste de la division 
    //euclidienne de $nbrFiliere par $size
    if ($reste === 0) //$nbrFiliere est un multiple de $size
        $nbrPage = $nbrc / $size;
    else
        $nbrPage = floor($nbrc
     / $size) + 1;  // floor : la partie entière d'un nombre décimal

       
  ?>    
<!DOCTYPE html>
<html>
<head>
<script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
<link rel="stylesheet" href="../css/styles.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link rel="stylesheet" href="../css/monstyle.css">
<title>Client</title>
</head>
<body>
    <?php include("menu.php"); ?>
    <div class="container">
        <div class="panel panel-success margetop60">
			<div class="panel-heading">
                <fieldset class=" row mb-3 border border-1 border-primary m-5 p-2 ">
                    <legend>Rechercher des clients</legend>
				    <div class="panel-body">
					    <form method="get" action="Client.php" class="form-inline ">
					        Selectionner Type de client : 
                            <label> <input type="radio" name="type_c" value="P" hidden  <?php if($type_c==="all") echo "selected" ?> panel-heading>   </label>
                            <label> <input type="radio" name="type_c" value="P"  <?php if($type_c==="P") echo "selected" ?>>  pérsonne </label>
                            <label> <input type="radio" name="type_c" value="A" <?php if($type_c==="A") echo "selected" ?>>  association </label>
                            <label> <input type="radio" name="type_c" value="S" <?php if($type_c==="S") echo "selected" ?>>  société </label>
                            <input type="text" name="identifiant" placeholder="Identifiant du client"class="form-control w-25"value="<?php echo  $identifiant ?>"/>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="text" name="nomC" placeholder="Nom de Client"class="form-control w-50"value="<?php echo $nomC ?>"/><br>
				            <button type="submit" class="btn btn-outline-success p-1"><i class="fa fa-search"></i>Chercher...</button> 
                        </form>
                    </div>
                </fieldset>
			</div>
           <?php  if (isset($_SESSION['status'])) {?>
            <div class="alert alert-success" role="alert">
                <h4 class="alert-heading"><?php echo  $_SESSION['user']['nom'] ?></h4>
                <p></p><hr><p class="mb-0"> <?php echo($_SESSION['status']);?></p>
            </div>
            <?php unset($_SESSION['status']);}?>
            <div class="panel panel-primary">
                <div class="panel-heading">Liste des Clients  << <?php echo $nbrc ?> Client (s) >> <?php if (!empty($erreurLogin)) { ?>
                    <?php } ?></div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Nom</th><th>email</th><th>adresse</th><th>date d'inscription</th><th>N° tél</th>
                                    <?php if ($_SESSION['user']['role']== 'admin') {?>  <th>Actions</th>  <?php }?>
                                </tr>
                            </thead>
                        
                            <tbody>
                                <?php while($client=$resultatC->fetch_assoc()){ ?>
                                <tr>
                                    <td><?php echo $client['nom'] ?> </td>
                                    <td><?php echo $client['email'] ?> </td> 
                                    <td><?php echo $client['adresse'] ?> </td>
                                    <td><?php echo $client['date_in'] ?> </td>
                                    <td><?php echo $client['gsm'] ?> </td>
                                     <?php if ($_SESSION['user']['role']== 'admin') {?>
                                    <td>
                                        <a href="editerClient.php?identifiant=<?php echo $client['identifiant'] ?>">
                                        <i class="fa fa-pencil-square" ></i></a>       &nbsp;
                                        <?php if ($client['statu']== 'desactive') {?>
                                        <a onclick="return confirm('Etes vous sur de vouloir activer le Client ')"
                                            href="activerClient.php?identifiant=<?php echo $client['identifiant'];?>&statu=<?php echo $client['statu']?>">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                        </a><?php }?>
                                        <?php if ($client['statu']== 'active') {?>
                                        <a onclick="return confirm('Etes vous sur de vouloir desactiver le Client ')" 
                                            href="activerClient.php?identifiant=<?php echo $client['identifiant'];?>&statu=<?php echo $client['statu']?>">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </a><?php }?>
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
        </div>
</body>
</html>

