<?php

namespace iutnc\SAE_APP_WEB\render;

use classes\video\Episode;

class VideoRender implements Render{

    protected Episode $video;  

    public function __construct(Episode $video) {
        $this->video = $video;
    }

    public function render():string {
        return <<< HTML
            <div class="video-item">
                <h3>{$this->video->titre}</h3>
                <p>Episode : {$this->video->numero}</p>
                <video src="{$this->video->chemin}" controls></video>
            </div>
        HTML;
    }

}
