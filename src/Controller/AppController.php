<?php
declare(strict_types=1);


namespace App\Controller;

use Cake\Controller\Controller;


class AppController extends Controller
{
    protected $viewVars = [];
  
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password'
                    ]
                ]
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login',
            ]
        ]);
    }
   
    public function beforeRender(\Cake\Event\EventInterface $event)
    {
        if (is_array($this->viewVars) && !array_key_exists('_serialize', $this->viewVars) &&
    in_array($this->response->getType(), ['application/json', 'application/xml'])
) {
    $this->set('_serialize', true);
}

// Login Check
if ($this->getRequest()->getSession()->read('Auth.User')) {
    $this->set('loggedIn', true);
} else {
    $this->set('loggedIn', false);
}
    }
}


