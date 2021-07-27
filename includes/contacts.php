<?php
$myid = $_SESSION['generate_uid'];
   $sql = "select * from user where generate_uid != '$myid' limit 10"; // remove own  profile sa list ng contacts from databse.
   $myusers = $DB->read($sql, []);

    $mydata = 
            '
            <style>
                @keyframes appear{

                    0%{opacity:0; transform: translateY(50px)}
                    100%{opacity:1; transform: translateY(0px)}

                }

                #contact{
                    cursor:pointer;
                    transition: all .5s cubic-bezier(0.68, -2, 0.265, .1.55);

                }
                #contact:hover{
                    transform: scale(1.1);
                }
            </style>
            <div style="text-align: center; center; anidmation: appear 1s ease;">';
            if(is_array($myusers))
            {  //check for new messages.
                $msgs =  array();
                $me = $_SESSION['generate_uid'];
                $query = "select * from messages where receiver = '$me' && received = 0";
                $mymsg = $DB->read($query,[]);

                if(is_array($mymsg)){
                    foreach ($mymsg as $row2) {
                        $sender = $row2->sender;

                        if(isset($msgs[$sender]))
                        {
                            $msgs[$sender]++;
                        }else{
                            $msgs[$sender] = 1;
                        }
                        
                    }

                }

                foreach ($myusers as $row) 
                { // determind picture by gender then use default gnder pic per gender.
                    $profile_picture =($row->gender == "male") ?"images/user_male.png" : "images/user_female.png";
                    if(file_exists($row->profile_picture)){
                        $profile_picture = $row->profile_picture;
                    }
                    //get actual name

                    $mydata .= "
                    <div generate_uid='$row->generate_uid' onClick='start_chat(event)' id='contact' style='position:relative;'>
                        <img src='$profile_picture'>
                        <br> $row->username ";

                        if(count($msgs) > 0 && isset($msgs[$row->generate_uid])){
                            $mydata .= "<div style='width:20px;height:20px;border-radius:50%;background-color:orange;color:white;position:absolute;left:0px;top:0px;'>".$msgs[$row->generate_uid]."</div>";
                        }

                    $mydata .="
                    </div>";
                }
               
            }
            
    $mydata .= '
     </div>';
    
    $info->message = $mydata;
    $info->data_type = "contacts";
    echo json_encode($info);

    die;

    $info->message = "No contacts were found ";
    $info->data_type = "error";
    echo json_encode($info);
 ?>

