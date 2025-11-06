<?php

namespace iutnc\SAE_APP_WEB\render;

use iutnc\SAE_APP_WEB\video\Episode;
use iutnc\SAE_APP_WEB\video\Series;
use iutnc\SAE_APP_WEB\repository\Repository;


class EpisodeRender implements Render{

    protected Episode $episode;  

    public function __construct(Episode $episode) {
        $this->episode = $episode;
    }

    public function render():string {
        $image = Repository::getInstance()->getimagebyepisode((int)$this->episode->id);
        $titre = htmlspecialchars($this->episode->titre);
        $resume = htmlspecialchars($this->episode->resume);
        $duree = htmlspecialchars($this->episode->duree);
        return <<<HTML
        
        <div class="serie-card">
                <img src="$image" alt="$titre" class="serie-image">
            <h3 class="serie-title">$titre  $duree s</h3>
            <p> $resume </p>
        </div>
        HTML;
              
    }
}