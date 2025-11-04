<?php

namespace iutnc\SAE_APP_WEB\render;

use iutnc\SAE_APP_WEB\video\Episode;
use iutnc\SAE_APP_WEB\video\Series;

class SerieRender implements Render{

    protected Series $serie;  

    public function __construct(Series $serie) {
        $this->serie = $serie;
    }

    public function render():string {
        return <<< HTML
            <div class="video-item">
                <a href="?action=displaySerie&id={$this->serie->id}"><h3>{$this->serie->title}</h3></a>
                <p>{$this->serie->description}</p>
            </div>
        HTML;
    }

}
