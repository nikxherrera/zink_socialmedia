<?php
    
    $arr['generate_uid'] = "null";
     if(isset($DATA_OBJ->find->generate_uid))
     {
       $arr['generate_uid'] = $DATA_OBJ->find->generate_uid;  
       
     }
    
     // remove own  profile sa list ng contacts from databse. --not its functin
     $refresh = false;
     $seen = false;
     if($DATA_OBJ->data_type == "chats_refresh")
     {
             $refresh = true;
             $seen =$DATA_OBJ->find->seen;
     }
     
    $sql = "select * from user where generate_uid = :generate_uid limit 1";   

    $result = $DB->read($sql, $arr);
 
    if(is_array($result))
    {
            //use found
        $row = $result[0];   
                $profile_picture =($row->gender == "male") ?"images/user_male.png" : "images/user_female.png";
                if(file_exists($row->profile_picture)){
                $profile_picture = $row->profile_picture;
                }

                $row->profile_picture = $profile_picture;
                $mydata="";

                if(!$refresh) {
                        $mydata = " Now Chatting with : <br>
                                        <div id='active_contact'>
                                                <img src='$profile_picture'>
                                                $row->username  
                                        </div>";
                }
                $messages = "";
                $new_message = false;
                if(!$refresh) {
                        $messages = "
                        <div id ='messages_holder_parent' onclick='set_seen(event)'  style=' height: 728px; '>
                        <div id ='messages_holder' style=' height: 85%; overflow-y: scroll;'> ";
                }              
                        //read from db
                        $a['sender'] =$_SESSION['generate_uid'];
                        $a['receiver'] = $arr['generate_uid'];
                        
                        $sql = "select * from messages where (sender = :sender  && receiver = :receiver && deleted_sender = 0) || (receiver = :sender && sender = :receiver && deleted_receiver = 0 ) order by id desc limit 10";   
                        $result2 = $DB->read($sql, $a);
                        

                        if(is_array($result2))
                        {

                                $result2 = array_reverse($result2);
                                 foreach ($result2 as $data) {
                                        # code...
                                        $myuser = $DB->get_user($data->sender);


                                        #check for new messages.
                                        if($data->receiver == $_SESSION['generate_uid'] && $data->received == 0)
                                        {
                                                $new_message = true;
                                        }

                                        if($data->receiver == $_SESSION['generate_uid'] && $data->received == 1 && $seen){
                                                
                                                $DB->write("update messages set seen = 1 where id = '$data->id' limit 1");
                                        }
                                        if($data->receiver == $_SESSION['generate_uid']){
                                                
                                                $DB->write("update messages set  received = 1 where id = '$data->id' limit 1");
                                        }
                                        
                                        if($_SESSION['generate_uid'] == $data->sender){
                                                $messages .= message_right($data,$myuser);
                                        }else{
                                                $messages .= message_left($data,$myuser);
                                        }
                                }
                        }
                        
           
                if(!$refresh) {
                        $messages .= message_controls();
                }

                
        $info->user = $mydata ;
        $info->messages = $messages;
        $info->new_message = $new_message;
        $info->data_type = "chats";
        if($refresh) {
                $info->data_type = "chats_refresh";
                
        }
        echo json_encode($info);


    }else{

        //read from db
        $a['generate_uid'] = $_SESSION['generate_uid'];
//show last message newest
       $sql = "select t1.* from messages t1 join (select id,msg_id,max(date) mydate from messages where ((sender = :generate_uid && deleted_sender = 0) || (receiver = :generate_uid && deleted_receiver = 0)) group by msg_id) t2 on t1.msg_id = t2.msg_id and t2.mydate = t1.date
       group by msg_id";
      // $sql = "select * from messages where (sender = :generate_uid  || receiver = :generate_uid) group by msg_id order by id desc limit 10";   
        $result2 = $DB->read($sql, $a);
        
        $mydata = " previous chat: <br>";
        if(is_array($result2))
        {

                $result2 = array_reverse($result2);
                 foreach ($result2 as $data) {
                        # code...
                        $other_user = $data->sender;
                        if($data->sender == $_SESSION['generate_uid'])
                        {
                                $other_user = $data->receiver;
                        }
                        $myuser = $DB->get_user( $other_user);

                        $profile_picture =( $myuser ->gender == "male") ?"images/user_male.png" : "images/user_female.png";
                        if(file_exists( $myuser ->profile_picture)){
                        $profile_picture =  $myuser ->profile_picture;
                        }

                        
                        $mydata .= "
                   
                        <div id='active_contact'  generate_uid='$myuser->generate_uid' onClick='start_chat(event)' style='cursor: pointer;' >
                                <img src=' $profile_picture'>
                                $myuser->username <br>
                                <span>$data->message</span>
                        </div>";
                }
        }

       $info->user = $mydata;
       $info->messages = "";
       $info->data_type = "chats";

       echo json_encode($info);

    }
    

 ?>

