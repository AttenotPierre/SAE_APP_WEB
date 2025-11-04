<?php

namespace iutnc\SAE_APP_WEB\action;

use iutnc\SAE_APP_WEB\repository\Repository;
use iutnc\SAE_APP_WEB\render\EpisodeRender;
use iutnc\SAE_APP_WEB\render\SerieEpisodeRender;

class DisplaySerieAction extends Action{
    public function __invoke(): string {

        $id_serie = $_GET['id_serie'];
        $serie = Repository::getInstance()->getEpisodesBySerieId($id_serie);
        $html = "<div class='serie'>\n";
        $html .= "<h2>{$serie->titre}</h2>\n";
        foreach ($serie->episodes as $episode) {
            $episodeRender = new SerieEpisodeRender($episode);
            $html .= $episodeRender->render();
        }
        $html .= "</div>\n";
        return $html;
    }
}