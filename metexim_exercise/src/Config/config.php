<?php
define('DB_NAME','college');
define('DB_USERNAME','college');
define('DB_PASSWORD','C0ll2eg$');
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