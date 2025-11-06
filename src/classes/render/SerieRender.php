<?php

namespace iutnc\SAE_APP_WEB\render;

use iutnc\SAE_APP_WEB\video\Episode;
use iutnc\SAE_APP_WEB\video\Series;
use iutnc\SAE_APP_WEB\repository\Repository;

class SerieRender implements Render{

    protected Series $serie;  

    public function __construct(Series $serie) {
        $this->serie = $serie;
    }

    public function render():string {

        $favHtml = '';

        if (Repository::getInstance()->isSerieInPref($this->serie->id)){
            $favHtml = '<a href="?action=supprListeAction&id_serie=' .$this->serie->id .'">FAVORIS</a>';
        }
        else {
            $favHtml = '<a href="?action=ajoutListeAction&id_serie=' . $this->serie->id.'">FAVORIS</a>';
        }

        return <<< HTML
            <div class="video-item">
                <a href="?action=displaySerie&id_serie={$this->serie->id}"><h3>{$this->serie->titre}</h3></a>
                <p>{$this->serie->description}</p>
                $favHtml    
            </div>
        HTML;
    }

}
