<?php
    require_once '../models/user.php';
    require_once '../models/response.php';

    $response = new Response(5,'Error in user creation');
    $name = $_POST['name'];
    
    if (isset($name)) {
        $user = new User(0,$name);
        $result = $user->save();
        if($result == 1){
            $response = new Response(0,'User created',$user->toArray());
        }
    } else {
        $response = new Response(200,'Missing param: name');
    }

    echo $response->toJson();
?>