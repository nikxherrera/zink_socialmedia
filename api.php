<?php 

session_start();


$DATA_RAW = file_get_contents("php://input");
$DATA_OBJ = json_decode($DATA_RAW) ; 


$info = (object)[];


//check if logged in
if(!isset($_SESSION['generate_uid']))
{

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


$Error = "";

//process the data
if(isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "signup")
{
    
   //signup
   include("includes/signup.php");
  
}
else if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "login")
{
   //login
   include("includes/login.php");
}
else if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "logout")
{
    //logout
    include("includes/logout.php");
}
else if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "user_info")
{
    //user info
    include("includes/user_info.php");
}
else if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "contacts")
{
    //contacts
    include("includes/contacts.php");
}

elseif(isset($DATA_OBJ->data_type) && ($DATA_OBJ->data_type == "chats" || $DATA_OBJ->data_type == "chats_refresh"))
{
    //chat_refresh
    include("includes/chats.php");
}
else if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "settings")
{
    //seeting
    include("includes/settings.php");
}
else if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "save_settings")
{
    //save setting
    include("includes/save_settings.php");
}
else if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "send_message")
{
   //send message
    include("includes/send_message.php");

}
else if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "delete_message")
{
    //deletemessage
    include("includes/delete_message.php");

} 
else if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "delete_thread")
{
    //deletethread
    include("includes/delete_thread.php");

}


function message_left($data,$row)
{
    $profile_picture =($row->gender == "male") ?"images/user_male.png" : "images/user_female.png";
    if(file_exists($row->profile_picture)){
    $profile_picture = $row->profile_picture;
    }

    $a= "
    <div id='message_left'>
    <div> </div>
            <img id='prof_img' src='$profile_picture'>
        <b> $row->username </b> <br>
            $data->message <br> <br>";

            if($data->files != "" && file_exists($data->files))
            {
                $a .=" <img src='$data->files' style='width:100%; cursor: pointer;' onclick='image_show(event)'/> <br>";
            }
           
            $a .= "<span style='font-size:11px; color: #999;'>".date("jS M Y H:i:s a",strtotime($data->date))."</span>
            <img id='trash'src='icons/trash.png' onclick='delete_message(event)' msg_id='$data->id' />
    </div>
    ";

    return $a;
}


function message_right($data,$row)
{
    $profile_picture =($row->gender == "male") ?"images/user_male.png" : "images/user_female.png";
    if(file_exists($row->profile_picture)){
    $profile_picture = $row->profile_picture;
    }


    $a = "
	 <div id='message_right'>

	<div>";
	
	if($data->seen){
		$a .="<img src='images/tick.png' style=''/>";
	}else if($data->received){
		$a .="<img src='images/tick_grey.png' style=''/>";
	}

    
    $a .="</div>

            <img id='prof_img' src='$profile_picture' style='float:right'>
             <b> $row->username </b> <br>
            $data->message <br> <br>";

            if($data->files != "" && file_exists($data->files))
            {
                $a .=" <img src='$data->files' style='width:100%; cursor: pointer;' onclick='image_show(event)' /> <br>";
            }
           
            $a .= "<span style='font-size:11px; color: #999;'> ".date("jS M Y H:i:s a",strtotime($data->date))."</span>

            <img id='trash'src='icons/trash.png' onclick='delete_message(event)' msg_id='$data->id' />
         </div>";

    return $a;
}

function message_controls()
{

    return "
    </div>
       <span style='color: grey; cursor: pointer;'  onclick='delete_thread(event)'> Delete this message </span>
        <div for='message_file' style='display: flex; width: 100%;'>
        <label> 
                <img src='icons/clip.png' style='opacity: 0.8; width :30px;  margin: 5px;cursor:pointer; padding: 10px;  '> 
                <input type='file' id='message_file' name='file' style='display: none' onchange='send_image(this.files)'/> 
        </label>
        <input id='message_text' onkeyup='enter_pressed(event)' type='text'  placeHolder='type your message.' style='flex:6; border:solid thin #ccc; border-bottom:none; font-size: 14px; padding:4px;'/>
        <input type='button' id='sendbutton'value='send' onclick='send_message(event)' style=' flex:1; background-color: #eeeeee;   border: 2px solid black;   color:black; '/>

        </div>
    </div>
";
}


