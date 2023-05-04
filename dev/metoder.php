<?php 
    require "./config.php";


     //Kollar om strängen har siffror
    function siffror_test($str){
        return preg_match('/\d/', $str) > 0;
    };

    //En function som kollar at strängen som jag lägger in bara inhelåller bokstäver (stora och små från A-Z)
    //samt mellan rum (whitespaces)
    function inputTest($str){
        return preg_match('/\S/', $str) && preg_match('/[a-zA-Z]/', $str);
    };

    //denna funaktion kollar så att användarnamnet inte har några speciella karaktärer
    function testUsername($str){
        return preg_match('/^[a-zA-Z0-9_]{1,}$/', $str);
    }

    //funktionen används för att kolla om telefonnumret endast innehåller sifforor och ett "+" tecken  
    function checkPhoneNumber($str) {
        return preg_match('/^[0-9+]+$/', $str);
      }
    
?>
