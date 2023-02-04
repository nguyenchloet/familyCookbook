<?php  
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $dbHost = "localhost";
    $dbUser = "root";
    $dbPassword = "";
    $dbName = "recipes";
    
    $con = mysqli_connect($dbHost,$dbUser,$dbPassword,$dbName);

    if(!$con)
    {
        echo 'Database Connection Error';
    }           
?>