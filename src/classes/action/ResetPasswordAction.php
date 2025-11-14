<?php

namespace iutnc\SAE_APP_WEB\action;

use iutnc\SAE_APP_WEB\repository\Repository;

class ResetPasswordAction extends Action
{
    public function __invoke(): string
    {
        $html = "";
        if (empty($_GET['token'])) {
            return "<p>Lien d'activation manquant.</p>";
        }
        $token = $_GET['token'];
        $repo = Repository::getInstance();
        $userData = $repo->getHashAndEmailByToken($token);
        $_SESSION['reset_user_email'] = $userData['email'];
        if (!$userData) {
            return "<p>Lien de réinitialisation invalide.</p>";
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return <<<HTML
                <form method="POST" action="?action=reset_password&token={$token}">
                    <label for="new_password">Nouveau mot de passe :</label>
                    <input type="password" id="new_password" name="new_password" required>
                    <button type="submit">Réinitialiser le mot de passe</button>
                </form> 
                HTML;
        } else {
            $newPassword = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
            $email = $_SESSION['reset_user_email'] ?? null;
            $repo->updatePassword($newPassword, $email);
            $repo->deleteTokenByEmail($email);
            $html .= "<p>Votre mot de passe a bien été réinitialisé ! Vous pouvez maintenant vous connecter.</p>";
            return $html;
        }
    }
}