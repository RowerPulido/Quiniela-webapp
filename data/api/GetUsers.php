<?php
    require_once '../models/user.php';
    require_once '../models/response.php';

    $response = new Response(100,'Empty list');
    $users = User::getUsers();
    
    if(count($users) > 0){
        $data = [];
        $data['users'] = array();
        foreach ($users as $index => $user) {
            $data['users'][] = $user->toJson();
        }
        $response = new Response(0,'Users found',$data);
    }
    echo $response->toJson();
?>