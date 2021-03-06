<?php
    include("../MySQL_Connections/config.php");
    include("../Emails/sendEmployeeLogin.php");
    
    if($_SERVER["REQUEST_METHOD"] == "GET") {
        
    $firstName = $_GET['firstName'];
    $lastName = $_GET['lastName'];
    $email = $_GET['email'];
    $securityLevel = $_GET['intSecurityLevel'];
    
    $usernameBase = $firstName[0].$lastName;
    
    $sql = "SELECT * FROM `employees` WHERE `strUsernameBase` = '$usernameBase'";
    $result = $conn->query($sql) or die("Query fail1");
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $countWithUsernameBase =  $result->num_rows;
     
     $usernameNumber = $countWithUsernameBase + 1;
     $username = $usernameBase.$usernameNumber;
     $username = strtolower($username);
     $usernameBase = strtolower($usernameBase);

    $randomPassword = substr(md5(rand()), 0, 7);
    echo $randomPassword;
    
    $options = [
        'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
    ];
                                
    $hashedPassword = password_hash($randomPassword, PASSWORD_BCRYPT, $options);
     
    $sql = "INSERT INTO `employees` (`strFirstName`, `strLastName`,
    `strUsername`, `strUsernameBase`, `strEncryptedPassword`, `intSecurityLevel`,
    `strEmailAddress`, `securityQuestion1`, `securityQuestion1Answer`, 
    `securityQuestion2`, `securityQuestion2Answer`, `accountLocked`,
    `loginAttempts`, `securityQuestionAttempts`, `activeUser`, `firstAccess`) 
    VALUES ('$firstName', '$lastName' , '$username','$usernameBase',
    '$hashedPassword', '$securityLevel', '$email', '', '',
    '', '', 0, 0, 0, 1, 1)";

    $result = $conn->query($sql) or die("Query fail2");
    
    date_default_timezone_set('UTC');
    $date = date('m/d/Y h:i:s a', time());
    $sql = "UPDATE `tasks` SET `lastCompleted`= '$date' WHERE `taskId`= '2'";
    $result = $conn->query($sql) or die("Update fail");
    
    //echo "Username: ". $username . "Password: " . $randomPassword;
    sendLogin($email, $firstName, $username, $randomPassword);

    header("location: /Management/manageEmployees.php");
    }
?>
   