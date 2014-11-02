<?php
define('DB_NAME','collegeSai');
define('DB_USERNAME','collegeSai');
define('DB_PASSWORD','C0ll2eg@');
define('DB_HOST','localhost');

function __autoload($className){
    
    $regInput = array($className);
    if(preg_grep('/Model/',$regInput)){
        $fileName = "Model/$className.php";
    }
    
    if(preg_grep('/Controller/',$regInput)){
        $fileName = "Controller/$className.php";
    }
    
    if(preg_grep('/Util/',$regInput)){
        $fileName = "Util/$className.php";
    }
    
    if(!empty($fileName) && file_exists($fileName)){
        include_once($fileName);
    }
}