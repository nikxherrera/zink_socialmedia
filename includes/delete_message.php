<?php
    
    $arr['rowid'] = "null";
     if(isset($DATA_OBJ->find->rowid))
     {
       $arr['rowid'] = $DATA_OBJ->find->rowid;  
     }
    
    $sql = "select * from messages where id = :rowid limit 1";   
    $result = $DB->read($sql, $arr);

    if(is_array($result))
    {
        $row = $result[0];
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
 

 ?>

