<?php

namespace iutnc\SAE_APP_WEB\action;

use iutnc\SAE_APP_WEB\repository\Repository;
use iutnc\SAE_APP_WEB\render\CatalogueRender;

class DisplayCatalogAction extends Action {

    /**
     * @throws \Exception
     */
    public function __invoke() : string {
        if (isset($_SESSION['email'])) {
            $tri_option = $_GET['tri'] ?? 'default';
            $theme_option = $_GET['theme'] ?? 'default';
            $repo = Repository::getInstance();

            switch ($theme_option) {
                case 'Paysage':
                    $results = $repo->getCatalogueByTheme('Paysage');
                    break;
                case 'Animaux':
                    $results = $repo->getCatalogueByTheme('Animaux');
                    break;
                case 'Sport':
                    $results = $repo->getCatalogueByTheme('Sport');
                    break;
                case 'default':
                default:
                    $results = $repo->getCatalogue();
                    break;
            }
            
            switch ($tri_option) {
                case 'date_ajout':
                    $results = $repo->getCatalogueOrderedByDate();
                    break;
                case 'name':
                    $results = $repo->getCatalogueOrderedByTitle();
                    break;
                case 'annee':
                    $results = $repo->getCatalogueOrderedByYear();
                    break;
                case 'nb_episodes':
                    $results = $repo->getCatalogueOrderedByNbEpisodes();
                    break;
                case 'note':
                    $results = $repo->getCatalogueOrderedByMoyenne();
                    break;
                case 'default':
                default:
                    $results = $repo->getCatalogue();
                    break;
            }

            

            $renderer = new CatalogueRender($results);
            $rendu = $renderer->render();
            return $rendu;
        } else {
            return "<p>Aucune série disponible. Veuillez vous connectez ou créer un compte.</p>";
        }
    }

}