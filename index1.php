<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/global_style.css">
    <title>Zink ChitChat</title>
    <!-- <link rel="icon" type="image/svg+xml" href="ICONS/shot.svg"> -->
    <link rel="icon" type="image/svg+xml" href="ICONS/logo.png">

</head>

<body>
   <div id="wrapper">
    <div id="left_panel">
        <div id="user_info" style="padding: 10px;">
            <img id="profile_image" src="images/user_male.png" alt="images" style="height: 100px; width: 100px;">
            <br>
            <span id="username"> Username </span>
            <br>
            <span id="email" style="font-size: 12px; opacity: 0.5;"> user_email@gmail.com </span>
            <br><br><br>
            <div>
                <label id="label_chat" for="radio_chat">Chat <img src="icons/chat.png" alt=""></label>
                <label id="label_contacts" for="radio_contacts" >Contacts <img src="icons/contacts.png" alt=""></label>
                <label id="label_settings"for="radio_settings">Settings <img src="icons/setting.png" alt=""></label>
                <label id="label_home" for="radio_home" >  Home <img src="icons/home.png" alt=""></label>
               
                 <label id="logout"for="radio_logout">Zink out <img src="icons/logout.png" alt=""></label>
              
            </div>

        </div>
      
    </div>

    <div id="right_panel">
        <div id="header">
        <div class="loader_on">
                 <img id="loader_holder" style="width:70px;" src="icons/giphy.gif" alt=""></div>
              <div id="image_viewer" class="image_off" onclick="close_image(event)"></div>
              <div> 
              Zink ChitChat
              </div>
              
                
        </div>
        <div id="container" style="display: flex;">
            
            <div id="inner_left_panel">
              
                
            </div>
        
            <input type="radio" name="rad"  id="radio_chat" style="display:none;">  
            <input type="radio" name="rad" id="radio_contacts" style="display:none;">
            <input type="radio" name="rad" id="radio_settings" style="display:none;">
            <input type="radio" name="rad" id="radio_home" style="display:none;">
        
            <div id="inner_right_panel">

            </div>
        </div>
        
    </div>
   </div>
</body>

