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

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class Message extends AppModel
{
    public $validate = array(
        'sent_to' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Recipient cannot be blank.',
                'allowEmpty' => false,
                'required' => true
            ),
        ),
        'content' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Content cannot be blank.',
                'allowEmpty' => false,
                'required' => true
            ),
            // 'plainText' => array(
            //     'rule' => 'validatePlainText',
            //     'message' => 'Content must be plain text and cannot contain HTML or script tags.',
            // ),
        ),
        'created_ip' => array(
            'ip' => array(
                'rule' => array('ip'),
                'allowEmpty' => false,
            ),
        ),
        'modified_ip' => array(
            'ip' => array(
                'rule' => array('ip'),
                'allowEmpty' => false,
            ),
        ),
    );
    // Custom validation method for plain text
    public function validatePlainText($check)
    {
        $value = array_values($check)[0]; // Get the first value of the array
        // Check if the value contains any HTML tags
        return !preg_match('/<[^>]+>/', $value); // Use / as the delimiter
    }
}
