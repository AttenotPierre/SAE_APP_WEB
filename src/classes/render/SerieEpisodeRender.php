<?php

namespace iutnc\SAE_APP_WEB\render;

use iutnc\SAE_APP_WEB\video\Episode;
use iutnc\SAE_APP_WEB\video\Series;
use iutnc\SAE_APP_WEB\repository\Repository;


class SerieEpisodeRender implements Render {
  
    protected Episode $episode;

    public function __construct( Episode $episode) {
        $this->episode = $episode;
    }

    public function render():string {
        $image = Repository::getInstance()->getimagebyepisode((int)$this->episode->id);
        $titre = htmlspecialchars($this->episode->titre);
        $resume = htmlspecialchars($this->episode->resume);
        $duree = htmlspecialchars($this->episode->duree);
        $numero = htmlspecialchars($this->episode->numero);
        return <<<HTML
        <div class="serie-card">
                <a href="?action=DisplayEpisodeAction&id_episode={$this->episode->id}&id_serie={$this->episode->serieId}">
                    <img src="$image" alt="$titre" class="serie-image">
                </a>
            <h3 class="serie-title">$titre episode $numero</h3>
            <p> $resume </p>
        </div>
        HTML;


        // return <<< HTML
        //     <div class="video-item">
        //         <a href="?action=DisplayEpisodeAction&id_episode={$this->episode->id}&id_serie={$this->episode->serieId}"><h3>{$this->episode->titre} - Episode {$this->episode->numero}</h3></a>
        //         <p>{$this->episode->resume}</p>

        //     </div>
        // HTML;
    }

}