</html>
<script>
    var sent_audio = new Audio("message_sent.mp3");
    var received_audio = new Audio("message_received.mp3");

    var CURRENT_CHAT_USER = "";
    var SEEN_STATUS  = false;

    function _(element){
         return document.getElementById(element);
    }
    
    var label_contacts = _("label_contacts");
    label_contacts.addEventListener("click",get_contacts);

    var label_chat = _("label_chat");
    label_chat.addEventListener("click",get_chats);

    var label_settings = _("label_settings");
    label_settings.addEventListener("click",get_settings);

    var logout = _("logout");
    logout.addEventListener("click",logout_user);

    var label_home = _("label_home");
    label_home.addEventListener("click",home);


    
    function get_data(find, type){

        var xml = new XMLHttpRequest();
        var loader_holder = _("loader_holder");
        loader_holder.className = "loader_on";
        xml.onload = function(){
            if(xml.readyState == 4 || xml.status == 200) {
                loader_holder.className = "loader_off";
                handle_result(xml.responseText, type);
            }


        }
        var data ={};
        data.find = find;
        data.data_type = type;

        data = JSON.stringify(data);
        xml.open("POST", "api.php", true);
        xml.send(data);

    }

    function handle_result(result, type)
    {

    //alert(result); // show lng ito kung ano problem ng site 
    //console.log(result);
        if(result.trim() != "")
        {

            var inner_right_panel = _("inner_right_panel");
            inner_right_panel.style.overflow = "visible"; 
                        
            var obj = JSON.parse(result);
            if(typeof(obj.logged_in)!= "undefined" && !obj.logged_in)
            {
                window.location = "login.php";
            } else 
            { 
                switch(obj.data_type)
                {
                    case "user_info":
                        var username = _("username");
                        var email = _("email");
                        var profile_image = _("profile_image");

                        username.innerHTML = obj.username;
                        email.innerHTML = obj.email;
                        profile_image.src = obj.profile_picture;
                        break;
                    case "contacts":
                    
                        var inner_left_panel = _("inner_left_panel");
                        
                        inner_right_panel.style.overflow = "hidden"; // mag hide yung left panel 
                        inner_left_panel.innerHTML = obj.message;

                        break;
                    case "chats_refresh":
                        SEEN_STATUS = false;
                        var messages_holder = _("messages_holder");
                        messages_holder.innerHTML = obj.messages;
                        if(typeof obj.new_message != 'undefined') {
                            if(obj.new_message){
                                received_audio.play();

                                setTimeout(function(){ 
                                    messages_holder.scrollTo(0,messages_holder.scrollHeight);
                                    var message_text = _("message_text");
                                    message_text.focus();
                            
                                },100);
                            }
                        }
                        

                        break; 
                    case "send_message":
                        sent_audio.play();
                    case "chats":
                        SEEN_STATUS = false;
                        var inner_left_panel = _("inner_left_panel");
                        
                        inner_left_panel.innerHTML = obj.user;
                        inner_right_panel.innerHTML = obj.messages;

                        var messages_holder = _("messages_holder");
                        
                        setTimeout(function(){ 
                            messages_holder.scrollTo(0,messages_holder.scrollHeight);
                            var message_text = _("message_text");
                            message_text.focus();
                        
                        },100);

                        if(typeof obj.new_message != 'undefined') {
                            if(obj.new_message){
                                received_audio.play();
                            }
                        }

                        break;
                    

                    case "settings":
                        var inner_left_panel = _("inner_left_panel");
                        inner_left_panel.innerHTML = obj.message;
                        break;
                    case "send_image":
                        alert(obj.message);
                        break;
                    case "save_settings":
                        
                        alert(obj.message);
                        get_data({}, "user_info");
                        get_settings(true);
                        break;
                    
                        
                    
                }
            }
        }
    }
        
    function logout_user(e)
    {
 
        var answer = confirm("Are you sure want to Zink Out " + username.innerHTML +" ?");
        if(answer){
            get_data({}, "logout");
        }
        
    }

    get_data({}, "user_info");
    get_data({}, "contacts");

    var radio_contacts =_("radio_contacts");
    radio_contacts.checked = true;

    
    function get_contacts(e)
    {
        get_data({}, "contacts");
    }


    function get_chats(e)
    {
        get_data({}, "chats"); 
    }

    function home(e)
    {
        window.location.href = "home.php";
    }



    function get_settings(e)
    {
        get_data({}, "settings");
    }

    function send_message(e)
    {
        var message_text = _("message_text");
        if(message_text.value.trim()==""){
            alert("please type something to send");
            return;
        }
        //alert(message_text.value);
        get_data({

            message:message_text.value.trim(),
                generate_uid:CURRENT_CHAT_USER

        }, "send_message");
        
    }

    function enter_pressed(e) // key enter to chat
    {
        if(e.keyCode == 13)
        {
            send_message(e);
        }

        SEEN_STATUS = true;
    }

    setInterval(function(){
        // alert("alert hey");
            var radio_chat = _("radio_chat");
            var radio_contacts = _("radio_contacts");


            if(CURRENT_CHAT_USER != "" && radio_chat.checked) {

                console.log(SEEN_STATUS);
                get_data({
                    
                        generate_uid:CURRENT_CHAT_USER,
                    seen:SEEN_STATUS
                
            
            }, "chats_refresh");
            } 

            if(radio_contacts.checked) {

            get_data({}, "contacts");
        } 
            
    },5000);

    function set_seen(e){
        SEEN_STATUS = true;
    }

    function delete_message(e)
    {
        if(confirm("Are you sure you want to delete this message??")){
            var msg_id = e.target.getAttribute("msg_id");
            get_data({     
                    rowid:msg_id
            }, "delete_message");

            get_data({
                    
                        generate_uid:CURRENT_CHAT_USER,
                    seen:SEEN_STATUS
            }, "chats_refresh");
        }

    }

    function delete_thread(e)
    {
        if(confirm("Are you sure you want to delete this whole message??")){
        
            get_data({     
                    generate_uid:CURRENT_CHAT_USER
            }, "delete_thread");

            get_data({
                    
                        generate_uid:CURRENT_CHAT_USER,
                    seen:SEEN_STATUS
            }, "chats_refresh");
        }

    }


