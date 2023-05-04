<?php
    //fix efter redovisning (1)
    session_start();
    //Denna kod skapar en konstant med namnet "DB_SERVER", "DB_USERNAME", "DB_PASSWORD" "DB_NAME" och om det inte redan är definierat och ger det värdet "localhost" etc
    if (!defined('DB_SERVER')) {
        define('DB_SERVER', 'localhost');
    }
    if (!defined('DB_USERNAME')) {
        define('DB_USERNAME', 'root');
    }
    if (!defined('DB_PASSWORD')) {
        define('DB_PASSWORD', '');
    }
    if (!defined('DB_NAME')) {
        define('DB_NAME', 'BelConnectDB');
    }

    //denna kod används för att skapa kontakt med databasen. Eftersom att den finns här kan jag bara använda $conn
    //i andra filer och jag behöver inte skriva hela varje gång
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>