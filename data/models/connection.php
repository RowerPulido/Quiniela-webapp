<?php
    // mysqli_report(MYSQLI_REPORT_ALL);
    ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    class Connection{
        private $link;

        function __construct()
        {
            $this->getConnection();
        }

        function getConnection(){
            $this->link = mysqli_connect("127.0.0.1","root","admin","soccer");
            if (!$this->link) {
                throw new Exception("Connection Failed", 1);
            }
            return $this->link;    
        }

        function executeStmt($query){
            return mysqli_query($this->link,$query);
        }

        function executeInsert($query, $params= []){
            $stmt = mysqli_prepare($this->link, $query);
            if (array_count_values($params)) {
                $param_types = "";
                foreach ($params as $param ) {
                    if (is_int($param)) {
                        $param_types.='i';
                    } elseif (is_double($param)){
                        $param_types.='d';
                    } elseif (is_bool($param)){
                        $param_types.='b';
                    } elseif (is_string($param)){
                        $param_types.='s';
                    }
                }
                
              mysqli_stmt_bind_param($stmt,$param_types,...$params);
            }
            $stmt->execute();
            $affectedRows = $stmt->affected_rows;
            $stmt->close();
            $this->close();
            return $affectedRows;
        }

        function executeQuery($query, $params= []){
            $stmt = mysqli_query($this->link, $query);
            $results = array();

            while ($row = mysqli_fetch_array($stmt,MYSQLI_ASSOC)) {
                $results[]= $row;
            }
            mysqli_free_result($stmt);
            $this->close();
            return $results;
        }

        function fetch($result){   
            $array = array();
        
            if($result instanceof mysqli_stmt)
            {
                $result->store_result();
            
                $variables = array();
                $data = array();
                $meta = $result->result_metadata();
            
                while($field = $meta->fetch_field())
                    $variables[] = &$data[$field->name]; // pass by reference
            
                call_user_func_array(array($result, 'bind_result'), $variables);
            
                $i=0;
                while($result->fetch())
                {
                    $array[$i] = array();
                    foreach($data as $k=>$v)
                        $array[$i][$k] = $v;
                    $i++;
                
                    // don't know why, but when I tried $array[] = $data, I got the same one result in all rows
                }
            }
            elseif($result instanceof mysqli_result)
            {
                while($row = $result->fetch_assoc())
                    $array[] = $row;
            }
        
            return $array;
        }

        function close(){
            mysqli_close($this->link);
        }
    }
    $connection = new Connection();

?>