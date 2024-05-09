<?php

// اتصال بقاعدة البيانات
require_once("includes/config.php");

// استعلام SQL لاسترداد كل المستخدمين
$query = $con->prepare("SELECT * FROM users WHERE isAdmin=0");
$query->execute();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>List Users</title>
    <link rel="stylesheet" type="text/css" href="assets/style/style.css"/>
</head>
<body>

    <table>
        <tr>
            <th>Id</th>
            <th>FirstName</th>
            <th>LastName</th>
            <th>Username</th>
            <th>Email</th>
            <th>isSubscribe</th>
        </tr>
        <?php
        // عرض البيانات في الجدول
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['firstName'] . "</td>";
            echo "<td>" . $row['lastName'] . "</td>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['isSubscribed'] . "</td>";
            echo "<td>" . "<button class='DeleteUser'>Delete</button>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
