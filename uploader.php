<?php

session_start();

$info = (object)[];


//check if logged in
if(!isset($_SESSION['generate_uid']))
{
   // if (isset($DATA_OBJ->data_type)!= "login")
   //IF SAME NG EMAIL DAPAT MAG EERROR
    if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type != "login" && $DATA_OBJ->data_type != "signup")      // if nag logout tapos bumalik walang acc deretso log in.
    {
        $info->logged_in = false;
        echo json_encode($info);
        die;
    }
    
   
}

require_once("includes/autoload.php");
$DB = new Database();

$data_type = "";
if(isset($_POST['data_type']))
{
    $data_type = $_POST['data_type'];
}


$destination = "";
if(isset($_FILES['file']) && $_FILES['file']['name'] != ""){


    $allowed[] = "image/jpeg";
    $allowed[] = "image/jpg";
    $allowed[] = "image/png"; 
    $allowed[] = "image/jfif"; 
    $allowed[] = "image/gif";

    // you can add more type of image.

    $_FILES['file']['type'];
    
    if($_FILES['file']['error'] == 0 && in_array(  $_FILES['file']['type'], $allowed)){
        //good to go
        $folder = "upload/";
        if(!file_exists($folder)){
            mkdir($folder, 0777, true);
        }
        $destination = $folder . $_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $destination);

        $info->message ="Your image was uploaded.";
        $info->data_type = $data_type;
        echo json_encode($info);

    }
}

if($data_type == "change_profile_image")
{
    if($destination != ""){
        //save to database
        $id = $_SESSION['generate_uid'];
        $query = "update user set profile_picture = '$destination' where generate_uid = '$id' limit 1";
        $DB->write($query,[]);
    }
} else if($data_type == "send_image")
{
    $arr['generate_uid'] = "null";
    if(isset($_POST['generate_uid']))
    {
    $arr['generate_uid'] = addslashes($_POST['generate_uid']);  
    
    }

    $arr['message'] = "";
    $arr['date'] = date("Y-m-d H:i:s");
    $arr['sender'] = $_SESSION['generate_uid'];
    $arr['msg_id'] = get_random_string_max(60);
    $arr['file'] = $destination;

        $arr2['sender'] = $_SESSION['generate_uid'];
        $arr2['receiver'] = $arr['generate_uid'];
    
            $sql = "select * from messages where (sender = :sender  && receiver = :receiver) || (receiver = :sender && sender = :receiver  )limit 1";   
        $result2 = $DB->read($sql, $arr2);
        
        if(is_array($result2))
        {
                $arr['msg_id'] = $result2[0]->msg_id;
        }

    $query = "insert into messages (sender, receiver,message, date, msg_id,files) values (:sender, :generate_uid,:message,:date, :msg_id, :file)";
    $DB->write($query, $arr);
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
