<?php

namespace iutnc\SAE_APP_WEB\action;

use iutnc\SAE_APP_WEB\repository\Repository;
use iutnc\SAE_APP_WEB\render\CatalogueRender;

class DisplayCatalogAction extends Action {

    public function __invoke() : string {
        // if (isset($_SESSION['user'])) {
            $catalogue = Repository::getInstance()->getCatalogue();
            $renderer = new CatalogueRender($catalogue);
            $rendu = $renderer->render();
            return $rendu;
        // } else {
        //     return "<p>Aucune série disponible. Veuillez vous connectez ou créer un compte.</p>";
        // }
    }

}