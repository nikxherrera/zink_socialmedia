<?php

if(isset($_SESSION['generate_uid'])){
    unset($_SESSION['generate_uid']);
}

$info->logged_in = false;
echo json_encode($info);