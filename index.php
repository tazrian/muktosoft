<?php

  $req_uri = $_SERVER["REQUEST_URI"];
  $uri_exploded = explode("?", $req_uri);
  $q = rawurldecode($uri_exploded[1]);
  $question = explode("=", $q);
  $greeting = explode("!", $question[1]);
  
  //echo rawurldecode($uri_exploded[0]);
  //echo rawurldecode($uri_exploded[1]);
  
/********** To handle GREETINGS ***************/
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
    $msg = array("answer" => $reply);
    echo json_encode($msg);
  }
/********** To handle weather ************/
else if($uri_exploded[0] == "/weather"){
  $n_words = str_word_count($question[1],0);
  $question = explode(" ",$question[1]);
  $city = $question[$n_words-1];
  $city = explode("?", $city);
  $city = $city[0]; 
  $url = "http://api.openweathermap.org/data/2.5/weather?q=".$city;
  $response = file_get_contents($url);
  $response = json_decode($response,true);

  $question = strtolower(implode($question));
  if( $response["cod"] != 404){
      if (strpos($question, 'temperature') !== false){
        $msg = array("answer" => $response["main"]["temp"]);
      }
      else if (strpos($question, 'humidity') !== false){
        $msg = array("answer" => $response["main"]["humidity"]);
      }
      else if(strpos($question, 'rain') !== false){
        if(strcasecmp($response["weather"][0]["main"], "rain") == 0){
                $msg = array("answer" => "YES");
                }
          else{
             $msg = array("answer" => "NO");
           }
      }
      else if(strpos($question, 'clouds') !== false){
        if(strcasecmp($response["weather"][0]["main"], "clouds") == 0){
                $msg = array("answer" => "YES");
           }
          else{
             $msg = array("answer" => "NO");
           }
      }
      else if(strpos($question, 'clear') !== false){
        if(strcasecmp($response["weather"][0]["main"], "clear") == 0){
                $msg = array("answer" => "YES");
                }
          else{
             $msg = array("answer" => "NO");
            }
      }
      else{
        $msg = array("answer" => "Sorry,Kitty. I can't understand your question.");
      }
     
    }
  else if($response["cod"] == 404){
    $msg = array("answer" => "Hi,Kitty! PLease clearly mention the name of the city.");
    
  }
  echo json_encode($msg);
}

/********** To handle World affairs **********************/
else if($uri_exploded[0] == "/qa"){
    $reply = "This is not handled";
    $msg = array("answer" => $reply);
    echo json_encode($msg);
}
/********* To handle all other case *********************/
else{
    $reply = "This is not handled";
    $msg = array("answer" => $reply);
    echo json_encode($msg);
  
}
?>
