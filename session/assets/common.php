<?php

function user_message(){
    $msg = "";

    if (isset($_SESSION["message"])) {

        $msg = 'USER MESSAGE: ' . $_SESSION["message"];
//      incase user message isn't cleared
        $_SESSION["message"] = '';
        unset($_SESSION["message"]);

    }
    return $msg;



}
