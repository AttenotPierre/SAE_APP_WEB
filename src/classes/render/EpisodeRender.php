<?php

namespace iutnc\SAE_APP_WEB\render;

use iutnc\SAE_APP_WEB\video\Episode;
use iutnc\SAE_APP_WEB\video\Series;

class EpisodeRender implements Render{

    protected Episode $episode;  

    public function __construct(Episode $episode) {
        $this->episode = $episode;
    }

    public function render():string {
        
            return <<< HTML
            <div class="Description-episode">
                <h3><strong>Titre :</strong> {$this->episode->titre}</h3>
                <p><strong>Résumé :</strong> {$this->episode->resume}</p>
                <p><strong>Durée:</strong> {$this->episode->duree} secondes</p>
            </div>
            HTML;
              
        
    }
}