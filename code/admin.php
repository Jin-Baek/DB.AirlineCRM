
<?php

    $conn = mysql_connect('localhost','root','apmsetup');

    mysql_set_charset('utf-8',$conn);
    mysql_select_db('project',$conn);

    $sql = "SELECT id,pwd,name,age,sex,residence,airplaneID,departureT,landingT,destination,
            gate,seatID,type,lugage,price 
            from account account,airplane airplane,passenger passenger,seat seat
            where account.id=passenger.ownid and 
            airplane.airplaneNum=passenger.airplaneID and 
            seat.seatID=passenger.seatNum;";
    $result = mysql_query($sql,$conn); 
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Administer</title>
        <style>
            table.t {
                border-collapse: collapse;
                text-align: left;
                line-height: 1.5;
                }
            table.t thead th {
                padding: 10px;
                font-weight: bold;
                vertical-align: top;
                color: #369;
                border-bottom: 3px solid #036;
                }
            table.t tbody th {
                width: 150px;
                padding: 10px;
                font-weight: bold;
                vertical-align: top;
                border-bottom: 1px solid #ccc;
                background: #f3f6f7;
                }
            table.t td {
                width: 350px;
                padding: 10px;
                vertical-align: top;
                border-bottom: 1px solid #ccc;
                }
        </style>
    </head>
    <body>
        <h1>Passenger Information</h1>
        <table class='t'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Password</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Sex</th>
                    <th>Residence</th>
                    <th>Airplane number</th>
                    <th>Departure time</th>
                    <th>Landing time</th>
                    <th>Destination</th>
                    <th>Gate</th>
                    <th>Seat number</th>
                    <th>Seat type</th>
                    <th>Lugage allowed </th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
            <?php
             while($row = mysql_fetch_array($result)){
             echo"              
                <tr>
                 <th>$row[id]</th>
                 <td>$row[pwd]</td>
                 <td>$row[name]</td>
                 <td>$row[age]</td>
                 <td>$row[sex]</td>
                 <td>$row[residence]</td>
                 <td>$row[airplanID]</td>
                 <td>$row[departureT]</td>
                 <td>$row[landingT]</td>
                 <td>$row[destination]</td>
                 <td>$row[gate]</td>
                 <td>$row[seatID]</td>
                 <td>$row[type]</td>
                 <td>$row[lugage]</td>
                 <td>$row[price]</td>
                </tr>
            ";
             }?>
            </tbody>
        </table>
    </body>
</html>