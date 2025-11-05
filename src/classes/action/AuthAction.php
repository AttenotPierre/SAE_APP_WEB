<?php
namespace iutnc\SAE_APP_WEB\action;
use iutnc\SAE_APP_WEB\exception\AuthException;
use iutnc\SAE_APP_WEB\auth\AuthProvider;
use iutnc\SAE_APP_WEB\exception\TokenException;
use iutnc\SAE_APP_WEB\repository\Repository;

class AuthAction extends Action{
    /**
     * @throws \Exception
     */
    public function __invoke(): string {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
           return <<<HTML
            <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
            </head>
            <body>
                <h1>Authentification</h1>
                <form action="?action=auth" method="post" enctype="multipart/form-data">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" required>
                    <br>
                    <label for="mdp">Mot de passe :</label>
                    <input type="password" id="mdp" name="mdp" required>
                    <br>
                    <input type="submit" value="S'authentifier">
                </form>
            </body>
            </html>
            HTML;
        }else{
            $mail = $_POST['email'];
            $repo = Repository::getInstance();
            $UserActive = $repo->isUserActive($mail);
            if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                try {
                    AuthProvider::signin($mail, $_POST['mdp']);

                } catch (AuthException $e) {
                    return "<p class='center'>email ou mot de passe incorrect</p><a href='?action=auth'>Se reconnecter</a>";
                } catch (TokenException $e) {
                    return "<p class='center'>Compte non-activé !</p>";
                }
            } else{
                return "<p class='center'>email incorrect</p><a href='?action=auth'>Se reconnecter</a>";
            }
            $_SESSION['email'] = $mail;
            return "<p class='center'>Authentification réussie pour l'utilisateur : $mail</p>";
        }
    }

}
