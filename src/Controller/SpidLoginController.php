<?php
namespace Drupal\spid_login\Controller;
class SpidLoginController {
    public function index() {
        return array(
                '#title' => 'SPID Login',
                '#markup' => '<h2>Login Initial Route</h2>',
            );
    }
}
