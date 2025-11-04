<?php
namespace iutnc\SAE_APP_WEB\action;

use iutnc\SAE_APP_WEB\repository\Repository;

class RegarderAction {
    public function __invoke(): string {
        if (!isset($_SESSION['user'])) {
            return "<p>Connecte-toi pour regarder l'épisode.</p>";
        }

        if (!isset($_GET['id_episode'])) {
            return "<p>Aucun épisode sélectionné.</p>";
        }

        $id_episode = (int) $_GET['id_episode'];
        $repo = Repository::getInstance();
        $episode = $repo->getEpisodeById($id_episode);

        if (!$episode) {
            return "<p>Épisode introuvable.</p>";
        }
        $chemin_video = "videos/".$episode->chemin;
        
        
        
        
        $html = "<p> {$chemin_video} </p>";
        $html .= "<h2>Lecture en cours : {$episode->titre}</h2>";
        $html .= "<p>Durée : {$episode->duree} secondes</p>";

        // Lecteur vidéo HTML5
        $html .= <<<HTML
        <video controls autoplay>
            <source src="$chemin_video" type="video/mp4">
            Votre navigateur ne supporte pas la lecture vidéo.
        </video>
        HTML;

        $html .= "<div><a href='?action=display-catalog'>⬅ Retour à la fiche</a></div>";
        $html .= "</div>";
        return $html;
    }
}
