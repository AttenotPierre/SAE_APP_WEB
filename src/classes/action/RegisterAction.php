<?php
namespace iutnc\SAE_APP_WEB\action;
use iutnc\SAE_APP_WEB\exception\AuthException;
use iutnc\SAE_APP_WEB\auth\AuthProvider;
use iutnc\SAE_APP_WEB\repository\Repository;
use Random\RandomException;

class RegisterAction extends Action{

    /**
     * @throws RandomException
     */
    public function generateActivationToken(): string {
        return bin2hex(random_bytes(16));
    }

    /**
     * @throws RandomException
     * @throws AuthException
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
                <h1>Inscription</h1>
                <form action="?action=register" method="post" enctype="multipart/form-data">
                    <label for="Pseudo">Pseudo :</label>
                    <input type="pseudo" id="pseudo" name="pseudo" required>
                    <br>
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" required>
                    <br>
                    <label for="mdp">Mot de passe :</label>
                    <input type="password" id="mdp" name="mdp" required>
                    <br>
                    <input type="submit" value="S'enregistrer">
                </form>
            </body>
            </html>
            HTML;
        }else{
            $pseudo = $_POST['pseudo'];

            $mail = $_POST['email'];
            $token = $this->generateActivationToken();
            $repo = Repository::getInstance();

            if (filter_var($mail, FILTER_VALIDATE_EMAIL) && filter_var($pseudo, FILTER_SANITIZE_STRING)) {
                try{
                    AuthProvider::register($mail,$_POST['mdp'],$pseudo);
                    $repo->InsertToken($token, $mail);
                } catch(AuthException $e) {
                    return "<p class='center'>Erreur lors de l'inscription (Mot de passe Invalide ou utilisateur déjà existant)</p><a href='?action=auth'>Se reconnecter</a>";
                }
            }else{
                throw new AuthException("REGISTER ERROR");
            }

            
                
            $_SESSION['email'] = $mail;
            $baseURL = "http://localhost/SAE_APP_WEB/ActivateAction.php";
            $activationLink = $baseURL . "?token=" . $token;
            return "<p class='center'>Inscription réussie pour l'utilisateur : $pseudo</p>
                    <p>Veuillez activer votre compte en cliquant sur le lien suivant :</p>
                    <a href='$activationLink'>$activationLink</a>";
        }
    }

}
