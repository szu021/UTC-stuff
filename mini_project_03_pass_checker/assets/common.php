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

function length_output() {
    $msg = "";

    $mystring = $_POST["password"];
    $length = strlen($mystring);
    $msg = 'Your password is ' . $length . ' characters long';

    return $msg;
}


function hasUpperCase($mystring) {
    if (preg_match('/[A-Z]/', $mystring)) {
        return true;

    } else {
        return false;
    }
}

function hasLowerCase($mystring) {
    if (preg_match('/[a-z]/', $mystring)) {
        return true;

    } else {
        return false;
    }
}

function hasNumber($mystring) {
    if (preg_match('/[0-9]/', $mystring)) {
        return true;

    }else {
        return false;
    }
}

function hasSpecialCharacter($mystring) {
    if (preg_match('/[^a-zA-Z0-9]/', $mystring)) {
        return true;
    } else {
        return false;
    }
}

function wordChecker($pswd) {
    $pswd = strtolower($pswd);
    $answer = false;
    if (!(str_contains($pswd, "password"))) {
        $answer = true;
    }
    return $answer;

    }

function firstSpecial($pswd) {
    return preg_match('/[^a-zA-Z0-9]/', substr($pswd, 0 , 1) );
}

function lastSpecial($pswd) {
    return preg_match('/[^a-zA-Z0-9]/', substr($pswd, -1 , 1) );
}


function firstnumber($pswd) {
    return preg_match('/[0-9]/', substr($pswd, 0 , 1) );
}