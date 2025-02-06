<?php
namespace App\Controllers;
use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;
class Scenario extends BaseController
{
    public function __construct()
    {
         helper('form');
         $this->model = model(Db_model::class);
    }

    /*
     * Affiche la galerie des scénarios disponibles.
     */
    public function afficher_galerie()
    {
        //$model = model(Db_model::class);
        $data['titre'] = 'Galerie des Scénarios Disponibles :';
        $data['sce'] = $this->model->get_all_scenarios();
            return view('templates/haut', $data)
            . view('menu_visiteur')
            . view('les_scenarios')
            . view('templates/bas');
    }

 

    /*
     * Affiche les étapes d'un scénario spécifique à un niveau donné.
     */
    public function afficher_etapes($code_sc = null, $niveau = 0)
    {
        if($code_sc == null && $niveau ==0)
        {
            return redirect()->to(base_url() . "index.php/scenario/afficher_galerie");
        }
        elseif($niveau < 0 || $niveau > 3 ){
                echo "Niveau indice inexistant";
                return  header("refresh:5;url=" . base_url() . "index.php/scenario/afficher_galerie");
            }
            else {
            $code_etat = $this->model->get_etape_scenarios($code_sc);
            $data['etp'] = $this->model->get_etape($code_etat,$niveau);
            if ($this->request->getMethod()=="post")
            {

                    if (! $this->validate([
                        'reponse' => 'required', 
                        ],
                        [ // Configuration des messages d’erreurs
                            'reponse' => [
                                'required' => 'Veuillez entrer votre reponse !',
                            ],  
                        ]
                        ))
                        {
                            // La validation du formulaire a échoué, retour au formulaire !
                            
                            $data['etp'] = $this->model->get_etape($code_etat,$niveau);
                            $data['lecode']=$code_etat;
                            $data['lecode_sc']=$code_sc;
                            $data['niveau'] = $niveau; // Ajout de la variable $niveau
                            $data['err'] = $this->model->get_erreur($code_sc);
                            return view('templates/haut', $data)
                                . view('menu_visiteur')
                                . view('etapes')
                                . view('templates/bas');
                        }
                        // La validation du formulaire a réussi, traitement du formulaire
                     
                    
                    // Récupération de la réponse saisie
                    // + code caché (hidden) de l’étape actuelle
                    $reponse_saisie = addslashes($this->request->getVar('reponse'));
                    //$code_etat= addslashes($this->request->getVar('thecode'));
                    // Récupération de la bonne réponse de l’étape actuelle
                    $reponse_correcte = $this->model->get_bonne_reponse($code_etat);
                    // Comparaison des 2 chaînes de réponse 
                    // Si c’est la bonne réponse, recherche du code de la
                    // prochaine étape + redirection
                    // Sinon, ce n’est pas la bonne réponse, on reste
                    // sur la même étape (redirection)
                            // L’utilisateur a validé le formulaire

                            if (strtolower($reponse_saisie) == strtolower($reponse_correcte)) {
                                $code_etape_suivante = $this->model->get_etape_suivante($code_etat,$niveau,$code_sc);
                                    if ($code_etape_suivante === null) {
                                        // C'est la dernière étape
                                        $chaine = $code_etat ."ELANIF".$niveau;
                                        return redirect()->to(base_url() . "index.php/scenario/finaliser/$code_etat/$chaine/$niveau");
                                    } else {
                                        return redirect()->to(base_url() . "index.php/scenario/franchir_etape/$code_etape_suivante/$niveau");
                                    }
                            } else {
                                return redirect()->to(base_url() . "index.php/scenario/afficher_etapes/$code_sc/$niveau");
                            }
        
                }
            // L’utilisateur veut afficher le formulaire
            $data['etp'] = $this->model->get_etape($code_etat,$niveau);
            $data['lecode']=$code_etat;
            $data['lecode_sc']=$code_sc;
            $data['niveau'] = $niveau; 
            $data['err'] = $this->model->get_erreur($code_sc);
            return view('templates/haut', $data)
                . view('menu_visiteur')
                . view('etapes')
                . view('templates/bas');

            
        }
    }

   
        public function creer()
        {
          // Récupération des données postées
            $postData = $this->request->getPost();

               // Logique de conversion du 
            if (isset($postData['validite'])) {
                $validite= $postData['validite'];
                if ($validite === 'Activer') {
                    $postData['validite'] = 'A';
                } elseif ($validite === 'Cacher') {
                    $postData['validite'] = 'C';
                } else {
                    // Valeur par défaut ou traitement spécial si nécessaire
                    $postData['validite'] = '';
                }
            }


            $session =session();
            $user = $session->get('user');
            $role = $this->model->get_profil($user)->PRO_role;
            $session->set('role', $role); // Vous n'avez pas besoin de mettre à jour 'user' ici
            // L’utilisateur a validé le formulaire en cliquant sur le bouton
            if ($this->request->getMethod()=="post")
            {
                if (! $this->validate([
                'intituler' => 'required',
                'description' => 'required',
                'validite' => 'required|in_list[Activer,Cacher]',
                'fichier' => [
                    'label' => 'Fichier image',
                    'rules' => [
                    'uploaded[fichier]',
                    'is_image[fichier]',
                    'mime_in[fichier,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
                    'max_size[fichier,100]',
                    'max_dims[fichier,1024,768]',
                    ]]
                ],
                [ // Configuration des messages d’erreurs
                    'intituler' => [
                        'required' => 'Veuillez entrer intituler du scénaio !',
                    ],
                    'description' => [
                        'required' => 'Veuillez entrer la descripion du scénario !',
                    ],
                    'validite' => [
                        'required' => 'Veuillez sélectionner validite pour le compte !',
                        'in_list' => 'La validite sélectionné n\'est pas valide !',
                    ],
              
                    '_form' => [
                        'required' => 'Remplissez tous les champs du formulaire !',
                    ],
                    'fichier' => [
                        'label' => 'Fichier image',
                        'rules' => [
                            'uploaded[fichier]' => 'Veuillez sélectionner un fichier image.',
                            'is_image[fichier]' => 'Le fichier sélectionné n\'est pas une image valide.',
                            'mime_in[fichier,image/jpg,image/jpeg,image/gif,image/png,image/webp]' => 'Le format de l\'image n\'est pas pris en charge.',
                            'max_size[fichier,100]' => 'La taille du fichier image ne doit pas dépasser 100 kilo-octets.',
                            'max_dims[fichier,1024,768]' => 'Les dimensions de l\'image ne doivent pas dépasser 1024x768 pixels.',
                        ],
                    ],

                ]
                ))
                {
                    // La validation du formulaire a échoué, retour au formulaire !
                    $data['adm'] = $this->model->get_profil($user);
                    $data['titre'] = "Créer un nouveau scenario";
                    return view('templates/haut2', $data)
                    . view('menu_org')
                    . view('scenario/scenario_creer')
                    . view('templates/bas2');
                }
                // La validation du formulaire a réussi, traitement du formulaire
                $intituler = addslashes($this->request->getVar('intituler'));
                $description = addslashes($this->request->getVar('description'));
                $fichier= $this->request->getFile('fichier');
                
                if(!empty($fichier)){
                // Récupération du nom du fichier téléversé 
                $nom_fichier=$fichier->getName();
                    // Dépôt du fichier dans le répertoire ci/public/images_scenaio
                    if($fichier->move("images_scenario",$nom_fichier)){
                        // + Mettre ici l’appel de la fonction membre du Db_model
                        // + L’affichage de la page indiquant l’ajout du compte !
                        
                        //$code = $this->model->genere_code(10);
                        $id = $this->model->id_compte_user($user);
                        $recuperation = $this->validator->getValidated();
                        $this->model->set_scenarios($id,$recuperation,$nom_fichier);
                        $data['le_scenario']=$recuperation['intituler'];
                        $data['le_message']="Nouveau nombre de scénario : ";
                        //Appel de la fonction créée dans le précédent tutoriel :
                        $data['le_total']=$this->model->get_count_scenario();
                        return view('templates/haut2', $data)
                        . view('menu_org')
                        . view('scenario/scenario_succes')
                        . view('templates/bas2');
                    }
                }
              
            }
            // L’utilisateur veut afficher le formulaire pour créer un compte
            $data['adm'] = $this->model->get_profil($user);
            $data['titre'] = "Créer un nouveau scenario";
            return view('templates/haut2', $data)
            . view('menu_org')
            . view('scenario/scenario_creer')
            . view('templates/bas2');
        }

