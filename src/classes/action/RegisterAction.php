<?php
namespace iutnc\SAE_APP_WEB\action;
use iutnc\SAE_APP_WEB\exception\AuthException;
use iutnc\SAE_APP_WEB\auth\AuthProvider;

class RegisterAction extends Action{
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
            filter_var($pseudo, FILTER_SANITIZE_STRING); 
            $mail = $_POST['email'];

            if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                try{
                    AuthProvider::register($mail,$_POST['mdp'],$pseudo);
                } catch(AuthException $e) {
                    return "<p class='center'>Erreur lors de l'inscription (Mot de passe Invalide ou utilisateur déjà existant)</p><a href='?action=auth'>Se reconnecter</a>";
                }
            }else{
                throw new AuthException("REGISTER ERROR");
            }

            
                
            $_SESSION['email'] = $mail;
            return "<p class='center'>Inscription réussie pour l'utilisateur : $pseudo</p>";
        }
    }

}
