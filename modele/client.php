<?php
include("connexion.php");

class Client extends Connexion {

    private $_table = "client";

    // Fonction d'inscription
	public function inscription($nom, $username, $datenaissance, $addresse, $password, $is_admin) {
		$sql = "INSERT INTO {$this->_table} (nom_client, Email, date_naissance, adresse, MDP, Nb_emprunt, Date_inscription, is_admin) 
				VALUES ('$nom', '$username', '$datenaissance', '$addresse', '$password', 0, NOW(), $is_admin)";
		$req = $this->getPDO()->query($sql);
	}
    
    

// Fonction d'authentification
public function valide($email, $mdp) {
    $sql = "SELECT * FROM {$this->_table} WHERE Email = :email";
    $req = $this->getPDO()->prepare($sql);
    $req->execute(['email' => $email]);

    if ($data = $req->fetch()) {
        // Vérification du mot de passe
        if ($mdp === $data['MDP']) { // Comparaison directe
            return $data; // Renvoie les données du client
        } else {
            return false; // Mot de passe incorrect
        }
    } else {
        return false; // Aucun utilisateur trouvé
    }
}
    
    
    


    // Fonction pour vérifier si un email existe déjà
    public function emailExiste($email) {
        $sql = "SELECT COUNT(*) FROM {$this->_table} WHERE Email = :email";
        $req = $this->getPDO()->prepare($sql);
        $req->execute(['email' => $email]);
        $count = $req->fetchColumn();

        // Si le nombre est supérieur à 0, l'email existe déjà
        return $count > 0;
    }

    // Fonction pour afficher les livres empruntés par un client
    public function livre_emprunt($idclient) {
        $emprunt = array();
        $sql = "SELECT * FROM emprunter e , livre l WHERE e.ISBN = l.ISBN AND e.id_client = :idclient";
        $req = $this->getPDO()->prepare($sql);
        $req->execute(['idclient' => $idclient]);

        while ($data = $req->fetch()) {
            $emprunt[] = $data;
        }

        return $emprunt;
    }

    // Fonction pour modifier les informations d'un client
    public function modification($idclient, $nomclient, $email, $datenaissance, $adresse, $mdp) {
        $sql = "UPDATE {$this->_table} SET nom_client = :nom, Email = :email, date_naissance = :datenaissance, adresse = :adresse, MDP = :mdp WHERE id_client = :idclient";
        $req = $this->getPDO()->prepare($sql);
        $req->execute([
            'nom' => $nomclient,
            'email' => $email,
            'datenaissance' => $datenaissance,
            'adresse' => $adresse,
            'mdp' => password_hash($mdp, PASSWORD_BCRYPT),
            'idclient' => $idclient
        ]);
    }

    // Fonction pour emprunter un livre et mettre à jour le nombre d'emprunts
    public function emprunter_Livre($isbn, $idclient, $nbremp) {
        $sql1 = "UPDATE livre SET etat = 1 WHERE ISBN = :isbn";
        $req1 = $this->getPDO()->prepare($sql1);
        $req1->execute(['isbn' => $isbn]);

        $sql2 = "UPDATE client SET Nb_emprunt = :nbremp WHERE id_client = :idclient";
        $req2 = $this->getPDO()->prepare($sql2);
        $req2->execute(['nbremp' => $nbremp, 'idclient' => $idclient]);

        $sql3 = "INSERT INTO emprunter (id_client, ISBN, date_emprunt) VALUES (:idclient, :isbn, NOW())";
        $req3 = $this->getPDO()->prepare($sql3);
        $req3->execute(['idclient' => $idclient, 'isbn' => $isbn]);
    }

}

?>
