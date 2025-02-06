<?php
namespace App\Controllers;
use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;
class Compte extends BaseController
{
    public function __construct()
    {
         helper('form');
         $this->model = model(Db_model::class);
    }

     /*
     * Affiche la liste de tous les compte.
     */
    public function lister()
    {
        $session =session();
        $user = $session->get('user');
        $role = $this->model->get_profil($user)->PRO_role;
        $session->set('role', $role);
        $model = model(Db_model::class);
        $data['adm'] = $this->model->get_profil($user);
        $data['titre']="Liste de tous les comptes";
        $data['nb'] = $model->get_count_compte();
        $data['logins'] = $model->get_all_compte($user);
        return view('templates/haut2', $data)
        . view('menu_admin')
        . view('affichage_comptes')
        . view('templates/bas2');
    }


        
    //....Code du constructeur et de la fonction membre lister() ici !
        public function creer()
        {
           
         

                    // Récupération des données postées
            $postData = $this->request->getPost();

            // Logique de conversion du rôle
            if (isset($postData['role'])) {
                $role = $postData['role'];
                if ($role === 'Administrateur') {
                    $postData['role'] = 'A';
                } elseif ($role === 'Organisateurs') {
                    $postData['role'] = 'O';
                } else {
                    // Valeur par défaut ou traitement spécial si nécessaire
                    $postData['role'] = '';
                }
            }

               // Logique de conversion du 
            if (isset($postData['validite'])) {
                $validite= $postData['validite'];
                if ($validite === 'Activer') {
                    $postData['validite'] = 'A';
                } elseif ($validite === 'Desactiver') {
                    $postData['validite'] = 'D';
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
                'nom' => 'required|max_length[255]|min_length[2]',
                'prenom' => 'required|max_length[255]|min_length[2]',
                'role' => 'required|in_list[Administrateur,Organisateurs]',
                'pseudo' => 'required|max_length[255]|min_length[2]',
                'validite' => 'required|in_list[Activer,Desactiver]',
                'fichier' => [
                    'label' => 'Fichier image',
                    'rules' => [
                    'uploaded[fichier]',
                    'is_image[fichier]',
                    'mime_in[fichier,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
                    'max_size[fichier,100]',
                    'max_dims[fichier,1024,768]',
                    ]],
                'mdp' => 'required|max_length[255]|min_length[8]',
                'confirmer_mdp' => 'required|matches[mdp]'
                ],
                [ // Configuration des messages d’erreurs
                    'nom' => [
                        'required' => 'Veuillez entrer un nom pour le compte !',
                    ],
                    'prenom' => [
                        'required' => 'Veuillez entrer un prénom pour le compte !',
                    ],
                    'role' => [
                        'required' => 'Veuillez sélectionner un rôle pour le compte !',
                        'in_list' => 'Le rôle sélectionné n\'est pas valide !',
                    ],
                    'pseudo' => [
                        'required' => 'Veuillez entrer un pseudo pour le compte !',
                    ],
                    'validite' => [
                        'required' => 'Veuillez sélectionner validite pour le compte !',
                        'in_list' => 'La validite sélectionné n\'est pas valide !',
                    ],
                    'mdp' => [
                        'min_length' => 'Le mot de passe saisi est trop court !',
                        'required' => 'Veuillez entrer un mot de passe !',
                    ],
                    'confirmer_mdp' => [
                        'required' => 'Veuillez confirmer le mot de passe !',
                        'matches' => 'Les mots de passe ne correspondent pas !',
                    ],
                    '_form' => [
                        'required' => 'Remplissez tous les champs du formulaire !',
                    ],
                ]
                ))
                {
                    // La validation du formulaire a échoué, retour au formulaire !
                    $data['adm'] = $this->model->get_profil($user);
                    $data['titre'] = "Créer un compte";
                    return view('templates/haut2', $data)
                    . view('menu_admin')
                    . view('compte/compte_creer')
                    . view('templates/bas2');


                }
                // La validation du formulaire a réussi, traitement du formulaire
                $pseudo= addslashes($this->request->getVar('pseudo'));

                  // Vérification si le compte existe déjà
                    if ($this->model->existeCompte($pseudo)) {
                        // Le compte existe déjà, afficher un message d'erreur
                        
                        return view('templates/haut2')
                            . view('menu_admin')
                            . view('compte/compte_exitant')
                            . view('templates/bas2');
                    }

