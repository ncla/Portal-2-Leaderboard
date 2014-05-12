<?php
class View {
    /* View model defaults */
    public $css = array();

    public $js = array();

    /* Used for forcing update for client side cached files */
    public $browserCacheVersion = "0.1";

    public function __construct() {
        $this->siteTitle = "P2 Board &#187; ";
        $this->pageName = "Home";
        $this->addJs("/js/jquery-1.10.2.min.js");
        $this->addCss("/style.css");
    }
    public function addJs($path) {
        $this->js[] = $path;
        return $this;
    }

    public function addCss($path) {
        $this->css[] = $path;
        return $this;
    }
}