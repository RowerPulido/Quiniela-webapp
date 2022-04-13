<?php
    class Response{
        private $status;
        private $data;
        private $message;

        function __construct($status = 0, $message = '', $data = []){
            $this->status = $status;
            $this->message = $message;
            $this->data = $data;
        }

        function toArray(){
            $array = [];
            if(isset($this->status))
            $array['status'] = $this->status;
            if(isset($this->message))
            $array['message'] = $this->message;
            if(isset($this->data))
            $array['data'] = $this->data;
            return $array;
        }

        function toJson(){
            return  json_encode($this->toArray());
    }
}
?>