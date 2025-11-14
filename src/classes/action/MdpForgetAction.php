<?php

namespace iutnc\SAE_APP_WEB\action;

use iutnc\SAE_APP_WEB\repository\Repository;

class MdpForgetAction extends Action {

    public function generateActivationToken(): string
    {
        return bin2hex(random_bytes(16));
    }
    public function __invoke(): string
    {
        $token = $this->generateActivationToken();
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return <<<HTML
            <form method="POST" action="?action=mdp_forget">
                <label for="email">Entrez votre adresse e-mail :</label>
                <input type="email" id="email" name="email" required>
                <button type="submit">Réinitialiser le mot de passe</button>
            </form>
            HTML;
        } else {
            $email = $_POST['email'];
            $_SESSION['email'] = $email;

            $repo = Repository::getInstance();
            $results = $repo->IsUserActive($email);
            if (!$results) {
                return "<p>L'adresse e-mail n'est pas associée à un compte actif.</p>";
            } else {
                $repo->InsertToken($token, $email);
                $resetLink = "http://localhost/SAE_APP_WEB/index.php?action=reset_password&token=$token";
                return <<<HTML
                <p>Cliquez sur le lien suivant pour réinitialiser votre mot de passe :</p>
                <a href="$resetLink">$resetLink</a>
                HTML;


            }

        }
    }

}