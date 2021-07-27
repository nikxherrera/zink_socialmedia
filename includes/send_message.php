<?php
    //check if nag eexiat ung user
    $arr['generate_uid'] = "null";
     if(isset($DATA_OBJ->find->generate_uid))
     {
       $arr['generate_uid'] = $DATA_OBJ->find->generate_uid;  
       
     }
    
     // remove own  profile sa list ng contacts from databse. 
     
    $sql = "select * from user where generate_uid = :generate_uid limit 1";   

    $result = $DB->read($sql, $arr);
 
    if(is_array($result))
    {
            $arr['message'] = $DATA_OBJ->find->message;
            $arr['date'] = date("Y-m-d H:i:s");
            $arr['sender'] = $_SESSION['generate_uid'];
            $arr['msg_id'] = get_random_string_max(60);

               $arr2['sender'] = $_SESSION['generate_uid'];
               $arr2['receiver'] = $arr['generate_uid'];
            
                 $sql = "select * from messages where (sender = :sender  && receiver = :receiver) || (receiver = :sender && sender = :receiver  )limit 1";   
                $result2 = $DB->read($sql, $arr2);
                
                if(is_array($result2))
                {
                       $arr['msg_id'] = $result2[0]->msg_id;
                }

            $query = "insert into messages (sender, receiver,message, date, msg_id) values (:sender, :generate_uid,:message,:date, :msg_id)";
            $DB->write($query, $arr);


            //use found
        $row = $result[0];   
                $profile_picture =($row->gender == "male") ?"images/user_male.png" : "images/user_female.png";
                if(file_exists($row->profile_picture)){
                $profile_picture = $row->profile_picture;
                }

                $row->profile_picture = $profile_picture;


                $mydata = " Now Chatting with : <br>
                                <div id='active_contact'>
                                        <img src='$profile_picture'>
                                        $row->username  
                                </div>";
                 $messages = " 
                         <div id ='messages_holder_parent' style=' height: 728px; '>
                        <div id ='messages_holder' style=' height: 85%; overflow-y: scroll;'> ";
                        
                        //read from database
                       
                                $a['msg_id'] = $arr['msg_id'];
                        
                                $sql = "select * from messages where msg_id = :msg_id order by id desc limit 10";   
                                $result2 = $DB->read($sql, $a);
                                

                                if(is_array($result2))
                                {

                                        $result2 = array_reverse($result2);
                                         foreach ($result2 as $data) {
                                                # code...
                                                $myuser = $DB->get_user($data->sender);
                                                
                                                if($_SESSION['generate_uid'] == $data->sender){
                                                        $messages .= message_right($data,$myuser);
                                                }else{
                                                        $messages .= message_left($data,$myuser);
                                                }
                                        }
                                }
                     

                        $messages .= message_controls();

        $info->user = $mydata;
        $info->messages = $messages;
        $info->data_type = "send_message";
        echo json_encode($info);


    }else{
            //user not found
        $info->message = "that contact was not found ";
        $info->data_type = "send_message";
        echo json_encode($info);
    }

        function get_random_string_max($length) { // generate random character.

                $array = array(0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
                $text = "";

                $length = rand(4,$length);

                for($i=0;$i<$length;$i++) {

                        $random = rand(0,61);
                        
                        $text .= $array[$random];

                }

                return $text;
        }
       
    


 ?>

