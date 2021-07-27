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
   <div id="wrapper1">
       <div id="header1">
           Zink ChitChat
           <div id="divSignup"> Login </div> 
       </div>
       <div id="error"> 
           

       </div>
       <form id="myform">
           <input type="text" name="email" id=""  placeholder="email"> <br>
           <input type="password" name="password" id="" placeholder="Password"> <br>
           <input type="submit" value="Login"  id="login_button"> <br>

           <br>
            <a href="signup.php" style="display: block; text-align: center; text-decoration:none;">
                Don't have an Account? Signup here.
            </a>
       </form>
   </div>
</body>

</html>
<script>
    function _(element){
         return document.getElementById(element);
    }
    var login_button = _("login_button");
    login_button.addEventListener("click", collect_data);

    function collect_data(e){

        e.preventDefault();
        login_button.disabled=true;
        login_button.value="loading...please wait...";

        var myform = _("myform");
        var inputs = myform.getElementsByTagName("INPUT");
        var data = {};
        for(var i= inputs.length -1; i>=0; i--){
            var key = inputs[i].name;

            switch(key){
                case "email":   
                    data.email = inputs[i].value;
                    break;
                case "password":
                    data.password = inputs[i].value;
                    break;
            }
        }

        send_data(data,"login");
        
    }

    function send_data(data,type){
        var xml = new XMLHttpRequest();
        xml.onload = function(){
            if(xml.readyState == 4 || xml.status == 200){
               
                handle_result(xml.responseText);
                login_button.disabled=false;
                login_button.value="Login";
            }
        }
        data.data_type = type;
        var data_string = JSON.stringify(data) //only string accept the internet so need to parse to string.

        xml.open("POST", "api.php", true);
        xml.send(data_string);
        
    }
    function handle_result(result){
// alert(result);
        var data = JSON.parse(result);
        if(data.data_type == "info"){

            window.location = "index1.php";
        }else{

            var error = _("error");
            error.innerHTML = data.message;
            error.style.display = "block";

        }
      
}
    
</script>