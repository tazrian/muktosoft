<?php
  
  $req_uri = $_SERVER["REQUEST_URI"];
  $uri_exploded = explode("?", $req_uri);
  $q = rawurldecode($uri_exploded[1]);
  $question = explode("=", $q);
  $greeting = explode("!", $question[1]);
  
  //echo rawurldecode($uri_exploded[0]);
  //echo rawurldecode($uri_exploded[1]);
  
  if($uri_exploded[0] == "/greetings"){
      if(strtolower($greeting[0]) == strtolower("Hello")){
        $reply = "Hello,Kitty! I am fine. And You?";
      }
      else if(strtolower($greeting[0]) == strtolower("Hi")){
        $reply = "Hello,Kitty! This is Rian.";
      }
      else if(strtolower($greeting[0]) == strtolower("Good Morning") || strtolower($greeting[0]) == strtolower("Good Evening") 
                                          || strtolower($greeting[0]) == strtolower("Good Night")){
        $reply = "Hello,Kitty!".$greeting[0];
      }
      else{
         $reply = "Hello,Kitty!" ."Sorry! I don't understand what you say.";
      }
  }
  //echo $reply;
  $msg = array("answer" => $reply);
  echo json_encode($msg);
  
?>