           public function afficher_scenario()
     {
         $session=session();
         $user = $session->get('user');
         $role = $this->model->get_profil($user)->PRO_role;
         $session->set('role', $role);
        $data['adm'] = $this->model->get_profil($user);
        $data['titre'] = 'Les Scénarios Disponibles :';
        $data['sc'] = $this->model->get_total_scenarios();
             return view('templates/haut2', $data)
                . view('menu_org')
                . view('affiche_scenarios')
                . view('templates/bas2');
     }
    
        public function visualiser($code = NULL)
     {
        if($code == null )
        {
            return redirect()->to(base_url() . "index.php/scenario/afficher_scenario");
        }
        else{
         $session=session();
         $user = $session->get('user');
         $role = $this->model->get_profil($user)->PRO_role;
         $session->set('role', $role);
        $data['adm'] = $this->model->get_profil($user);
        $data['titre'] = 'Scénario :';
        $data['msc'] = $this->model->get_scenarios($code);
             return view('templates/haut2', $data)
                . view('menu_org')
                . view('my_scenario')
                . view('templates/bas2');
     }
    }


        public function supprimer($code)
     {
         $this->model->supprimerScenario($code);
         return redirect()->to(base_url() . "index.php/scenario/afficher_scenario");   
     }


     public function franchir_etape($code_etat=NULL ,$niveau)
    {
        if($code_etat == null )
        {
            return redirect()->to(base_url() . "index.php/scenario/afficher_galerie");
        }
        elseif($niveau < 0 || $niveau > 3 ){
                echo "Niveau indice inexistant";
                return  header("refresh:5;url=" . base_url() . "index.php/scenario/afficher_galerie");
            }

        else {

            $code_sc = $this->model->get_code_scenarios($code_etat,$niveau);
                // L’utilisateur a validé le formulaire
                if ($this->request->getMethod()=="post")
                {
                    if (! $this->validate([
                        'reponse' => 'required',
                        ],
                        [ // Configuration des messages d’erreurs
                            'reponse' => [
                                'required' => 'Veuillez entrer votre reponse !',
                            ],
                        ]
                        ))
                        {
                            // La validation du formulaire a échoué, retour au formulaire !
                            if($code_etat!=NULL){
                    
                                $data['etp'] = $this->model->get_etape($code_etat,$niveau);
                                $data['lecode']=$code_etat;
                                                             
                            }
                            //...

                            $data['etp'] = $this->model->get_etape($code_etat,$niveau);
                            $data['lecode']=$code_etat;
                            $data['lecode_sc']=$code_sc;
                            $data['niveau'] = $niveau; // Ajout de la variable $niveau
                            $data['err'] = $this->model->get_erreur_etap($code_etat);
                            return view('templates/haut', $data)
                                    . view('menu_visiteur')
                                    . view('etape_affichage')
                                    . view('templates/bas');  
                        }
                        // La validation du formulaire a réussi, traitement du formulaire
                      
                    
                    // Récupération de la réponse saisie
                    // + code caché (hidden) de l’étape actuelle
                    $reponse_saisie = addslashes($this->request->getVar('reponse'));
                    //$code_etat= addslashes($this->request->getVar('thecode'));
                   
                    // Récupération de la bonne réponse de l’étape actuelle
                    $reponse_correcte = $this->model->get_bonne_reponse($code_etat);
                    
                    // Comparaison des 2 chaînes de réponse 
                    // Si c’est la bonne réponse, recherche du code de la
                    // prochaine étape + redirection
                    // Sinon, ce n’est pas la bonne réponse, on reste
                    // sur la même étape (redirection)
                            // L’utilisateur a validé le formulaire
                            
                            if (strtolower($reponse_saisie) == strtolower($reponse_correcte)) {
                                $code_etape_suivante = $this->model->get_etape_suivante($code_etat,$niveau,$code_sc);
                                    if ($code_etape_suivante === null) {
                                        // C'est la dernière étape
                                        $chaine = $code_etat ."ELANIF".$niveau;
                                        return redirect()->to(base_url() . "index.php/scenario/finaliser/$code_etat/$chaine/$niveau");
                                    } else {
                                        return redirect()->to(base_url() . "index.php/scenario/franchir_etape/$code_etape_suivante/$niveau");
                                    }
                            } else {
                                return redirect()->to(base_url() . "index.php/scenario/franchir_etape/$code_etat/$niveau");

                            }
                
                }
                // L’utilisateur veut afficher le formulaire
                if($code_etat!=NULL){
                    
                    $data['etp'] = $this->model->get_etape($code_etat,$niveau);
                    $data['lecode']=$code_etat;
                                                 
                }
                //...
                $data['etp'] = $this->model->get_etape($code_etat,$niveau);
                $data['lecode']=$code_etat;
                $data['lecode_sc']=$code_sc;
                $data['niveau'] = $niveau; // Ajout de la variable $niveau
                $data['err'] = $this->model->get_erreur_etap($code_etat);
                return view('templates/haut', $data)
                        . view('menu_visiteur')
                        . view('etape_affichage')
                        . view('templates/bas');  
            }

    }

