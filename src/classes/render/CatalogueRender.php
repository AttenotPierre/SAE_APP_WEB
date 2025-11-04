<?php
declare(strict_types=1);

namespace iutnc\SAE_APP_WEB\render;

use classes\video\Catalogue;

class CatalogueRender implements Render{
    private Catalogue $catalogue;
    
    public function __construct(Catalogue $catalogue){
        $this->catalogue = $catalogue;
    }

    public function render (): string{
        $html = "<div class='catalogue'>\n";
        $html .= "<h2>Catalogue NetVOD</h2>\n";
        $html .= "<ul>\n";
        foreach ($this->catalogue->series as $serie) {
            $VideoRender = new VideoRender($serie);
            $html .= "<li>" . $VideoRender->render() . "</li>\n";
        }
        $html .= "</ul>\n";
        $html .= "</div>\n";

        return $html;
    }

}