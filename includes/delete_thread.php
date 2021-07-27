<?php
    
    $arr['generate_uid'] = "null";
     if(isset($DATA_OBJ->find->generate_uid))
     {
       $arr['generate_uid'] = $DATA_OBJ->find->generate_uid;  
     }
    
     $arr['sender'] =$_SESSION['generate_uid'];
     $arr['receiver'] = $arr['generate_uid'];

     $sql = "select * from messages where (sender = :sender  && receiver = :receiver ) || (receiver = :sender && sender = :receiver)";   
     $result = $DB->read($sql, $arr);

    if(is_array($result))
    {
        foreach ($result as $row) {
            # code...
            if($_SESSION['generate_uid'] == $row->sender)
            {
                $sql = "update messages set deleted_sender = 1 where id = '$row->id' limit 1";   
                $DB->write($sql);
            }
            if($_SESSION['generate_uid'] == $row->receiver)
            {
                $sql = "update messages set deleted_receiver = 1 where id = '$row->id' limit 1";   
                $DB->write($sql);
            }
        }
       
    }
 

 ?>

