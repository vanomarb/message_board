<?php
class MessagesController extends AppController
{
    public $uses = ['Message', 'User'];
    public function beforeFilter()
    {
        parent::beforeFilter();
        if ($this->request->is('post')) {
            $ipAddress = env('HTTP_CLIENT_IP') ? env('HTTP_CLIENT_IP') : env('REMOTE_ADDR');
            $this->request->data['Message']['created_ip'] = $ipAddress;
            $this->request->data['Message']['modified_ip'] = $ipAddress;
            $this->request->data['Message']['sent_from'] = $this->Auth->user('id');
            $this->request->data['Message']['date_added'] = date('Y-m-d H:i:s');
        }
        // always restrict your whitelists to a per-controller basis
    }
    public function index()
    {
        if (isset($_GET['conversation_id']) && !empty($_GET['conversation_id'])) {
            // Render conversation.php instead of index.php
            $this->set('conversation_id', $_GET['conversation_id']);
            $this->render('conversation');
        }
    }
    public function loadConversations()
    {
        $offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
        $limit  = isset($_GET['limit']) ? $_GET['limit'] : 10;
        $messages = $this->Message->query("
        SELECT 
            m.id as message_id, 
            m.content, 
            m.date_added, 
            sender.id AS sender_id, 
            sender.name AS sender_name, 
            sender.email AS sender_email, 
            sender.image AS sender_image, 
            receiver.id AS receiver_id, 
            receiver.name AS receiver_name, 
            receiver.email AS receiver_email, 
            receiver.image AS receiver_image
        FROM 
            messages m 
        LEFT JOIN 
            users AS sender 
        ON 
            sender.id = m.sent_from 
        LEFT JOIN 
            users AS receiver 
        ON 
            receiver.id = m.sent_to 
        WHERE 
            (m.sent_from = " . $this->Auth->user('id') . " 
            AND m.sent_to = " . $_GET['conversation_id'] . ")
            OR (m.sent_from = " . $_GET['conversation_id'] . " 
            AND m.sent_to = " . $this->Auth->user('id') . ")
        ORDER BY 
            m.date_added DESC
        LIMIT 
            " . $offset . "," . $limit . ";
        ");

        // Prepare the messages array for the view
        $messageOptions = [];
        foreach ($messages as $k => &$message) {
            $message['m']['date_added'] = date('F d, Y H:i:s', strtotime($message['m']['date_added']));
            $message['m']['timestamp'] = $this->timeAgo($message['m']['date_added']);
            $message['m']['auth_user'] = $this->Auth->user('id');
            $messageOptions[$k] = array_merge($message['m'], $message['sender'], $message['receiver']);
        }
        die(json_encode(array(
            'status' => 'success',
            'data' => $messageOptions
        )));
    }
    //create a timeago or timestamp function
    function timeAgo($timestamp)
    {
        $timeAgo = strtotime($timestamp);
        $currentTime = time();
        $timeDifference = $currentTime - $timeAgo;

        if ($timeDifference < 1) {
            return 'just now';
        }

        $timeUnits = [
            12 * 30 * 24 * 60 * 60 => 'year',
            30 * 24 * 60 * 60       => 'month',
            7 * 24 * 60 * 60        => 'week',
            24 * 60 * 60            => 'day',
            60 * 60                 => 'hour',
            60                      => 'minute',
            1                       => 'second'
        ];

        foreach ($timeUnits as $seconds => $unit) {
            $value = floor($timeDifference / $seconds);
            if ($value >= 1) {
                return $value . ' ' . $unit . ($value > 1 ? 's' : '') . ' ago';
            }
        }
    }
    public function new_message()
    {
        if ($this->request->is('post')) {
            // Debug the incoming request data
            // Bind data to the model
            $this->Message->set($this->request->data);

            // Validation Check
            if ($this->Message->validates()) {
                if ($this->Message->save($this->request->data)) {
                    die(json_encode(array('status' => 'success')));
                }
            } else {
                die(json_encode(array(
                    'status' => 'error',
                    'message' => $this->Message->validationErrors
                )));
            }
        }
    }

    public function deleteMessage()
    {
        if ($this->request->is('post')) {
            // Find the message by its id
            $this->request->data['id'] = $this->request->data['conversation_id'];
            $message = $this->Message->findById($this->request->data['id']);

            // If the message exists and it belongs to the authenticated user, delete it
            if (!empty($message) && $message['Message']['sent_from'] == $this->Auth->user('id')) {
                if ($this->Message->delete($this->request->data['id'])) {
                    die(json_encode(array(
                        'status' => 'success'
                    )));
                }
            } else {
                die(json_encode(array(
                    'status' => 'error',
                    'message' => 'Unable to delete the message'
                )));
            }
        }
    }

    public function deleteMessages()
    {
        if ($this->request->is('post')) {
            // Build conditions for deletion
            $conditions = array(
                'OR' => array(
                    array(
                        'Message.sent_from' => $this->Auth->user('id'),
                        'Message.sent_to' => $this->request->data['conversation_id']
                    ),
                    array(
                        'Message.sent_from' => $this->request->data['conversation_id'],
                        'Message.sent_to' => $this->Auth->user('id')
                    )
                )
            );

            // Delete records that match the conditions
            if ($this->Message->deleteAll($conditions, false)) {
                die(json_encode(array(
                    'status' => 'success'
                )));
            } else {
                die(json_encode(array(
                    'status' => 'error',
                    'message' => 'Unable to delete the message'
                )));
            }
        }
    }

    public function getMessagesList()
    {
        $offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
        $limit  = isset($_GET['limit']) ? $_GET['limit'] : 10;

        // Sanitize and prepare search term
        $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

        // Build the search condition
        // Prepare the search condition
        $searchCondition = '';
        if (!empty($searchTerm)) {
            // Escape the search term to prevent SQL injection
            $escapedSearchTerm = addslashes('%' . $searchTerm . '%');
            $searchCondition = "AND (sender.name LIKE '$escapedSearchTerm' OR receiver.name LIKE '$escapedSearchTerm' OR m.content LIKE '$escapedSearchTerm')";
        }
        $sqlQuery = "
            WITH latest_messages AS (
                SELECT
                    m.sent_to AS receiver_id,
                    MAX(m.date_added) AS latest_message_date
                FROM
                    messages m
                WHERE
                    m.sent_from = '{$this->Auth->user('id')}'
                GROUP BY
                    m.sent_to
            )
            SELECT
                sender.id AS sender_id,
                sender.name AS sender_name,
                sender.email AS sender_email,
                sender.image AS sender_image,
                receiver.id AS receiver_id,
                receiver.name AS receiver_name,
                receiver.email AS receiver_email,
                receiver.image AS receiver_image,
               (SELECT m.content
                    FROM messages m
                    WHERE ((m.sent_from = sender.id AND m.sent_to = receiver.id) 
                    OR (m.sent_from = receiver.id AND m.sent_to = sender.id))
                    $searchCondition
                    ORDER BY m.date_added DESC
                    LIMIT 1) AS content,
                (SELECT m.date_added
                 FROM messages m
                 WHERE (m.sent_from = sender.id AND m.sent_to = receiver.id) 
                 OR (m.sent_from = receiver.id AND m.sent_to = sender.id)
                 ORDER BY m.date_added DESC
                 LIMIT 1) AS date_added,
                m.id AS message_id
            FROM
                messages m
            INNER JOIN
                latest_messages lm ON m.sent_to = lm.receiver_id AND m.date_added = lm.latest_message_date
            LEFT JOIN
                users sender ON m.sent_from = sender.id
            LEFT JOIN
                users receiver ON m.sent_to = receiver.id
            WHERE
                m.sent_from = '{$this->Auth->user('id')}'
            ORDER BY
                m.date_added DESC
            LIMIT 
                $offset, $limit;
        ";
        // CakeLog::write('debug', $sqlQuery);  // or Log::write('debug', $sqlQuery); if using newer CakePHP versions

        // // Output the query for immediate viewing
        // echo $sqlQuery;
        // die();
        $messages = $this->Message->query($sqlQuery);

        // Prepare the messages array for the view
        $messageOptions = [];
        foreach ($messages as $k => &$message) {
            $message[0]['timestamp'] = $this->timeAgo($message[0]['date_added']);
            $message[0]['date_added'] = date('F d, Y h:i a', strtotime($message[0]['date_added']));
            $messageOptions[$k] = array_merge($message[0], $message['m'], $message['sender'], $message['receiver']);
        }

        die(json_encode(array(
            'status' => 'success',
            'data' => $messageOptions  // pass the prepared messages array to the view
        )));
    }

    public function getUsers()
    {
        // Get the search term from the request
        $searchTerm = $this->request->query('q'); // assuming you are using CakePHP

        // Fetch users from the database based on the search term
        $users = $this->User->query("
            SELECT id, name, image 
            FROM users 
            WHERE id != " . $this->Auth->user('id') . " 
            AND name LIKE '%" . $searchTerm . "%' 
            ORDER BY name ASC
        ");

        // Prepare the users array for the view
        $userOptions = [];
        foreach ($users as $user) {
            $userOptions[] = $user['users'];
        }

        die(json_encode($userOptions));
    }
}
