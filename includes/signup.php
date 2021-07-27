<?php
//signup
    $info = (Object)[];
    $data=false;
    $data['generate_uid'] = $DB->generate_id(20);
    //$data['date'] = date("Y-m-d H:i:s");

    //validate username
    //IF USER EXIST PLEASE ALERT!!!!!!
    $data['birthday'] = $DATA_OBJ->birthday;
    if(empty($DATA_OBJ->birthday))
    {
        $Error .=  "Please enter birthday . <br>";
    }
    $data['firstname'] = $DATA_OBJ->firstname;
    if(empty($DATA_OBJ->firstname))
    {
        $Error .=  "Please enter firstname . <br>";
    }
    $data['lastname'] = $DATA_OBJ->lastname;
    if(empty($DATA_OBJ->lastname))
    {
        $Error .=  "Please enter lastname . <br>";
    }

    $data['number'] = $DATA_OBJ->number;
    if(empty($DATA_OBJ->number))
    {
        $Error .=  "Please enter a your mobile no . <br>";
    }

    $data['username'] = $DATA_OBJ->username;
    if(empty($DATA_OBJ->username))
    {
        $Error .=  "Please enter a valid username . <br>";
    } else{
        if(strlen($DATA_OBJ->username) < 3)
        {
            $Error .= "user must be atleast 3 characters long. <br>";
        }
        if(!preg_match( "/^[a-z A-Z 0-9]*$/", $DATA_OBJ->username))
        {
            $Error .=  "Please enter a valid username . <br>";
        }
    }
    $data['gender'] = isset($DATA_OBJ->gender) ? $DATA_OBJ->gender : null;
    if(empty($DATA_OBJ->gender))
    {
        $Error .=  "Please select a gender . <br>";
    } else
    {
        if($DATA_OBJ->gender != "male" && $DATA_OBJ->gender != "female")
        {
            $Error .=  "Please select a valid gender . <br>";
        }
    }
    
    $data['email'] = $DATA_OBJ->email;
    if(empty($DATA_OBJ->email))
    {
        $Error .=  "Please enter a valid email . <br>";
    } else{
        //IF KAYA ADD NG AUTHENTICATION FOR EMAIL USING PHP HEHEHE -3 AM-
        if(!preg_match( "/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $DATA_OBJ->email))
        {
            $Error .=  "Please enter a valid email . <br>";
        }
    }


    $data['password'] = $DATA_OBJ->password;
    $password= $DATA_OBJ->password2;
    if(empty($DATA_OBJ->password))
    {
        $Error .=  "Please enter a valid password . <br>";
    } else{
        if($DATA_OBJ->password != $DATA_OBJ->password2)
        {
            $Error .= "passwords must match. <br>";
        }
        if(strlen($DATA_OBJ->password) < 3)
        {
            $Error .= "Password must atleast 3 characters long. <br>";
        }
      
    }
    $data['password2'] = $DATA_OBJ->password2;
    $password= $DATA_OBJ->password;
    if(empty($DATA_OBJ->password2))
    {
        $Error .=  "Please enter a valid password . <br>";
    } else{
        if($DATA_OBJ->password2 != $DATA_OBJ->password)
        {
            $Error .= "passwords must match. <br>";
        }
        if(strlen($DATA_OBJ->password2) < 3)
        {
            $Error .= "Password must atleast 3 characters long. <br>";
        }
      
    }


    if($Error == "")
    {
        // $data['password'] = hash("sha1", $DATA_OBJ->password);
        // $data['password2'] = hash("sha1", $DATA_OBJ->password2); //itried to hash

        $query = "insert into user (generate_uid, firstname, lastname, username, birthday, gender, number, email,  password, password2) values (:generate_uid, :firstname, :lastname,  :username, :birthday,  :gender, :number, :email, :password, :password2)";
        $result = $DB->write($query, $data);
    
        
        if($result)
        {
            $info->message = "Your profile was created, congratulations.";
            $info->data_type = "info";
            echo json_encode($info);
      
        }else{
            $info->message = "Your profile is not created due to an error";
            $info->data_type = "error";
            echo json_encode($info);
        }
    } else{
        
        $info->message = $Error;
        $info->data_type = "error";
        echo json_encode($info);
    }