</script>
<script>
function collect_data(){
    var save_settings_button = _("save_settings_button");

    save_settings_button.disabled = true;
    save_settings_button.value = "loading...please wait...";

    var myform = _("myform");
    var inputs = myform.getElementsByTagName("INPUT");
    var data = {};
    for(var i= inputs.length -1; i>=0; i--){
    var key = inputs[i].name;

    switch(key){
            case "firstname":
                data.firstname = inputs[i].value;
                break;
            case "lastname":
                data.lastname = inputs[i].value;
                break;
            case "username":
                data.username = inputs[i].value;
                break;

            case "email":   
                data.email = inputs[i].value;
                break;
            case "birthday":
                data.birthday = inputs[i].value;
                break;
            case "number":
                data.number = inputs[i].value;
                break;
            

            case "gender":
                if(inputs[i].checked){
                data.gender = inputs[i].value;
                }
                break;

            case "password":
                data.password = inputs[i].value;
                break;

            case "password2":
                data.password2 = inputs[i].value;
                break;
    }
    }

    send_data(data,"save_settings");
    
}

function send_data(data,type){
    var xml = new XMLHttpRequest();
    xml.onload = function(){
    if(xml.readyState == 4 || xml.status == 200){
            handle_result(xml.responseText);
            var save_settings_button = _("save_settings_button");
            save_settings_button.disabled=false;
            save_settings_button.value="Signup";
    }
    }
    data.data_type = type;
    var data_string = JSON.stringify(data) //only string accept the internet so need to parse to string.

    xml.open("POST", "api.php", true);
    xml.send(data_string);
    
}

function upload_profile_image(files){
    //  alert(files[0].name); //only one item kukunin

    var filename = files[0].name;
    var ext_start = filename.lastIndexOf(".");
    var ext = filename.substr(ext_start + 1 ,4);
    
    if(!(ext == "jpg" || ext =="JPG" || ext == "png" || ext == "PNG" || ext == "jfif" || ext == "JFIF" || ext == "gif" || ext == "GIF")){
        
        alert("This file type is not allowed");
        return;
    }
    
    var change_image_button = _("change_image_button");

    change_image_button.disabled=true;
    change_image_button.innerHTML="Uploading Image ....";

    var myform = new FormData();

    var xml = new XMLHttpRequest();

    xml.onload = function(){

    if(xml.readyState == 4 || xml.status == 200){
            alert(xml.responseText);
            
            get_data({}, "user_info");
            get_settings(true);
            change_image_button.disabled=false;
            change_image_button.innerHTML="Change Image";
    }
    }
    myform.append('file', files[0]);
    myform.append('data_type', "change_profile_image");
    
    xml.open("POST", "uploader.php", true);
    xml.send(myform);
    

}

function handle_drag_and_drop(e){

    if(e.type == "dragover"){
        e.preventDefault();
        e.target.className = "dragging";
    }else if (e.type == "dragleave"){
    e.target.className = "";

    }
    else if(e.type == "drop"){
        e.preventDefault();
        e.target.className = "";
    
        upload_profile_image(e.dataTransfer.files);
    
    }else {
    e.target.className = "";
    }

}

function start_chat(e) {

    var generate_uid = e.target.getAttribute("generate_uid");
    if(e.target.id == "")
    {
            generate_uid = e.target.parentNode.getAttribute("generate_uid");
    }
    
    CURRENT_CHAT_USER = generate_uid; //global variable

    var radio_chat = _("radio_chat");
    radio_chat.checked = true;
    get_data({generate_uid:CURRENT_CHAT_USER }, "chats");
    
}

function send_image(files)
{
var filename = files[0].name;
var ext_start = filename.lastIndexOf(".");
var ext = filename.substr(ext_start + 1 ,4);

if(!(ext == "jpg" || ext =="JPG" || ext == "png" || ext == "PNG" || ext == "jfif" || ext == "JFIF" || ext == "gif" || ext == "GIF")){
    
    alert("This file type is not allowed");
    return;
}

var myform = new FormData();
var xml = new XMLHttpRequest();

xml.onload = function(){

    if(xml.readyState == 4 || xml.status == 200)
    {
            handle_result(xml.responseText,"send_image");
            get_data({
                    generate_uid:CURRENT_CHAT_USER,
                seen:SEEN_STATUS
            }, "chats_refresh");
        
    }
}
myform.append('file', files[0]);
myform.append('data_type', "send_image");
myform.append('generate_uid', CURRENT_CHAT_USER);

xml.open("POST", "uploader.php", true);
xml.send(myform);



}

function close_image (e) {

    e.target.className = "image_off";
}
        
function image_show (e) {

    var image = e.target.src;
    var image_viewer = _("image_viewer");

    image_viewer.innerHTML = "<img src='"+image+"' style='width:150%' />";
    image_viewer.className = "image_on";
}
        
</script>