<?php

namespace iutnc\SAE_APP_WEB\action;
use iutnc\SAE_APP_WEB\repository\Repository;

class DisplayMyList extends Action {

    public function __invoke() : string {
        if (isset($_SESSION['user'])) {
            $email = $_SESSION['user'];
            $user_id = Repository::getInstance()->getUserIdByEmail($email);
            $liste = Repository::getInstance()->getSeriePref($user_id);
            $html = "<div>";
            foreach ($liste as $serie) {
                $html .= "<p>" . htmlspecialchars($serie->titre) . "</p>"; 
            }
            $html .= "</div>";
            return $html;
        } else {
            return "<p class='center'>Aucune série n'a été trouvé</p>";
        }
    }

}