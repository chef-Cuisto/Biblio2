

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
            <li class="active"><a href="index.php">Acceuil</a></li>
   <?php 
 
  if(!$_SESSION['connecter']){//si connecter il n,affiche pas else il affiche
  ?>
           <li><a href="inscription.php">Inscription</a></li>
    <?php
  }
    ?> 
           <li><a href="reglement.php" >Reglement</a></li>
           <li><a href="#" >Catalogue</a></li>
           <li><a href="bibliotheque.php" >Notre Bibliotheque</a></li>
  </ul>
</div>

<div class="col-lg-6">
 <div id="iscri">
  <?php 
  if(!$_SESSION['connecter']){
  ?>
        <form method="post" action="" > 
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
      <li class="active"><a href="profil.php" >Profile</a></li>
      <li><a href="index.php?d=true" >Deconnecter</a></li>
 
  </ul>

</div>

    <?php
    }
    ?>

  </div> 
</div>