<?php

Class Database
{
    private $con;
    //construct
    function __construct(){
        $this->con = $this->connect();
    }
    //connect to db
    private function connect(){
        $string = "mysql:host=localhost;dbname=zink_db";
        try{
            $connection = new PDO($string,DBUSER,DBPASS);
            return $connection;

        }catch(PDOException $e){
            echo $e->getMessage();
            die;
        }

        return false;

    }
//write to database; > using pdo and prepared statement<
    public function write($query, $data_array = []){

        $con = $this->connect();
        $statement = $con->prepare($query); 
        $check = $statement->execute($data_array);
  

       if($check)
       {
           return true;
       }

       return false;
    }
//read for database
    public function read($query, $data_array = []){

        $con = $this->connect();
        $statement = $con->prepare($query); 
        $check = $statement->execute($data_array);


    if($check)
    {
        $result = $statement->fetchAll(PDO::FETCH_OBJ);
        if(is_array($result) && count($result) > 0)
        {
            return $result;
        }
        return false;
    }

    return false;
    }

    public function get_user($generate_uid )
    {

        $con = $this->connect();
        $arr['generate_uid'] = $generate_uid ;
        $query = "select * from user where 	generate_uid  = :generate_uid  limit 1";
        $statement = $con->prepare($query); 
        $check = $statement->execute($arr);


    if($check)
    {
        $result = $statement->fetchAll(PDO::FETCH_OBJ);
        if(is_array($result) && count($result) > 0)
        {
            return $result[0];
        }
        return false;
    }

    return false;
    }



    public function generate_id($max)
    {
        $rand ="";
        $rand_count =rand(1,$max);
        for($i=0; $i < $rand_count; $i++)
        {
            #code...
            $r = rand(0,9);
            $rand .= $r;
        }
        return $rand;
    }
}
