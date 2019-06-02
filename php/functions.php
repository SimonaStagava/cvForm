<?php 

// Autoload class definitions
function my_autoload($class) 
{
  if (preg_match('/\A\w+\Z/', $class)) {
    include('classes/' . $class . '.class.php');
  }
}

spl_autoload_register('my_autoload');

?>