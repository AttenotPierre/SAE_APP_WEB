<?php

namespace iutnc\SAE_APP_WEB\action;

use iutnc\SAE_APP_WEB\repository\Repository;

class DisplayMyList extends Action {

    public function __invoke() : string {
        if (isset($_SESSION['user'])) {
            $email = $_SESSION['user'];
            $liste = DeefyRepository::getInstance()->getSeriePref($email);
            // $renderer = new AudioListRenderer($playlist);
            // $rendu .= '<a href="?action=add-Podcast">Ajouter une Podcast</a> <br>';
            // $rendu .= '<a href="?action=add-Track">Ajouter une musique</a>';
            $html = "<div class='playlist-list'>" . $liste . "</div>";
            return $html;
        } else {
            return "<p class='center'>Aucune playlist disponible. Veuillez en créer une d'abord.</p>";
        }
    }

}