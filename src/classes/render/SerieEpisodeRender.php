<?php

namespace iutnc\SAE_APP_WEB\render;

use iutnc\SAE_APP_WEB\video\Episode;
use iutnc\SAE_APP_WEB\video\Series;

class SerieEpisodeRender implements Render {
  
    protected Episode $episode;

    public function __construct( Episode $episode) {
        $this->episode = $episode;
    }

    public function render():string {
        return <<< HTML
            <div class="video-item">
                <a href="?action=DisplayEpisodeAction&id_episode={$this->episode->id}"><h3>{$this->episode->titre} - Episode {$this->episode->numero}</h3></a>
                <p>{$this->episode->resume}</p>

            </div>
        HTML;
    }

}