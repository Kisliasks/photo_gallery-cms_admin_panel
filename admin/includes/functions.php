<?php 



// function classAutoLoader($class){

// $class = strtolower($class);
// $the_path = "includes/{$class}.php";
// // include ("includes/{$class}.php");

// if(file_exists($the_path)) {

//     require_once($the_path);
// } else {

//     die("This file name {$class}.php was not...");
// }


// spl_autoload_register('classAutoLoader');

// }

spl_autoload_register(function($class){
$class = strtolower($class);

include $class.".php";


});

function redirect($location) {
    header("Location: {$location}");
}



?>