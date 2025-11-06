<?php

namespace iutnc\SAE_APP_WEB\Dispatch;
use iutnc\SAE_APP_WEB\action;
use iutnc\SAE_APP_WEB\exception\AuthException;
use Random\RandomException;


class Dispatcher {
    private string $action;

    public function __construct(string $action) {
        if (!isset($_GET['action'])) {
            $_GET['action'] = 'default';
        }
        $this->action = $action;
    }

    /**
     * @throws RandomException
     * @throws AuthException
     * @throws \Exception
     */
    public function run() : void{
        $html = '';
       switch ($this->action) {
        case 'auth':
            $html = (new action\AuthAction())();
            break;
        case 'register':
            $html = (new action\RegisterAction())();
            break;
        case 'deconnect':
            $html = (new action\DeconnectAction())();
            break;
        case 'display-catalog':
            $html = (new action\DisplayCatalogAction())();
            break;
        case 'displayMyList':
            $html = (new action\DisplayMyListAction)();
            break;
        case 'noter':
            $html = (new action\NoterAction())();
            break;
        case 'displayAllNoteAction':
            $html = (new action\DisplayAllNoteAction())();
            break;
        case 'ajoutListeAction':
            $html = (new action\AddSeriesMyListAction())();
            break;
        case 'supprListeAction':
            $html = (new action\DelSeriesMyListAction())();
            break;
        case 'DisplayEpisodeAction':
            $html = (new action\DisplayEpisodeAction())();
            break;
        case 'RegarderAction':
            $html = (new action\RegarderAction())();
            break;
        case 'displaySerie':
            $html = (new action\DisplaySerieAction())();
            break;
        case 'home':
            $html = (new action\ActionHome())();
            break;
        case 'activeAccount':
            $html = (new action\ActivateAction())();
            break;
        case 'search':
            $html = (new action\SearchAction())();
            break;
        case 'DisplaySerieFiniAction':
            $html = (new action\DisplayListSerieFiniAction())();
            break;
        default:
            $html = (new action\DefaultAction())();
            break;
       }
       $this->renderPage($html);
    }

    private function renderPage(string $content): void {
        echo <<<FIN
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="css/style.css">
            <title>Deefy App</title>
        </head>
        <body>
            <header class="container">
            <h1>NetVod</h1>
            <nav>
                
                    <a href="?action=home">Home</a>
                    <a href="?action=display-catalog">Catalogue</a>
                    <a href="?action=displayMyList">Ma Liste</a>
                    <a href="?action=DisplaySerieFiniAction">Séries Terminées</a>
                    <a href="?action=auth">Authentification</a>
                    <a href="?action=register">Inscription</a>
                    <a href="?action=deconnect">Déconnexion</a>
                
            </nav>    
            </header>
            $content
        </body>
        </html> 
        FIN;
    }


}