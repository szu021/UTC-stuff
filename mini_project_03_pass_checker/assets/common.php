<?php

function user_message(){
    $msg = "";
    if (isset($_SESSION["message"])) {
        $msg = 'USER MESSAGE: ' . $_SESSION["message"];
//      in case user message isn't cleared
        $_SESSION["message"] = '';
        unset($_SESSION["message"]);

    }
    return $msg;



}


function string_length($mystring){
    $answer = false;

    $length = strlen($mystring);

    if ($length > 8) {
        $answer = true;
    }
    return $answer;
}