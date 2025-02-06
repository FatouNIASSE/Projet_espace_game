<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');


use App\Controllers\Accueil;
//$routes->get('accueil/afficher', [Accueil::class, 'afficher']);
//$routes->get('accueil/afficher/(:segment)', [Accueil::class, 'afficher']);
$routes->get('/', 'Accueil::afficher');

use App\Controllers\Compte;
$routes->get('compte/lister', [Compte::class, 'lister']);

$routes->get('compte/creer', [Compte::class, 'creer']);
$routes->post('compte/creer', [Compte::class, 'creer']);

$routes->get('compte/connecter', [Compte::class, 'connecter']); 
$routes->post('compte/connecter', [Compte::class, 'connecter']);

$routes->get('compte/afficher_profil', [Compte::class, 'afficher_profil']);
$routes->get('compte/acceuil', [Compte::class, 'acceuil']);
$routes->get('compte/deconnecter', [Compte::class, 'deconnecter']);

$routes->get('compte/modifier_mdp', [Compte::class, 'modifier_mdp']);
$routes->post('compte/modifier_mdp', [Compte::class, 'modifier_mdp']);




use App\Controllers\Actualite;
$routes->get('actualite/afficher', [Actualite::class, 'afficher']);
$routes->get('actualite/afficher/(:num)', [Actualite::class, 'afficher']);

use App\Controllers\Scenario;
$routes->get('scenario/afficher_galerie', [Scenario::class, 'afficher_galerie']);

$routes->get('scenario/afficher_etapes/(:segment)/(:num)', [Scenario::class, 'afficher_etapes']);
$routes->get('scenario/afficher_etapes', [Scenario::class, 'afficher_etapes']);
$routes->post('scenario/afficher_etapes/(:segment)/(:num)', [Scenario::class, 'afficher_etapes/$1/$2']);

$routes->get('scenario/creer', [Scenario::class, 'creer']);
$routes->post('scenario/creer', [Scenario::class, 'creer']);

$routes->get('scenario/afficher_scenario', [Scenario::class, 'afficher_scenario']);
$routes->get('scenario/visualiser/(:segment)', [Scenario::class, 'visualiser']);
$routes->get('scenario/visualiser', [Scenario::class, 'visualiser']);
$routes->get('scenario/supprimer/(:segment)', [Scenario::class, 'supprimer']);
$routes->post('scenario/supprimer/(:segment)', [Scenario::class, 'supprimer']);

$routes->get('scenario/franchir_etape/(:segment)/(:num)', [Scenario::class, 'franchir_etape']);
$routes->post('scenario/franchir_etape/(:segment)/(:num)', [Scenario::class, 'franchir_etape/$1/$2']);

$routes->get('scenario/finaliser/(:segment)/(:segment)/(:num)', [Scenario::class, 'finaliser']);
$routes->post('scenario/finaliser/(:segment)/(:segment)/(:num)', [Scenario::class, 'finaliser/$1/$2/$3']);