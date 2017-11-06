<?php
namespace App\Http\Controllers;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use DB;

class WebSocketController extends Controller implements MessageComponentInterface{
    private $connections = [];

/**
     * When a new connection is opened it will be passed to this method
     * @param  ConnectionInterface $conn The socket/connection that just connected to your application
     * @throws \Exception
     */
    function onOpen(ConnectionInterface $conn){
        // echo var_dump($conn);
        $this->connections[$conn->resourceId] = compact('conn') + ['user_id' => null];
    }

/**
     * This is called before or after a socket is closed (depends on how it's closed).  SendMessage to $conn will not result in an error if it has already been closed.
     * @param  ConnectionInterface $conn The socket/connection that is closing/closed
     * @throws \Exception
     */
    function onClose(ConnectionInterface $conn){
        $disconnectedId = $conn->resourceId;
        unset($this->connections[$disconnectedId]);
        foreach($this->connections as &$connection)
            $connection['conn']->send(json_encode([
                'offline_user' => $disconnectedId,
                'from_user_id' => 'server control',
                'from_resource_id' => null,
                'mode' => 2
            ]));
    }

/**
     * If there is an error with one of the sockets, or somewhere in the application where an Exception is thrown,
     * the Exception is sent back down the stack, handled by the Server and bubbled back up the application through this method
     * @param  ConnectionInterface $conn
     * @param  \Exception $e
     * @throws \Exception
     */
    function onError(ConnectionInterface $conn, \Exception $e){
        $userId = $this->connections[$conn->resourceId]['user_id'];
        echo "An error has occurred with user $userId: {$e->getMessage()}\n";
        unset($this->connections[$conn->resourceId]);
        $conn->close();
    }

/**
     * Triggered when a client sends data through the socket
     * @param  \Ratchet\ConnectionInterface $conn The socket/connection that sent the message to your application
     * @param  string $msg The message received
     * @throws \Exception
     */
    function onMessage(ConnectionInterface $conn, $msg){
        if(is_null($this->connections[$conn->resourceId]['user_id'])){
            $this->connections[$conn->resourceId]['user_id'] = $msg;
            $onlineUsers = [];
            foreach($this->connections as $resourceId => &$connection){
//                $msg
                $connection['conn']->send(json_encode([$conn->resourceId => $msg, 'mode' => 3]));
                if($conn->resourceId != $resourceId)
                    $onlineUsers[$resourceId] = $connection['user_id'];
            }
            $conn->send(json_encode(['online_users' => $onlineUsers, 'mode' => 1]));
        } else{
            $fromUserId = $this->connections[$conn->resourceId]['user_id'];
            $msg = json_decode($msg, true);
            $onlineu = 0;
            $resId = '';
            foreach($this->connections as $resourceId => &$connection)
            {
              if($connection['user_id']==$msg['to'])
              {
                $onlineu=1;
                $resId=$resourceId;
              }
            }
            echo $fromUserId;
            echo $msg['to'];
            echo $msg['content'];
            DB::insert('insert into `messages` (`frm`,`to`,`message`) values (?,?,?)',[$fromUserId,$msg['to'],$msg['content']]);


            if ($onlineu){
            $this->connections[$resId]['conn']->send(json_encode([
                'msga' => $msg['content'],
                'from_user_id' => $fromUserId,
                'from_resource_id' => $conn->resourceId,
                'mode' => 0
            ]));}
        }
    }
}
