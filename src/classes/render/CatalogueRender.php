<?php
declare(strict_types=1);

namespace iutnc\SAE_APP_WEB\render;

use iutnc\SAE_APP_WEB\video\Catalogue;

class CatalogueRender implements Render{
    private Catalogue $catalogue;
    
    public function __construct(Catalogue $catalogue){
        $this->catalogue = $catalogue;
    }

    public function render (): string{
        $q = htmlspecialchars((string)($_GET['q'] ?? ''), ENT_QUOTES, 'UTF-8');
        $html = "<div class='catalogue'>\n";
        $html .= "<h2>Catalogue NetVOD</h2>\n";
        $html .= "<div class='catalog-container'>\n"; 

        $html .= "<form method='get' action='index.php' class='catalog-search'>\n"; // Correction de l'action
        $html .= "<input type='hidden' name='action' value='search' />\n";
        $html .= "<input type='text' name='q' placeholder='Rechercher...' value='{$q}' />\n";
        $html .= "<button type='submit'>Rechercher</button>\n";
        $html .= "</form>\n";
        foreach ($this->catalogue->series as $serie) {
            $SerieRender = new SerieRender($serie);
            $html .= $SerieRender->render();
        }
        $html .= "</div>\n"; 
        $html .= "</div>\n";

        return $html;
    }

}