<?php
if(!isset($_SESSION)){
session_start();
}
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
     $link = "https";
}else{
    $link = "http";
}
function access($page_id){
    return true;
}
?>