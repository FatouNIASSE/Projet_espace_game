<?php
namespace App\Models;
use CodeIgniter\Model;

/* *****************************************************************************************************
 * Nom du fichier : Db_model.php
 * _____________________________________________________________________________________________________
 * Description : Modèle de base de données pour l'interaction avec la base de données de l'application.
 * _____________________________________________________________________________________________________
 * Auteur :Fatou NIASSE
 * *****************************************************************************************************/

class Db_model extends Model
{
    protected $db;
    public function __construct()
    {
        $this->db = db_connect(); //charger la base de données
        // ou
        // $this->db = \Config\Database::connect();
    }

    
    /********************************************************
     * Récupère tous les comptes et retourne les résultats.
     */

    public function get_all_compte($user)
    {
        $resultat = $this->db->query(" SELECT* FROM T_COMPTE_CPT JOIN T_PROFIL_PRO USING(CPT_id) EXCEPT SELECT* FROM T_COMPTE_CPT JOIN T_PROFIL_PRO USING(CPT_id) Where CPT_login ='".$user."' ORDER BY PRO_validite ASC");
        return $resultat->getResultArray();
    }

      /***********************************************************
     * Récupère d'un pseudo et mdp existant.
     */

      public function existeCompte($pseudo)
        {
              $requete=("SELECT * FROM T_COMPTE_CPT JOIN T_PROFIL_PRO USING(CPT_id) Where CPT_login ='".$pseudo."';");
                $resultat = $this->db->query($requete);
                $row =  $resultat->getRow();
                return $row->CPT_login;
        }

    
    
    /*****************************************
     * Récupère le nombre total de comptes.
     */
    public function get_count_compte()
    {
        $requete=("SELECT COUNT(*) AS TotalComptes FROM T_COMPTE_CPT;");
        $resultat = $this->db->query($requete);
        $row =  $resultat->getRow();
        return $row->TotalComptes;
    }

    /***********************************************************
     * Récupère une actualité spécifique en fonction de l'id.
     */
    public function get_actualite($numero)
    {
        $requete="SELECT * FROM T_ACTUALITE_ACT  WHERE ACT_id=".$numero.";";
        $resultat = $this->db->query($requete);
        return $resultat->getRow();
    }

