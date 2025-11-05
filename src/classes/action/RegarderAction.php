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

        if (!isset($_GET['id_serie'])) {
            return "<p>Aucune série sélectionnée.</p>";
        }

        $id_serie = (int) $_GET['id_serie'];

        $id_episode = (int) $_GET['id_episode'];
        $repo = Repository::getInstance();
        $episode = $repo->getEpisodeById($id_episode);

        if (!$episode) {
            return "<p>Épisode introuvable.</p>";
        }
        $chemin_video = "videos/".$episode->chemin;
        
        
        
        
        
        $html = "<h2>Lecture en cours : {$episode->titre}</h2>";
        $html .= "<p>Durée : {$episode->duree} secondes</p>";

        // Lecteur vidéo HTML5
        $html .= <<<HTML
        <video controls autoplay>
            <source src="$chemin_video" type="video/mp4">
            Votre navigateur ne supporte pas la lecture vidéo.
        </video>
        HTML;

        $html .= <<<HTML
            <form method="POST" action="?action=noter">
                            <label for="note">Note (1-5) :</label>
                            <input type="number" id="note" name="note" min="1" max="5" required>
                            <br>
                            <label for="comment">Commentaire :</label>
                            <br>
                            <textarea id="comment" name="comment"></textarea>
                            <br>
                            <input type="hidden" name="id_serie" value="$id_serie">
                            <input type="submit" value="Noter">
            </form>
        HTML;
        $html .= "<div><a href='?action=display-catalog'>⬅ Retour à la fiche</a></div>";
        $html .= "</div>";
        return $html;
    }
}
