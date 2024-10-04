<?php

/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class User extends AppModel
{
    public $validate = array(
        'name' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Name cannot be empty.',
                'allowEmpty' => false,
                'required' => true,
            ),
            'length' => array(
                'rule' => array('lengthBetween', 5, 20),
                'message' => 'Name must be between 5 and 20 characters.',
                'allowEmpty' => false,
                'required' => true,
            ),
        ),
        'email' => array(
            'email' => array(
                'rule' => array('email'),
                'message' => 'Please provide a valid email address.',
                'allowEmpty' => false,
                'required' => true,
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'This email is already in use.',
            ),
        ),
        'password' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please enter your password.',
            ),
            'password_confirm' => array(
                'rule' => 'password_confirm',
                'message' => 'Passwords do not match.',
            ),
        ),
        'c_password' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please confirm your password.',
            ),
        ),
        'image' => array(
            'extension' => array(
                'rule' => array('extension', array('jpg', 'jpeg', 'gif', 'png')),
                'message' => 'Please upload a valid image file (jpg, jpeg, gif, png)',
                'allowEmpty' => true, // Optional: if image upload is not required
                'required' => false,  // Optional: to not make image required
            ),
        ),

        'gender' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Gender cannot be empty',
                'required' => false,
            ),
        ),
        'birthdate' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Birthdate cannot be empty',
                'required' => false,
            ),
            'date' => array(
                'rule' => array('date'),
                'message' => 'Please enter a valid date',
            ),
        ),
        'hobby' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Hobby cannot be empty',
                'required' => false,
            ),
        ),
        'last_login_time' => array(
            'date' => array(
                'rule' => array('datetime'),
            ),
        ),
    );
    public function password_confirm($check)
    {
        // Check if the two provided passwords match
        $data = $this->data;
        return ($data['User']['password'] === $data['User']['c_password']);
    }
    public function beforeSave($options = array())
    {
        // Hash the password before saving it
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        return true;
    }
}