   /*************************************************************************************************
     * Récupère toutes les actualités avec des informations sur l'auteur dans un Tableau associatif 
     */
    public function get_all_actualite()
    {
        $resultat = $this->db->query("SELECT ACT_intitule,ACT_etat,ACT_description,ACT_date, CONCAT(PRO_nom,'  ', PRO_prenom) AS Auteur
        from T_ACTUALITE_ACT
        JOIN T_COMPTE_CPT USING(CPT_id)
        JOIN T_PROFIL_PRO USING(CPT_id)
        WHERE ACT_etat = 'A'
        ORDER BY ACT_date DESC;");
        return $resultat->getResultArray();
    }

    /**********************************************************************
     * Récupère tous les informations  des scénarios sous forme de galerie.
     */
    public function get_all_scenarios()
    {
        $resultat = $this->db->query("SELECT DISTINCT SCE_intituler, SCE_image, CONCAT(PRO_nom, ' ', PRO_prenom) as Auteur,SCE_code,SCE_activite,SCE_description,CPT_login
        FROM T_SCENARIO_SCE 
        JOIN T_COMPTE_CPT USING(CPT_id)
        JOIN T_PROFIL_PRO USING(CPT_id)
        Where SCE_activite = 'A';");
        return $resultat->getResultArray();
    }


    /*public function get_etapes($code)
    {
        $resultat = $this->db->query("SELECT ETP_intituler, ETP_description, ETP_ordre, IDE_description, T_RESSOURCE_RSC.RSC_id
        FROM T_SCENARIO_SCE
        LEFT JOIN T_ETAPE_ETP USING(SCE_id)
        LEFT JOIN T_INDICE_IDE ON T_ETAPE_ETP.ETP_id = T_INDICE_IDE.ETP_id AND T_INDICE_IDE.IDE_niveau = 1
        LEFT JOIN T_RESSOURCE_RSC ON T_ETAPE_ETP.RSC_id = T_RESSOURCE_RSC.RSC_id 
        WHERE SCE_code='".$code."' AND ETP_ordre =1;");
        return $resultat->getResultArray();
    }*/

    /*****************************************************************************
     * Récupère les détails pour jouer un scénario spécifique à un niveau donné.
     
    public function get_jouer($code,$niveau)
    {
        $resultat = $this->db->query("SELECT ETP_reponse, ETP_intituler, ETP_description, ETP_ordre, IDE_description, T_RESSOURCE_RSC.RSC_id, IDE_niveau, IDE_lien
        FROM T_SCENARIO_SCE
        LEFT JOIN T_ETAPE_ETP USING(SCE_id)
        LEFT JOIN T_INDICE_IDE ON T_ETAPE_ETP.ETP_id = T_INDICE_IDE.ETP_id AND T_INDICE_IDE.IDE_niveau = ".$niveau."
        LEFT JOIN T_RESSOURCE_RSC ON T_ETAPE_ETP.RSC_id = T_RESSOURCE_RSC.RSC_id 
        WHERE SCE_code='".$code."'   AND ETP_ordre =1;");
        return $resultat->getResultArray();
    }
*/


    /*****************************************************************************
     * Insertion d'un nouveau compte.
     */
    public function set_compte($saisie)
    {
        //Récuparation (+ traitement si nécessaire) des données du formulaire
        $login=$saisie['pseudo'];
        $mot_de_passe=$saisie['mdp'];
        $sql="INSERT INTO T_COMPTE_CPT VALUES(NULL,'".$login."','".$mot_de_passe."');";
        return $this->db->query($sql);
    }

     /*****************************************************************************
     * Recuperation de l'id du dernier compte.
     */
    public function id_compte()
    {
        $requete="SELECT CPT_id FROM T_COMPTE_CPT ORDER BY CPT_id DESC LIMIT 1;";
        $resultat = $this->db->query($requete);
        $row =  $resultat->getRow();
        return $row->CPT_id;
    }

     /*****************************************************************************
     * Insertion d'un nouveau profil du dernier compte ajouter.
     */
     public function set_profil($saisie,$id,$f)
    {
        //Récuparation (+ traitement si nécessaire) des données du formulaire
        $nom=$saisie['nom'];
        $prenom=$saisie['prenom'];
        $role=$saisie['role'];
        $fichier=$saisie['fichier'];
        $validite=$saisie['validite'];
        $sql="INSERT INTO T_PROFIL_PRO VALUES('".$prenom."','".$nom."','".$role."','".$validite."','".$f."',".$id.");";
        return $this->db->query($sql);
    }


    // Fonction pour obtenir les détails d'un scénario en fonction de son code
    public function get_erreur($code)
    {
        $requete="SELECT *
        FROM T_SCENARIO_SCE where SCE_code = '".$code."' ;";
        $resultat = $this->db->query($requete);
        return $resultat->getRow();
        
    }

     // Fonction pour obtenir les détails d'un scénario en fonction de son code
    public function get_erreur_etap($code)
    {
        $requete="SELECT *
        FROM T_ETAPE_ETP where ETP_code = '".$code."' ;";
        $resultat = $this->db->query($requete);
        return $resultat->getRow();
        
    }


    
    /*****************************************************************
    *Fonction pour vérifier la connexion d'un compte avec un nom d'utilisateur et un mot de passe
    */
        public function connect_compte($u,$p)
    {
        $sal='OnRajouteDuSelPourAllongerleMDP123!!45678__Test';

        $sql="SELECT CPT_login, CPT_mdp
        FROM T_COMPTE_CPT
        WHERE CPT_login='".$u."'
        AND CPT_mdp=SHA2('".$sal.$p."', 256);";
        $resultat=$this->db->query($sql);
        if($resultat->getNumRows() > 0) 
        { 
            return true; 
        } 
        else 
        { 
            return false;
        } 
    }
    
     /*****************************************************************************
     * visualiser les infos du  compte ajouter.
     */
     public function get_profil($use){
        $requete="  SELECT * FROM T_COMPTE_CPT
        JOIN T_PROFIL_PRO USING(CPT_id)
        WHERE  CPT_login='".$use."';";
        $resultat = $this->db->query($requete);
        return $resultat->getRow();
    }

    /***********************************/
    // modification d'un mot de passe
    public function modifier_password($username, $password)
    {
        $sal='OnRajouteDuSelPourAllongerleMDP123!!45678__Test';
        $query ="UPDATE T_COMPTE_CPT SET CPT_mdp = SHA2('".$sal.$password."', 256) where CPT_login='".$username."';";
        return $this->db->query($query);

    }

   /**********************************************************************
     * Récupère tous les informations  des scénarios sous forme de galerie.
     */
    public function get_scenarios($code)
    {
        $resultat = $this->db->query("SELECT *
        FROM T_SCENARIO_SCE
        LEFT JOIN T_ETAPE_ETP USING(SCE_id) where SCE_code ='".$code."';");
        return $resultat->getResultArray();
    }

      /*****************************************
     * Récupère le nombre total des etapes.
     */
      public function get_count_etap()
    {
        // Appel de la procédure stockée
        $query = "CALL GetCountEtap(@Totale_etape)";
        $this->db->query($query);

        // Récupération du résultat
        $result = $this->db->query("SELECT @Totale_etape AS Totale_etape");
        $row = $result->getRow();

        // Retourne le total d'étapes
        return $row->Totale_etape;
    }


    /*****************************************
     * Récupère les informations sur les scénarios et le nombre d'étapes associées
      */
    public function get_total_scenarios()
    {
        $resultat = $this->db->query("
            SELECT DISTINCT
        DISTINCT T_SCENARIO_SCE.SCE_intituler,T_SCENARIO_SCE.SCE_activite,
        T_SCENARIO_SCE.SCE_image,
        COUNT(T_ETAPE_ETP.ETP_id) AS Totale_etape,
        CONCAT(T_PROFIL_PRO.PRO_nom, ' ', T_PROFIL_PRO.PRO_prenom) AS Auteur,
        T_SCENARIO_SCE.SCE_code,
        T_SCENARIO_SCE.SCE_activite,
        T_SCENARIO_SCE.SCE_description,
        T_COMPTE_CPT.CPT_login
    FROM T_PROFIL_PRO
    JOIN T_COMPTE_CPT ON T_PROFIL_PRO.CPT_id = T_COMPTE_CPT.CPT_id
    JOIN T_SCENARIO_SCE ON T_COMPTE_CPT.CPT_id = T_SCENARIO_SCE.CPT_id
    LEFT JOIN T_ETAPE_ETP ON T_SCENARIO_SCE.SCE_id = T_ETAPE_ETP.SCE_id
    GROUP BY
        T_SCENARIO_SCE.SCE_intituler,
        T_SCENARIO_SCE.SCE_image,
        T_SCENARIO_SCE.SCE_code,
        T_SCENARIO_SCE.SCE_activite,
        T_SCENARIO_SCE.SCE_description,
        T_SCENARIO_SCE.SCE_activite,
        T_COMPTE_CPT.CPT_login,
        T_PROFIL_PRO.PRO_nom,
        T_PROFIL_PRO.PRO_prenom;

    ");
    
    return $resultat->getResultArray();
    }



    /*****************************************************************************
     * Insertion d'un nouveau scenarios.
     */


   
     // Récupère le nombre total de comptes.
     
    public function get_count_scenario()
    {
        $requete=("SELECT COUNT(*) AS Totalscenarios FROM T_SCENARIO_SCE;");
        $resultat = $this->db->query($requete);
        $row =  $resultat->getRow();
        return $row->Totalscenarios;
    }

    // Fonction pour générer un code aléatoire
    /*public function genere_code($long)
    {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwzyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lmax = strlen($caracteres);
        $chaineA = '';
        for($i=0; $i < $long; $i++) {
             $chaineA .= $caracteres[rand(0, $lmax - 1)];
        }
       return $chaineA;
    }*/

        /*****************************************************************************
     * Recuperation de l'id du dernier compte.
     */
    public function id_compte_user($username)
    {
        $requete="SELECT CPT_id FROM T_COMPTE_CPT where CPT_login='".$username."' ;";
        $resultat = $this->db->query($requete);
        $row =  $resultat->getRow();
        return $row->CPT_id;
    }

    // Fonction pour ajouter un nouveau scénario
    public function set_scenarios($id,$saisie,$f)
    {
        //Récuparation (+ traitement si nécessaire) des données du formulaire
        $intituler=$saisie['intituler'];
        $description=$saisie['description'];
        $fichier=$saisie['fichier'];
        $validite=$saisie['validite'];

        $sql="INSERT INTO T_SCENARIO_SCE VALUES(NULL,'". $intituler."',generateRandomString(),'". $description."','".$validite."',".$id.",'".$f."');";
        return $this->db->query($sql);

    }

    /********************************************* */
    //fonction qui permette de supprimer un match
     public function supprimerScenario($code)
    {
 
   //Supprimer les résultats liés aux étapes du scénario
    $query3 = $this->db->query("DELETE T_RESULTAT_RLT
    FROM T_PARTICIPANT_PTS
    LEFT JOIN T_RESULTAT_RLT ON T_PARTICIPANT_PTS.PTS_id = T_RESULTAT_RLT.PTS_id
    LEFT JOIN T_SCENARIO_SCE ON T_RESULTAT_RLT.SCE_id = T_SCENARIO_SCE.SCE_id
    WHERE T_SCENARIO_SCE.SCE_code = '".$code."'; ");

    /*Supprimer les participants liés au scénario
    $query4 = $this->db->query("DELETE T_PARTICIPANT_PTS
    FROM T_PARTICIPANT_PTS
    LEFT JOIN T_RESULTAT_RLT ON T_PARTICIPANT_PTS.PTS_id = T_RESULTAT_RLT.PTS_id
    LEFT JOIN T_SCENARIO_SCE ON T_RESULTAT_RLT.PTS_id = T_SCENARIO_SCE.SCE_id
    WHERE T_SCENARIO_SCE.SCE_code = '".$code."'; ");*/

       // Supprimer les indices liés aux étapes du scénario
     $query1 = $this->db->query("DELETE T_INDICE_IDE
    FROM T_SCENARIO_SCE
    LEFT JOIN T_ETAPE_ETP ON T_SCENARIO_SCE.SCE_id = T_ETAPE_ETP.SCE_id
    LEFT JOIN T_INDICE_IDE ON T_ETAPE_ETP.SCE_id = T_INDICE_IDE.ETP_id
    WHERE T_SCENARIO_SCE.SCE_code = '".$code."'; ");



    //Supprimer les étapes du scénario
    $query5 = $this->db->query("DELETE T_ETAPE_ETP
    FROM T_ETAPE_ETP
    LEFT JOIN T_SCENARIO_SCE ON T_ETAPE_ETP.SCE_id = T_SCENARIO_SCE.SCE_id
    WHERE T_SCENARIO_SCE.SCE_code = '".$code."'; ");


    
     //Supprimer les ressources liées aux étapes du scénario
    $query2 = $this->db->query("DELETE T_RESSOURCE_RSC
    FROM T_RESSOURCE_RSC
    LEFT JOIN T_ETAPE_ETP ON T_RESSOURCE_RSC.RSC_id = T_ETAPE_ETP.RSC_id
    LEFT JOIN T_SCENARIO_SCE ON T_ETAPE_ETP.SCE_id = T_SCENARIO_SCE.SCE_id
    WHERE T_SCENARIO_SCE.SCE_code = '".$code."'; ");

    //Enfin, supprimer le scénario lui-même
    $query6 = $this->db->query("DELETE T_SCENARIO_SCE FROM T_SCENARIO_SCE WHERE SCE_code = '".$code."'; ");

    }




 
/********************************Fonction pour le V2.2 ******************************************/

// Requête pour récupérer l'étape du scénario en fonction du code du scénario
    public function get_etape_scenarios($code_sc)
    {
     
        $query = $this->db->query("SELECT *  FROM T_SCENARIO_SCE
        LEFT JOIN T_ETAPE_ETP USING(SCE_id) where SCE_code = '".$code_sc."';");
        $result = $query->getRow();
        return $result->ETP_code;
    }

    // Requête pour récupérer le code du scénario en fonction du code de l'étape
    public function get_code_scenarios($code_etp)
    {
     
        $query = $this->db->query("SELECT *  FROM T_SCENARIO_SCE
        LEFT JOIN T_ETAPE_ETP USING(SCE_id) where ETP_code = '".$code_etp."';");
        $result = $query->getRow();
        return $result->SCE_code;
    }

   /* public function get_etape($code)
    {
     
        $query = $this->db->query("SELECT * FROM T_ETAPE_ETP WHERE ETP_code = '".$code."';");
        return $query->getRow();
    } */

    // Requête pour récupérer les informations de l'étape en fonction du code de l'étape et du niveau
    public function get_etape($code, $niveau) {
        $result = $this->db->query("SELECT * FROM T_SCENARIO_SCE
            LEFT JOIN T_ETAPE_ETP USING(SCE_id)
            LEFT JOIN T_INDICE_IDE ON T_ETAPE_ETP.ETP_id = T_INDICE_IDE.ETP_id AND T_INDICE_IDE.IDE_niveau = ".$niveau."
            LEFT JOIN T_RESSOURCE_RSC ON T_ETAPE_ETP.RSC_id = T_RESSOURCE_RSC.RSC_id 
            WHERE ETP_code = '".$code."' ;");
    
        return $result->getRow();
    }
    

    // Requête pour récupérer la réponse correcte en fonction du code de l'étape
    public function get_bonne_reponse($code)
    {
        $query = $this->db->query("SELECT ETP_reponse FROM T_ETAPE_ETP WHERE ETP_code = '".$code."';");
        $result = $query->getRow();

        if ($result) {
            return $result->ETP_reponse;
        }

        return null; // Retourne null si aucune réponse n'est trouvée
    }
    

 /*   public function get_etape_suivante($code)
    {
        $query = $this->db->query("SELECT ETP_code FROM T_ETAPE_ETP WHERE ETP_ordre = (SELECT ETP_ordre + 1 FROM T_ETAPE_ETP WHERE ETP_code = '".$code."')");
        $result = $query->getRow();

        if ($result) {
            return $result->ETP_code;
        }

        return null; // Retourne null si aucune étape suivante n'est trouvée
    }*/


    // Requête pour récupérer le code de l'étape suivante en fonction du code de l'étape actuelle, du niveau et du code du scénario
    public function get_etape_suivante($code, $niveau,$code_sc)
    {
        $query = $this->db->query(
            "SELECT ETP_code FROM T_SCENARIO_SCE
            LEFT JOIN T_ETAPE_ETP USING(SCE_id) 
            LEFT JOIN T_INDICE_IDE ON T_ETAPE_ETP.ETP_id = T_INDICE_IDE.ETP_id AND T_INDICE_IDE.IDE_niveau = ".$niveau." 
            WHERE SCE_code = '".$code_sc."' AND ETP_ordre = (SELECT ETP_ordre + 1 FROM T_ETAPE_ETP WHERE ETP_code = '".$code."' LIMIT 1);");
    
        $result = $query->getRow();
    
        if ($result) {
            return $result->ETP_code;
        }
    
        return null; // Assurez-vous de renvoyer une valeur par défaut (null dans ce cas)
    }
    

    

    // Récupération (+ traitement si nécessaire) des données du formulaire
    public function set_participants($saisie) {
         //Récuparation (+ traitement si nécessaire) des données du formulaire
         $mail=$saisie['mail'];
         $sql="INSERT INTO T_PARTICIPANT_PTS VALUES(NULL,'".$mail."');";
         return $this->db->query($sql);
    }

    // Requête pour récupérer l'ID du dernier participant inscrit
    public function id_par()
    {
        $requete="SELECT PTS_id FROM T_PARTICIPANT_PTS ORDER BY PTS_id DESC LIMIT 1;";
        $resultat = $this->db->query($requete);
        $row =  $resultat->getRow();
        return $row->PTS_id;
    }

    // Requête pour récupérer l'ID du scénario en fonction du code de l'étape
    public function get_id_scenarios($code_etp)
    {
     
        $query = $this->db->query("SELECT *  FROM T_SCENARIO_SCE
        LEFT JOIN T_ETAPE_ETP USING(SCE_id) where ETP_code = '".$code_etp."';");
        $result = $query->getRow();
        return $result->SCE_id;
    }

 
     // Récupération (+ traitement si nécessaire) des données du formulaire
    public function set_resulat($niveau,$idpar,$id_sc) {
        //Récuparation (+ traitement si nécessaire) des données du formulaire
        $sql="INSERT INTO T_RESULTAT_RLT VALUES(CURDATE(),CURDATE(),".$niveau.",".$id_sc.",".$idpar.");";
        return $this->db->query($sql);
   }

}