     public function finaliser($code_etat,$chaine,$niveau) {

        if ($this->request->getMethod()=="post")
        {
            if (! $this->validate([
            'mail' => 'required',
           
            ],
            [ // Configuration des messages d’erreurs
                'mail' => [
                    'required' => 'Veuillez entrer votre email !',
                ],
               
            ]
            ))
            {
                // La validation du formulaire a échoué, retour au formulaire !
                $data['etp'] = $this->model->get_etape($code_etat,$niveau);
                $data['lecode']=$code_etat;
                $data['niveau'] = $niveau;
                $data['chaine'] = $chaine;
                $data['titre'] = "Finaliser le jeux";
                return view('templates/haut', $data)
                . view('menu_visiteur')
                . view('final')
                . view('templates/bas');
            }
            // La validation du formulaire a réussi, traitement du formulaire
            $mail = addslashes($this->request->getVar('mail'));
                    $recuperation = $this->validator->getValidated();
                    $this->model->set_participants($recuperation);
                    $id_par = $this->model->id_par();
                    $id_sc = $this->model->get_id_scenarios($code_etat);
                    $this->model->set_resulat($niveau,$id_par,$id_sc);
                    $data['participant']=$recuperation['mail'];
                    return view('templates/haut', $data)
                    . view('menu_visiteur')
                    . view('jeu_success')
                    . view('templates/bas');
                
            
          
        }
        // L’utilisateur veut afficher le formulaire pour créer un compte
        $data['etp'] = $this->model->get_etape($code_etat,$niveau);
        $data['chaine'] = $chaine;
        $data['lecode']=$code_etat;
        $data['niveau'] = $niveau;
        $data['titre'] = "Finaliser le jeux";
        return view('templates/haut', $data)  
        . view('menu_visiteur')
        . view('final')
        . view('templates/bas');
    }

            
        
        
    
    
}
?>



