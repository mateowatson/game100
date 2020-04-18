<?php
namespace F3AppSetup\Controller\Games;

use F3AppSetup\Domain\HangmanAPI;

class Hangman extends \F3AppSetup\Controller\Middleware\User {
    public function show() {
        $this->enqueue_scripts->enqueueFooterScripts(array(
            $this->f3->get('SITE_URL').'/dist/app.js',
            $this->f3->get('SITE_URL').'/dist/hangman/vendor.js',
            $this->f3->get('SITE_URL').'/dist/hangman/manifest.js',
            $this->f3->get('SITE_URL').'/dist/hangman/app.js'
        ));
        echo \View::instance()->render('games/hangman.php');
    }
}