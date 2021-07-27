<?php
    
    $sql = "select * from user where generate_uid = :generate_uid limit 1";
    $id = $_SESSION['generate_uid'];
    $data = $DB->read($sql,['generate_uid'=>$id]);
    

    $mydata = "";

      if(is_array($data))
      {
            $data = $data[0];
            //check if the image is exists.

            $profile_picture =($data->gender == "male") ?"images/user_male.png" : "images/user_female.png";
                    if(file_exists($data->profile_picture)){
                        $profile_picture = $data->profile_picture;
            }

              
            $gender_male="";
            $gender_female="";

            if($data->gender == "male")
            {
                  $gender_male="checked";
            }else{
                  $gender_female="checked";
            }

            $mydata = ' 
                  <style>
                              #user_name, #user_mail, #user_password, #user_password2, #firstname, #lastname, #birthday , #number
                              {
                              padding: 10px;
                              margin: 2px;
                              width: 200px;
                              border-radius: 5px;
                              border: solid 1px grey;
                              }

                              #save_settings_button{
                                    width: 220px;
                                    cursor: pointer;
                                    background-color: #2b5488;
                                    color: white;
                              }

                              @keyframes appear{

                                    0%{opacity:0; transform: translateY(50px)}
                                    100%{opacity:1; transform: translateY(0px)}
                
                                }
                              
                              .dragging{
                                    border: dashed  2px #aaa;

                              }

                          

                  </style>
                  <div id="error">  error </div>
                  <div style="display:flex; animation: appear 1s ease">
                  <div style="padding: 100px;"> <Br>
                  <table>
                        <tr>
                              <td>
                                   <div>
                                       <span style="font-size: 11px"> drag and drop an image to change </span> <br>
                                       <img ondragover="handle_drag_and_drop(event)" ondrop="handle_drag_and_drop(event)" ondragleave="handle_drag_and_drop(event)" src="'.$profile_picture.'" style="width:250px; height:250px; margin: 10px"/>
                                    </div>
                                    <div>
                                          <label for="change_image_input" id="change_image_button" style="background-color: #44a9cc;  border: 2px solid black; width: 150px; display:inline-block; padding: 1em; border-radius:5px;cursor: pointer; border-radius: 25px;"> 
                                          Change Image
                                    
                                          </label>
                                          <input  type="file" onchange="upload_profile_image(this.files)" id="change_image_input" style="display:none;">
                                    </div>
                        
                        
                              <td>
                        </tr>
                  </table>
                  </div>
                              <form id="myform">
                                    <input type="text" name="firstname" id="firstname" placeholder="Firstname" value="'.$data->firstname.'" > <br>
                                    <input type="text" name="lastname"  id="lastname"  placeholder="Lastname"  value="'.$data->lastname.'" > <br>
                                    <input type="text" name="username"  id="user_name" placeholder="Username"  value="'.$data->username.'" > <br>
                                    <input type="text" name="email"     id="user_mail" placeholder="email"     value="'.$data->email.'"> <br>
                                    <input type="text" name="number"    id="number"    placeholder="mobile no."  value="'.$data->number.'"> <br>
                                    <input type="date" name="birthday"  id="birthday"  placeholder="birthday"  value="'.$data->birthday.'"> <br>
                              
                                    <div style="padding: 10px;">
                                          <br> Sex: <br>
                                          <input type="radio" value="male" name="gender" '.$gender_male.'>Male<br>
                                          <input type="radio" value="female" name="gender" '.$gender_female.'>Female<br>
                                    </div>
                                    <input type="password" name="password" id="user_password" placeholder="Password" value="'.$data->password.'"> <br>
                                    <input type="password" name="password2" id="user_password2" placeholder="Retype Password" value="'.$data->password.'"> <br>
                                    <input type="button" value="Save Settings" id="save_settings_button" OnClick="collect_data(event)" style=" color: black; background-color: #44a9cc;border: 2px solid black;"> <br>
                              
                              </form>
                  </div>
                  
            
            ';
      
    
    $info->message = $mydata;
    $info->data_type = "contacts";
    echo json_encode($info);
} else {

    $info->message = "No contacts were found ";
    $info->data_type = "error";
    echo json_encode($info);
}
 ?>

