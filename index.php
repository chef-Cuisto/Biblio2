<?php
session_start();

include("modele/client.php");
include("modele/livre.php");

// Initialisation des variables de pagination
if (!isset($_SESSION['next'])) {
    $_SESSION['next'] = 0; // Valeur par défaut
}
if (!isset($_SESSION['nex'])) {
    $_SESSION['nex'] = 6; // Valeur par défaut
}

// Gestion de la pagination
if (isset($_GET['passer']) && $_GET['passer'] == 'next') {
    $_SESSION['next'] += 6; // Ajustement de l'index
    $_SESSION['nex'] += 6;   // Ajustement du nombre à afficher
} else if (isset($_GET['passer']) && $_GET['passer'] == 'previous') {
    $_SESSION['next'] = max(0, $_SESSION['next'] - 6); // Ne pas descendre en dessous de 0
    $_SESSION['nex'] = max(6, $_SESSION['nex'] - 6);   // Garde une valeur minimale de 6 pour nex
}

// Vérification de la variable de session pour la connexion
if (isset($_SESSION['connecter'])) { 
    if (isset($_GET['d'])) {
        session_destroy();
        $_SESSION['connecter'] = false;
    }
}

// Si la variable 'connecter' n'est pas définie, la définir comme faux
if (!isset($_SESSION['connecter'])) {
    $_SESSION['connecter'] = false; 
}

// Vérification de l'authentification
if (!empty($_POST['Email']) && !empty($_POST['pwd'])) {
  $client1 = new Client();
  // Fonction valide pour chercher si le client existe
  $client = $client1->valide($_POST['Email'], $_POST['pwd']);
  
  if ($client) { // Vérifie que $client n'est pas false
      $_SESSION['connecter'] = true;

      // Stocke toutes les variables dans la session pour travailler sur toutes les pages
      $_SESSION['id_client'] = $client['id_client'];
      $_SESSION['nom_client'] = $client['nom_client'];
      $_SESSION['Email'] = $client['Email'];
      $_SESSION['date_naissance'] = $client['date_naissance'];
      $_SESSION['adresse'] = $client['adresse'];
      $_SESSION['MDP'] = $client['MDP'];
      $_SESSION['is_admin'] = $client['is_admin']; // Assure-toi que 'is_admin' est bien dans ton tableau
      $_SESSION['Nb_emprunt'] = $client['Nb_emprunt'];
      $_SESSION['Date_inscription'] = $client['Date_inscription'];
  } else {
      ?>      
      <script type="text/javascript"> window.alert('Email ou mot de passe incorrect!');</script>
      <?php
  }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="CSS/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="CSS/theme.css"/>
    <script type="text/javascript" src="JQ/jquery-2.2.1.min.js"></script>
  <title>Accueil</title>
</head>

<body>
<div class="jumbotron">
      <div class="col-lg-8">
          <img src="IMG\logo-header.png" class="logo" alt="logo"> 
          
      </div>
      <div class="col-lg-4">
          <div id="logoright">La Bibliotheque virtuelle</div>
      </div>
</div>

<div class="col-lg-6">
  <ul class="nav nav-pills nav1">
            <li class="active"><a href="index.php">Accueil</a></li>
   <?php 
 
  if(!$_SESSION['connecter']){//si connecter il n,affiche pas else il affiche
  ?>
           <li><a href="inscription.php">Inscription</a></li>
    <?php
  }
    ?> 
           <li><a href="reglement.php" >Reglement</a></li>
          
           <li><a href="bibliotheque.php" >Notre Bibliotheque</a></li>
  </ul>
</div>

<div class="col-lg-6">
 <div id="iscri">
  <?php 
  if(!$_SESSION['connecter']){
  ?>
        <form method="post" action="" > 
            <input type="text" name="Email" placeholder="Email" required />
            <input type="password" name="pwd" placeholder="Mot de Passe" required />
            <input type="submit" value="Login"/>
        </form>  
      
    <?php
  }else{
    ?> 

 <div class="col-lg-7">
 </div>
 <div class="col-lg-5">
 <ul class="nav nav-pills">
      <li class="active"><a href="profil.php" >Profile</a></li>
      <li><a href="index.php?d=true" >Deconnecter</a></li>
 
  </ul>

</div>

    <?php
    }
    ?>

  </div> 
</div>

<div class="row">

<?php
include('composant/menu.php');
?>

  <div class="col-lg-9">
  <h2> Accueil</h2>
    <div class="panel panel-default panel2">
      <div class="panel-heading">Page d'Accueil</div>
      <div class="panel-body">
        <div class="row">
          

<?php
$liv = new Livre();


if(isset($_GET['passer']) AND $_GET['passer']=='next'){
$liv->next($_SESSION['next'],$_SESSION['nex']);
}else{ 
  if(isset($_GET['passer']) AND $_GET['passer']=='previous'){
$liv->previous($_SESSION['next'],$_SESSION['nex']);

  }else{

    $_SESSION['next']=0;
    $_SESSION['nex']=6;
  }
}

if(empty($_GET['chercher'])){
$_GET['chercher']="Roman";
}

$leslivre = $liv->afficher($_GET['chercher'],$_SESSION['next'],$_SESSION['nex']);
$annule_next=0;
 foreach($leslivre as $livre){

?>
            <div class="col-sm-6 col-md-4 book1">
              <div class="thumbnail height">
                <?php echo '<img src='.$livre['img_livre'].' alt="" />'; ?>
                    
                <div class="caption">
                 <h2><?php echo $livre['titre_livre'] ?></h2>
                    <p><?php echo $livre['Paragraphe'] ?>"</p>
                  
                  <p><a href="consultation.php?ISBN=<?php echo $livre['ISBN'] ?>" class="btn btn-primary" role="button">Consulter</a> <?php if($_SESSION['connecter']==true && $livre['etat']==0 ){?><a href="consultation.php?ISBN=<?php echo $livre['ISBN'] ?>" class="btn btn-default" role="button">emprunter</a>
                      
                    
                      
                      
                      <?php } ?></p>
                </div>
              </div>
            </div>
           
<?php $annule_next++;} ?>

          </div>
      
            <ul class="pager">

    <?php if($_SESSION['next']!=0){ ?>
              <li><a href="index.php?chercher=<?php echo $_GET['chercher']; ?>&passer=previous">previous</a></li>

              <?php } 
              if($annule_next>=6){ 
                ?>
              <li><a href="index.php?chercher=<?php echo $_GET['chercher']; ?>&passer=next">next</a></li>
             <?php } ?>
            </ul>
      </div>
    </div>
  </div>
</div>


<?php
include('composant/footer.php');

?>


</body>
</html>










