<?php

namespace iutnc\SAE_APP_WEB\action;

use iutnc\SAE_APP_WEB\repository\Repository;
use iutnc\SAE_APP_WEB\render\EpisodeRender;
use iutnc\SAE_APP_WEB\render\SerieEpisodeRender;

class DisplaySerieAction extends Action{
    public function __invoke(): string {
        $id_user = Repository::getInstance()->getUserIdByEmail($_SESSION['email']);
        $pseudo = Repository::getInstance()->getUserPseudo($id_user);
        $id_serie = $_GET['id_serie'];
        $serie = Repository::getInstance()->getEpisodesBySerieId($id_serie);
        $html = "<div class='serie'>\n";
        $html .= "<h2>{$serie->titre}</h2>\n";
        $avis = Repository::getInstance()->getAvisByEpisodeId($id_serie);
        $listeAvis = "";
        foreach ($avis as $unAvis) {
            $listeAvis .= "<li>{$pseudo} - Note : {$unAvis['note']} - Commentaire : {$unAvis['commentaire']}</li>";
        }
        foreach ($serie->episodes as $episode) {
            $episodeRender = new SerieEpisodeRender($episode);
            $html .= $episodeRender->render();
        }

        $html .= "</div>\n";
        $html .= "<div class='avis'>\n";
        $html .= "<h3>Avis des utilisateurs :</h3>\n";
        $html .= "<ul>\n";
        $html .= $listeAvis;
        $html .= "</ul>\n";
        return $html;
    }
}