<?php
//login
    $info = (Object)[];
    $data=false;


    //validate info

    $data['generate_uid'] = $_SESSION['generate_uid'];

    // if (empty($data['generate_uid'] = $_SESSION['generate_uid'])) {  
    //     $data['generate_uid'] = $DB->generate_id(20);

    //     $query ="update user set generate_uid = :generate_uid where user_id limit 1";
    //     $result = $DB->write($query, $data);
    // }


    if($Error == "")
    {
        $query = "select * from user where generate_uid = :generate_uid limit 1";
        $result = $DB->read($query,$data);
    
        
        if(is_array($result))
        {
            $result = $result[0];
            $result->data_type = "user_info";
         //check if image is exist
            $profile_picture =($result->gender == "male") ?"images/user_male.png" : "images/user_female.png";
                    if(file_exists($result->profile_picture)){
                        $profile_picture = $result->profile_picture;
                    }
                    $result->profile_picture=$profile_picture;
            echo json_encode($result);


            
      
        }else{
            $info->message = "Wrong email ";
            $info->data_type = "error";
            echo json_encode($info);
        }
    } else{
        
        $info->message = $Error;
        $info->data_type = "An error occur";
        echo json_encode($info);
    }
