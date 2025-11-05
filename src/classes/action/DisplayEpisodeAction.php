<?php

namespace iutnc\SAE_APP_WEB\action;
use iutnc\SAE_APP_WEB\exception\AuthException;
use iutnc\SAE_APP_WEB\repository\Repository;
use iutnc\SAE_APP_WEB\render\EpisodeRender;

class DisplayEpisodeAction extends Action {

    public function __invoke() : string {
        $id_episode = $_GET['id_episode'];
        $id_serie = $_GET['id_serie'];
        if(!isset($_SESSION['user'])){
            return "<p>Connecte toi pour regarder l'episode stp</p>";
        }
        

        $repo = Repository::getInstance();
        //faire methode getEpisodeById dans repository
        $episode = $repo->getEpisodeById($id_episode);
        if(!$episode){
            return "<p>Episode introuvable</p>";
        }
        
        $renderer = New EpisodeRender($episode);
        $html= $renderer->render();
<<<<<<< HEAD
        $html .= "<a href='?action=RegarderAction&id_episode=$id_episode'>Regarder</a><br>";
=======
        $html .= "<a href='?action=RegarderAction&id_episode=$id_episode&id_serie=$id_serie'>Regarder</a><br>";
        $repo -> setEnCoursSerie($episode->serieId);
>>>>>>> 74e68a0cc7c6c3decf2b3076762960dbe197bfe8
        return $html;
    
    }

}