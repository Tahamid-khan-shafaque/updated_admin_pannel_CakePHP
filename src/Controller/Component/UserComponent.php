<?php

namespace App\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
class UserComponent extends Component
{
    protected $Users;
    protected $Flash;

    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->Users = TableRegistry::getTableLocator()->get('Users');
        $this->Flash = $this->getController()->loadComponent('Flash');
    }

    public function addUser($requestData)
    {
        $user = $this->Users->newEmptyEntity();
        $user = $this->Users->patchEntity($user, $requestData);
    }
    
    public function editUser($id, $requestData)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);

        $user = $this->Users->patchEntity($user, $requestData);

     
    }
    //DELETE
    public function deleteUser($id)
    {
        $user = $this->Users->get($id);

        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->getController()->redirect(['action' => 'index']);
    }
}