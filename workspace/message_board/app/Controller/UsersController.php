<?php

use function Safe\json_decode;

class UsersController extends AppController
{
    public $uses = ['User'];
    public function beforeFilter()
    {
        parent::beforeFilter();
        // always restrict your whitelists to a per-controller basis
    }

    public function login()
    {

        if ($this->request->is('post')) {

            $didLogin = $this->Auth->login(); //Check if the user has successfully logged in
            $status = 'success';
            $msg['login'] = 'Login success!';
            if (!$didLogin) { //If the user has not successfully logged in, return an error message
                $status = 'error';
                $msg['login'] = 'Invalid email or password, try again';
            } else {
                // Retrieve the logged-in user's ID
                $userId = $this->Auth->user('id');

                // Find the user record based on the ID
                $user = $this->User->findById($userId);

                if ($user) {
                    // Update the last_login_time
                    $user['User']['last_login_time'] = date('Y-m-d H:i:s');
                    unset($user['User']['password'], $user['User']['c_password'], $user['User']['birthdate']);

                    // Save the updated user record
                    $this->User->save($user);

                    // Debugging output
                    // if ($this->User->save($user)) {
                    //     debug('User updated successfully');
                    // } else {
                    //     debug('User could not be updated');
                    //     debug($this->User->validationErrors);
                    //     debug($this->User->getLastError());
                    // }
                }
            }
            //Return the status of the login and the message
            die(json_encode(array(
                "status" => $status,
                "message" => $msg,
                "user" => $this->Auth->user()
            )));
        }
    }

    public function register()
    {

        if ($this->request->is('post')) {
            $this->User->create();
            // Append the current date and time to the user data
            $this->request->data['User']['last_login_time'] = date('Y-m-d H:i:s');
            $this->request->data['User']['date_added'] = date('Y-m-d H:i:s');
            // If the user has been saved successfully, return a success message
            if ($this->User->save($this->request->data)) {
                // Get the user ID of the newly created user
                $userId = $this->User->id; // Use $this->User->id to get the last inserted ID

                // Fetch the user data by ID
                $user = $this->User->findById($userId);
                if ($user) {
                    // Automatically log the user in after successful registration
                    $this->Auth->login($user['User']); // Pass the retrieved user data
                    die(json_encode(array(
                        'status' => 'success',
                    )));
                } else {
                    die(json_encode(array(
                        'status' => 'error',
                        'message' => 'User data could not be retrieved.'
                    )));
                }
            } else { // If the user has not been saved successfully, return the validation errors to be loop and displayed in the view
                die(json_encode(array(
                    'status' => 'error',
                    'message' => $this->User->validationErrors
                )));
            }
        }
    }
    public function thankyou()
    {
        // Redirect to the login page if the user is trying to access this page
        if (!$this->Auth->user()) {
            return $this->redirect('login');
        }
    }


    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }
    public function profile()
    {
        $userId = $this->Auth->user('id'); // Current logged-in user ID
        $this->User->id = $userId;
        $user = $this->User->findById($userId);
        $this->set('userProfile', $user['User']);
        // Handle GET request for fex`tching user details by uid param
        if ($this->request->is('get')) {
            // Check if 'uid' is present in the query string (GET request)
            if (!empty($this->request->query('uid'))) {
                $uid = $this->request->query('uid');
                // Fetch user data by uid
                $user = $this->User->findById($uid);
                if ($user) {
                    // Assign fetched user data to 'userProfile' view variable
                    $this->set('userProfile', $user['User']);
                } else {
                    $this->redirect('profile');
                }
            }
        }

        // Handle POST/PUT request for updating profile
        if ($this->request->is('post') || $this->request->is('put')) {
            // Validate the data before handling file upload
            $fieldsToValidate = ['name', 'email', 'birthdate', 'gender', 'hobby', 'image'];
            $this->User->set($this->request->data);

            // Perform validation check first
            if ($this->User->validates(['fieldList' => $fieldsToValidate])) {
                if (!empty($this->request->data['User']['image']['tmp_name'])) {
                    $file = $this->request->data['User']['image'];
                    $uploadPath = WWW_ROOT . 'img' . DS . 'uploads' . DS;
                    $filename = $this->_uploadFile($file, $uploadPath);

                    if ($filename) {
                        $this->request->data['User']['image'] = $filename;
                    } else {
                        $response = array(
                            'status' => 'error',
                            'message' => (object) array(
                                'image' => ['Failed to upload image.']
                            ),
                        );
                        die(json_encode($response));
                    }
                } else {
                    unset($this->request->data['User']['image']);
                }
                $this->request->data['User']['date_updated'] = date('Y-m-d H:i:s');
                if ($this->User->save($this->request->data, true, $fieldsToValidate)) {
                    $response = array('status' => 'success', 'message' => 'Profile updated successfully.');
                    die(json_encode($response));
                }
            } else {
                // If validation fails, return the error messages
                $response = array('status' => 'error', 'message' => $this->User->validationErrors);
                die(json_encode($response));
            }
        }
    }




    private function _uploadFile($file, $uploadPath)
    {
        App::uses('File', 'Utility');
        // Generate a unique filename
        $filename = uniqid() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        // Move the uploaded file to the destination folder
        $uploadFile = new File($file['tmp_name']);
        // Move the file from the tmp location to the desired upload path
        if ($uploadFile->copy($uploadPath . $filename)) {
            return $filename;
        }

        return false;
    }
}
