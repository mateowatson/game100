<?php

namespace F3AppSetup\Domain;

class EnqueueScripts {
    private $f3;

    public function __construct() {
        $this->f3 = \Base::instance();
    }

    public function enqueueFooterScripts($paths = array()) {
        $this->f3->set('enqueued_footer_scripts', $paths);
    }

    public function enqueueHeaderScripts($paths = array()) {
        $this->f3->set('enqueued_header_scripts', $paths);
    }
}