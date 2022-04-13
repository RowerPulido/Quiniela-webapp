<?php
    require_once 'connection.php';

    class User{
        private $id;
        private $name;


        function __construct($id,$name){
            $this->id = $id;
            $this->name = $name;
        }

        function save(){
            $connection = new Connection();
            $result = $connection->executeInsert('Insert into `User` values (?,?);', array_values($this->toArray()));
            return $result;
        }

        function toArray(){
            $array = [];
            $array['id'] = $this->id;
            $array['name'] = $this->name;
            return $array;
        }

        function toJson(){
            return  json_encode($this->toArray());
        }

        public static function getUsers(){
            $users = array();
            $connection = new Connection();
            $result = $connection->executeQuery('select * from `User`;');
            foreach ($result as $user) {
                $users[] = new User($user['id'],$user['name']);
            }
            return $users;
        }
    }
?>