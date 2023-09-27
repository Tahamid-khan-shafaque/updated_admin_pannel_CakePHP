<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Utility\Security;
use Cake\Mailer\Email;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('user'));
    }

  
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('User');
    }

    public function add()
{
    if ($this->request->is('post')) {
        $request_data = $this->request->getData();

        if ($this->loadComponent('User')->addUser($request_data)) {
            return $this->redirect(['action' => 'index']);
        }

        $user = $this->Users->newEmptyEntity();
        $user = $this->Users->patchEntity($user, $request_data);

        if ($this->Users->save($user)) {
            $this->Flash->success(__('The user has been saved'));
        } else {
            $this->Flash->error(__('The user could not be saved. Please, try again'));
        }
    }

    $user = $this->Users->newEmptyEntity();
    $this->set(compact('user'));
    
 
    return null;
}


public function edit($id = null)
{
    $this->loadComponent('Flash');

    if ($this->request->is(['patch', 'post', 'put'])) {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        $user = $this->Users->patchEntity($user, $this->request->getData());
        
        if ($this->Users->save($user)) {
            $this->Flash->success(__('The user has been saved.'));
            return $this->redirect(['action' => 'index']);
        } else {
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
    }
    
    $user = $this->Users->get($id, [
        'contain' => [],
    ]);
    
    $this->set(compact('user'));
}
    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        
        $this->User->deleteUser($id);
    }
    //register 
    public function register(){
        $user = $this->Users->newEntity($this->request->getData());
        if($this->request->is('post')){
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if($this->Users->save($user)){
                $this->Flash->success('You are registered and can login');
                return $this->redirect(['action' => 'login']);
            } else {
                $this->Flash->error('You are not registered');
            }
        }
        $this->set(compact('user'));
        $this->set('_serialzie', ['user']);
    }
    
    public function beforeFilter(\Cake\Event\EventInterface $event){
        $this->Auth->allow(['register']);
    }

    //log-in
    public function login(){
        if($this->request->is('post')){
            $user = $this->Auth->identify();
            if($user){
                $this->Auth->setUser($user);
                return $this->redirect(['controller' => 'persons']);
            }
            // Bad Login
            $this->Flash->error('Incorrect Login');
        }
    }
    public function logout(){
        $this->Flash->success('You are logged out');
        return $this->redirect($this->Auth->logout());
   }
   //forget password
   public function forgetPassword() {
    if ($this->request->is('post')) {
        $email = $this->request->getData('email');
        $user = $this->Users->findByEmail($email)->first();

        if ($user) {
            // Generate a random password reset token
            $token = Security::hash(Security::randomBytes(32));

            // Save the token to the user's account in the database
            $user->password_reset_token = $token;
            if ($this->Users->save($user)) {
                // Send the user an email with the reset token
                $email = new Email('default');
                $email->setTo($user->email)
                ->setSubject('Reset your password')
                ->send('Click this link to reset your password: ' . Router::url(['controller' => 'Users', 'action' => 'resetPassword', $token], true));
            }
        }

        // Show a success message, even if the email doesn't exist in our database (for security reasons)
        $this->Flash->success(__('If the email address exists in our system, a password reset link has been sent.'));
    }
    //reset password
    
}
//reset password
public function resetPassword($token) {
    if ($this->request->is('post')) {
        $user = $this->Users->findByPasswordResetToken($token)->first();

        if ($user) {
            $password = $this->request->getData('password');
            $confirmPassword = $this->request->getData('confirm_password');

            // Check if the passwords match
            if ($password === $confirmPassword) {
                // Update the user's password
                $user->password = $password;
                $user->password_reset_token = null; // Clear the reset token

                if ($this->Users->save($user)) {
                    // Show a success message
                    $this->Flash->success(__('Your password has been updated.'));
                } else {
                    // Show an error message
                    $this->Flash->error(__('There was a problem updating your password.'));
                }
            } else {
                // Show an error message
                $this->Flash->error(__('The passwords do not match.'));
            }
        } else {
            // Show an error message
            $this->Flash->error(__('Invalid password reset token.'));
        }
    }

    // Render the reset_password view
    $this->render('reset_password');
}

   
}
