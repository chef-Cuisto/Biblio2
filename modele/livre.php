<?php

require_once('connexion.php');

class Livre extends Connexion {
    private $table = "livre";

    public function afficher($var, $next, $nex) {
        // Validation des valeurs de $next et $nex
        $next = max(0, (int)$next); // Si $next est négatif, le mettre à 0
        $nex = max(1, (int)$nex);   // Si $nex est négatif, le mettre à 1

        $livre = array();
		$sql = "SELECT DISTINCT * 
        FROM livre l
        JOIN ecrire e ON e.ISBN = l.ISBN 
        JOIN auteur a ON a.id_auteur = e.id_auteur 
        WHERE l.titre_livre LIKE :var 
           OR l.type_livre LIKE :var 
           OR a.nom_auteur LIKE :var 
        GROUP BY l.ISBN
        ORDER BY l.ISBN 
        LIMIT :next, :nex";


        try {
            $connex = new Connexion();
            $stmt = $connex->getPDO()->prepare($sql);
            // Liaison des paramètres
            $stmt->bindValue(':var', "%$var%", PDO::PARAM_STR);
            $stmt->bindValue(':next', $next, PDO::PARAM_INT);
            $stmt->bindValue(':nex', $nex, PDO::PARAM_INT);
            
            $stmt->execute();
            
            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $livre[] = $data;
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }

        return $livre;
    }

    public function afficher_infolivre($isbn) {
        $livre = array();
        $sql = "SELECT * FROM livre WHERE ISBN = :isbn";

        try {
            $connex = new Connexion();
            $stmt = $connex->getPDO()->prepare($sql);
            $stmt->bindValue(':isbn', $isbn, PDO::PARAM_STR);
            $stmt->execute();
            $livre[] = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }

        return $livre;
    }

    public function afficher_info_auteur($isbn) {
        $auteur = array();
        $sql = "SELECT * FROM ecrire e JOIN auteur a ON e.id_auteur = a.id_auteur WHERE e.ISBN = :isbn";

        try {
            $connex = new Connexion();
            $stmt = $connex->getPDO()->prepare($sql);
            $stmt->bindValue(':isbn', $isbn, PDO::PARAM_STR);
            $stmt->execute();
            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $auteur[] = $data;
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }

        return $auteur;
    }

    public function next($limit1, $limit2) {
        $limit1 += 6;
        $limit2 += 6;
    }

    public function previous($limit1, $limit2) {
        $limit1 -= 6;
        $limit2 -= 6;
    }
}
?>
