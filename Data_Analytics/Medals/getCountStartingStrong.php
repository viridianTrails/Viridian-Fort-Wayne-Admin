<?php
    $sql = "SELECT intEarnedId FROM medalsEarned WHERE intMedalId = '1'";
    //executes query
    $result = $conn->query($sql) or die("Query fail");
    $count = $result->num_rows;
    echo $count;
?>