                $mdp= addslashes($this->request->getVar('mdp'));
                $fichier= $this->request->getFile('fichier');
                
                if(!empty($fichier)){
                // Récupération du nom du fichier téléversé 
                $nom_fichier=$fichier->getName();
                    // Dépôt du fichier dans le répertoire ci/public/images
                    if($fichier->move("images",$nom_fichier)){
                        // + Mettre ici l’appel de la fonction membre du Db_model
                        // + L’affichage de la page indiquant l’ajout du compte !
                        $recuperation = $this->validator->getValidated();
                        $this->model->set_compte($recuperation);
                        $id = $this->model->id_compte();
                        $this->model->set_profil($recuperation,$id,$nom_fichier);
                        $data['le_compte']=$recuperation['pseudo'];
                        $data['le_message']="Nouveau nombre de comptes : ";
                        //Appel de la fonction créée dans le précédent tutoriel :
                        $data['le_total']=$this->model->get_count_compte();
                        return view('templates/haut2', $data)
                        . view('menu_admin')
                        . view('compte/compte_succes')
                        . view('templates/bas2');
                    }
                }
              
            }
            // L’utilisateur veut afficher le formulaire pour créer un compte
            $data['adm'] = $this->model->get_profil($user);
            $data['titre'] = "Créer un compte";
            return view('templates/haut2', $data)
            . view('menu_admin')
            . view('compte/compte_creer')
            . view('templates/bas2');
        }


        public function acceuil()
        {
            $session =session();
            $user = $session->get('user');
            $data['adm'] = $this->model->get_profil($user);
            $role = $this->model->get_profil($user)->PRO_role;
            $session->set('role', $role); // Vous n'avez pas besoin de mettre à jour 'user' ici
            if ($role == "A") {
                return view('templates/haut2',$data)
                    . view('menu_admin')
                    . view('connexion/compte_accueil')
                    . view('templates/bas2');
            }else{
                return view('templates/haut2',$data)
                    . view('menu_org')
                    . view('connexion/compte_org')
                    . view('templates/bas2');
            }
        }

   
        public function connecter()
        {
            // L’utilisateur a validé le formulaire en cliquant sur le bouton
            if ($this->request->getMethod() == "post") {
                if (!$this->validate([
                    'pseudo' => 'required',
                    'mdp' => 'required'
                ],
                    [ // Configuration des messages d’erreurs
                        'pseudo' => [
                            'required' => 'Veuillez entrer votre pseudo !',
                        ],
                        'mdp' => [
                            'required' => 'Veuillez entrer un mot de passe correct!',
                        ],
                        '_form' => [
                            'required' => 'Remplissez tous les champs du formulaire !',
                        ],
                    ]
                )) {
                    // La validation du formulaire a échoué, retour au formulaire !
                    return view('templates/haut', ['titre' => 'Se connecter'])
                        . view('menu_visiteur')
                        . view('connexion/compte_connecter')
                        . view('templates/bas');
                }

                // La validation du formulaire a réussi, traitement du formulaire
                $username = addslashes($this->request->getVar('pseudo'));
                $password = addslashes($this->request->getVar('mdp'));
                if ($this->model->connect_compte($username, $password) == true) {
                    $session = session();
                    $role = $this->model->get_profil($username)->PRO_role;
                    $session->set('user', $username);
                    $session->set('role', $role);
                    $valide = $this->model->get_profil($username)->PRO_validite;

                        if($valide == "D"){
                            $data['le_message']="Ce compte est désactiver";
                            $data['titre'] = "Se connecter";
                            return view('templates/haut',$data)
                                . view('menu_visiteur')
                                . view('connexion/compte_connecter')
                                . view('templates/bas');
                        }else{
                                if ($role == "A") {
                                    $data['adm'] = $this->model->get_profil($username);
                                    return view('templates/haut2',$data)
                                        . view('menu_admin')
                                        . view('connexion/compte_accueil')
                                        . view('templates/bas2');
                                } else {
                                    $data['adm'] = $this->model->get_profil($username);
                                    return view('templates/haut2',$data)
                                        . view('menu_org')
                                        . view('connexion/compte_org')
                                        . view('templates/bas2');
                                }
                        }
                } else {
                     $data['le_message']="Probleme de connexion : Les information ne sont pas correctes";
                    $data['titre'] = "Se connecter";
                    return view('templates/haut',$data)
                        . view('menu_visiteur')
                        . view('connexion/compte_connecter')
                        . view('templates/bas');
                }
            }

            // L’utilisateur veut afficher le formulaire pour se connecter
            return view('templates/haut', ['titre' => 'Se connecter'])
                . view('menu_visiteur')
                . view('connexion/compte_connecter')
                . view('templates/bas');
        }




    

        public function afficher_profil()
        {
            $session=session();
            
            if ($session->has('user')) {
                $user = $session->get('user');
                $role = $this->model->get_profil($user)->PRO_role;
                $session->set('role', $role); // Mise à jour du rôle dans la session

                $data['le_message'] = "Affichage des données du profil ici !!!";
                $data['adm'] = $this->model->get_profil($user);

                if ($role == "A") {
                    return view('templates/haut2', $data)
                        . view('menu_admin')
                        . view('connexion/compte_profil')
                        . view('templates/bas2');
                } else {
                    return view('templates/haut2', $data)
                        . view('menu_org')
                        . view('connexion/compte_profil')
                        . view('templates/bas2');
                }
            } else {
                return view('templates/haut', ['titre' => 'Se connecter'])
                    . view('connexion/compte_connecter')
                    . view('templates/bas');
            }
        }


        public function deconnecter()
        {
            $session=session();
            $session->destroy();
            return view('templates/haut', ['titre' => 'Se connecter'])
            . view('menu_visiteur')
            . view('connexion/compte_connecter')
            . view('templates/bas');
        }



    public function modifier_mdp()
    {
        $session = session();

        if ($session->has('user')) {
            $user = $session->get('user');
            $role = $this->model->get_profil($user)->PRO_role;
            $session->set('role', $role);
            if ($this->request->getMethod() == "post") {
                if (! $this->validate([
                'mdp' => 'required|max_length[255]|min_length[8]',
                'confirmer_mdp' => 'required|matches[mdp]'
                ],
                [ // Configuration des messages d’erreurs
                    'mdp' => [
                        'min_length' => 'Le mot de passe saisi est trop court !',
                        'required' => 'Veuillez entrer un mot de passe !',
                    ],
                    'confirmer_mdp' => [
                        'required' => 'Veuillez confirmer le mot de passe !',
                        'matches' => 'Les mots de passe ne correspondent pas !',
                    ],
                    '_form' => [
                        'required' => 'Remplissez tous les champs du formulaire !',
                    ],
                ]
                ))
                {

                    if ($role == "A") {
                    // La validation du formulaire a échoué, retour au formulaire !
                    $data['adm'] = $this->model->get_profil($user);
                    $data['titre'] = "Paramètre du mot de passe";
                    return view('templates/haut2', $data)
                        . view('menu_admin')
                        . view('update_mdp')
                        . view('templates/bas2');
                  } else {
                    // La validation du formulaire a échoué, retour au formulaire !
                    $data['adm'] = $this->model->get_profil($user);
                    $data['titre'] = "Paramètre du mot de passe";
                    return view('templates/haut2', $data)
                        . view('menu_org')
                        . view('update_mdp')
                        . view('templates/bas2');
                         }
                }

                // La validation du formulaire a réussi, traitement du formulaire
                    if ($role == "A") {
                        $password = addslashes($this->request->getVar('mdp'));
                        $this->model->modifier_password($user, $password);
                        $data['titre'] = "Paramètre du mot de passe";
                        return view('templates/haut2', $data)
                            . view('menu_admin')
                            . view('update_mdp_reussit')
                            . view('templates/bas2');
                    } else {
                        $password = addslashes($this->request->getVar('mdp'));
                        $this->model->modifier_password($user, $password);
                        $data['titre'] = "Paramètre du mot de passe";
                        return view('templates/haut2', $data)
                            . view('menu_org')
                            . view('update_mdp_reussit')
                            . view('templates/bas2');
                         }
                }
            }

            // Afficher le formulaire par défaut
            if ($role == "A") {
                $data['adm'] = $this->model->get_profil($user);
                $data['titre'] = "Paramètre du mot de passe";
                return view('templates/haut2', $data)
                    . view('menu_admin')
                    . view('update_mdp')
                    . view('templates/bas2');
            } else {
                  $data['adm'] = $this->model->get_profil($user);
                $data['titre'] = "Paramètre du mot de passe";
                return view('templates/haut2', $data)
                    . view('menu_org')
                    . view('update_mdp')
                    . view('templates/bas2');
            }
        }

 
   
    
}

