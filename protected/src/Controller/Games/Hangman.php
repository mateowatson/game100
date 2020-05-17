<?php
namespace F3AppSetup\Controller\Games;

use F3AppSetup\Domain\HangmanAPI;

class Hangman extends \F3AppSetup\Controller\Middleware\User {
    private $hangman_api;

    public function __construct($f3, $params) {
        parent::__construct($f3, $params);
        $this->hangman_api = new HangmanAPI();
    }

    public function show() {
        $this->enqueue_scripts->enqueueFooterScripts(array(
            $this->f3->get('SITE_URL').'/dist/app.js',
            $this->f3->get('SITE_URL').'/dist/hangman/vendor.js',
            $this->f3->get('SITE_URL').'/dist/hangman/manifest.js',
            $this->f3->get('SITE_URL').'/dist/hangman/app.js'
        ));
        echo \View::instance()->render('games/hangman.php');
    }

    public function getApiState() {
        $response = $this->hangman_api->getApiState(
            $this->session_user,
            $this->params['uuid']
        );
        echo json_encode($response);
        return $response;
    }

    public function sendGameInvite() {
        $game_uuid = $this->params['uuid'];
        $invitee = $this->params['invitee'];
        $response = $this->hangman_api->addUserToGame($game_uuid, $invitee);
        echo json_encode($response);
        return $response;
    }
}