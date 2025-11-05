<?php

namespace iutnc\SAE_APP_WEB\action;

use iutnc\SAE_APP_WEB\render\CatalogueRender;
use iutnc\SAE_APP_WEB\repository\Repository;
use iutnc\SAE_APP_WEB\render\SerieRender;
use iutnc\SAE_APP_WEB\video\Catalogue;

class ActionHome {
    public function __invoke(): string {
        $catalogue = Repository::getInstance()->getEnCoursSeries();
        $render = new CatalogueRender($catalogue);
        return $render->render();
    }
}