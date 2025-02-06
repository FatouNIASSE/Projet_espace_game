<?php
namespace App\Controllers;
use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;
class Accueil extends BaseController
{
    public function __construct()
    {
    //...
    }

    /*
     * Affiche la page d'accueil avec les actualités.
     */
    public function afficher()
    {
        $model = model(Db_model::class);
        $data['titre'] = 'Les Actualités :';
        $data['actu'] = $model->get_all_actualite();
            return view('templates/haut', $data)
            . view('menu_visiteur')
            . view('affichage_accueil')
            . view('templates/bas');
    }
}
?>