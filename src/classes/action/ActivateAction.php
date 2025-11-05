<?php

namespace iutnc\SAE_APP_WEB\action;

use Exception;
use iutnc\SAE_APP_WEB\action\Action;
use iutnc\SAE_APP_WEB\repository\Repository;

class ActivateAction extends Action {
    /**
     * @throws Exception
     */
    public function __invoke() : string {
        $html = "";
        if ($_GET['token'] || empty($_GET['token']) !== null) {
            return "<p>Lien d'activation invalide.</p>";
        }
        $token = $_GET['token'];
        $repo = Repository::getInstance();
        $tokenBD = $repo->getTokenHash();
        if (!password_verify($token, $tokenBD)) {
            return "<p>Lien d'activation invalide.</p>";
        }
        $repo->activateUser();
        $html .= "<p>Votre compte a bien été activé ! Vous pouvez maintenant vous connecter.</p>";

        return $html;
    }
}