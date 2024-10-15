<?php
session_start();
include("modele/client.php");

$message = ''; // Variable pour stocker le message

if (!isset($_SESSION['connecter'])) {
    $_SESSION['connecter'] = false;
}

if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['nom']) && !empty($_POST['datenaissance']) && !empty($_POST['addresse'])) {
  $client = new Client();
  try {
      // Inscription avec prise en compte du statut admin (sans vérification)
      $is_admin = isset($_POST['is_admin']) ? 1 : 0;

      // Procéder à l'inscription
      $client->inscription($_POST['nom'], $_POST['username'], $_POST['datenaissance'], $_POST['addresse'], $_POST['password'], $is_admin);
      echo "<script>alert('Inscription réussie!');</script>";
  } catch (Exception $e) {
      echo "<script>alert('" . $e->getMessage() . "');</script>";
  }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="CSS/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="CSS/theme.css"/>
    <title>Inscription</title>
    <script type="text/javascript"></script>
    <script type="text/javascript">
        // Si un message est défini en PHP, l'afficher dans une alerte JS
        <?php if (!empty($message)): ?>
            alert("<?php echo $message; ?>");
        <?php endif; ?>
    </script>
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
  <ul class="nav nav-pills">
      <li><a href="index.php">Accueil</a></li>
       <?php 

  if(!$_SESSION['connecter']){
  ?>
      <li class="active"><a href="inscription.php">Inscription</a></li>
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
        <form method="post" action="index.php" > 
            <input type="text" name="email" placeholder="Email" required />
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
      <li  class="active"><a href="profil.php" >Profile</a></li>
      <li><a href="index.php?d=true" >Deconnecter</a></li>
 
  </ul>

</div>

<?php

}

?>

    </div> 
</div>


<div class="row">



  <div class="col-lg-12">




<div class="panel panel-success panel1" >
  <div class="panel-heading">Inscription</div>
  <div class="panel-body">
    <fieldset>
	<legend><b>Inscripton Individuelle</b></legend>


  <form action="inscription.php" method="post">
    <table class="login_table">
        <tr>
            <td>Email<span>*</span></td>
            <td><input type="Email" name="username" id="username" placeholder="email" required></td>
        </tr>
        <tr>
            <td>Password<span>*</span></td>
            <td><input type="password" name="password" id="password" placeholder="password" required></td>
        </tr>
        <tr>
            <td>Nom<span>*</span></td>
            <td><input type="text" name="nom" id="nom" placeholder="Nom" required></td>
        </tr>
        <tr>
            <td>Date-naissance<span>*</span></td>
            <td><input type="date" name="datenaissance" id="datenaissance" placeholder="AAAA-MM-JJ" required></td>
        </tr>
        <tr>
            <td>Adresse <span>*</span></td>
            <td><input type="text" name="addresse" id="addresse" placeholder="Adresse" required></td>
        </tr>
        <tr>
            <td><small>Admin</small></td>
            <td><input type="checkbox" name="is_admin" value="1"></td>
        </tr>
        <tr>
            <td><input type="submit" value="Inscription"/></td>
            <td><input type="reset" value="Recommencer"/></td>
        </tr>
    </table>
</form>



</fieldset>

<div id="reglement_ecrire"><h2>Carte « Adhérent »</h2>
<ul><li> Une carte « Adhérent » sera délivrée aux nouveaux clients. Cette carte doit être présentée à chaque visite de la bibliothèque et est obligatoire pour toute opération de prêt.</li></ul>

    </div>
  </div>
</div>
     
  </div>
</div>
<?php
include('composant/footer.php')
?>
</body>
</html>




