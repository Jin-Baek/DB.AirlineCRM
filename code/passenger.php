<?php
    session_start();

    $conn = mysql_connect('localhost','root','apmsetup');

    mysql_set_charset('utf-8',$conn);
    mysql_select_db('project',$conn);

    ## 개인 정보, 개인 항공 정보 쿼리문
    $sql = "SELECT * from passenger inner join airplane on passenger.airplaneID = airplane.airplaneNum where ownid='{$_SESSION['user']}';";

    $result = mysql_query($sql,$conn);
    $row= mysql_fetch_array($result);

    ## 20대 인기여행지 쿼리문
    $FAM20_sql ="SELECT p.age - MOD( p.age, 10 ) AS age_range, a.destination, count( p.age ) AS counting
    FROM passenger p, airplane a
    WHERE p.airplaneID = a.airplaneNum
    GROUP BY age_range, a.destination
    HAVING age_range =20
    ORDER BY counting DESC 
    LIMIT 0 , 2;";

    ## 30대 인기여행지 쿼리문
    $FAM30_sql ="SELECT p.age - MOD( p.age, 10 ) AS age_range, a.destination, count( p.age ) AS counting
    FROM passenger p, airplane a
    WHERE p.airplaneID = a.airplaneNum
    GROUP BY age_range, a.destination
    HAVING age_range =30
    ORDER BY counting DESC 
    LIMIT 0 , 2;";

    ## 40대 인기여행지 쿼리문
    $FAM40_sql ="SELECT p.age - MOD( p.age, 10 ) AS age_range, a.destination, count( p.age ) AS counting
    FROM passenger p, airplane a
    WHERE p.airplaneID = a.airplaneNum
    GROUP BY age_range, a.destination
    HAVING age_range =40
    ORDER BY counting DESC 
    LIMIT 0 , 2;";
    
    $FAM20_result = mysql_query($FAM20_sql,$conn);
    $FAM30_result = mysql_query($FAM30_sql,$conn);
    $FAM40_result = mysql_query($FAM40_sql,$conn);
    

    ## 비행시간 쿼리문 (같은 목적지를 가는 여러 항공기가 있어도 가능)
    $flightT_sql="SELECT destination,avg(TIMESTAMPDIFF(MINUTE,departureT,landingT))
    as flight_time from airplane
    group by destination
    order by flight_time desc;";

    $flightT_result = mysql_query($flightT_sql,$conn);

    mysql_close();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Passenger Page</title>
        <meta charset='utf-8'>
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
            legend {
                background-color: #00398e;
                color: #fff;
                padding: 3px 6px;
                font-size:18px;
            }

            .output {
                font: 1rem 'Fira Sans', sans-serif;
            }

            input {
              margin: .4rem;
            }
            hr {
                border-top: 7px double #c9c9c9;
            }
            li{
                margin:25px;
                font-size: 18px; 
                color: #003e75; 
            }
            #flo{
                float:left;
                margin-top:21px;
            }
        </style>
    </head>
    <body>
        <table class="t" id="flo">
            <thead>
                <tr>
                    <th colspan=2>개인정보</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>아이디</th>
                    <td><?echo $row['ownid'];?></td>
                </tr>
                <tr>
                    <th>이름</th>
                    <td><?echo $row['name'];?></td>
                </tr>
                <tr>
                    <th>나이</th>
                    <td><?echo $row['age'];?></td>
                </tr>
                <tr>
                    <th>성별</th>
                    <td><?echo $row['sex'];?></td>
                </tr>
                <tr>
                    <th>거주지</th>
                    <td><?echo $row['residence'];?></td>
                </tr>
            </tbody>
        </table>
        <br>
        <table class="t">
            <thead>
                <tr>
                    <th colspan=2>개인 항공편 일정</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>항공기 번호</th>
                    <td><?echo $row['airplaneID'];?></td>
                </tr>
                <tr>
                    <th>출발시간</th>
                    <td><?echo $row['departureT'];?></td>
                </tr>
                <tr>
                    <th>도착시간</th>
                    <td><?echo $row['landingT'];?></td>
                </tr>
                <tr>
                    <th>목적지</th>
                    <td><?echo $row['destination'];?></td>
                </tr>
                <tr>
                    <th>좌석번호</th>
                    <td><?echo $row['seatNUM'];?></td>
                </tr>
                <tr>
                    <th>탑승 게이트</th>
                    <td><?echo $row['gate'];?></td>
                </tr>
            </tbody>
        </table>
        <br>
        <hr>
  <fieldset>
    <legend>Recommendation destination</legend>
    <ul>
        <li style="font-weight: bold;">20대</li>
        <li style="list-style:none;">
        <ol type='I'>
        <?php
            while($FAM20_row = mysql_fetch_array($FAM20_result)){
                echo "<li>$FAM20_row[destination] ($FAM20_row[counting])</li>";
            }?>
        </ol>
         </li>
        <li style="font-weight: bold;">30대</li>
        <li style="list-style:none;">
        <ol type='I'>
        <?php
            while($FAM30_row = mysql_fetch_array($FAM30_result)){
                echo "<li>$FAM30_row[destination] ($FAM30_row[counting])</li>";
            }?>
        </ol>
        </li>
        <li style="font-weight: bold;">40대</li>
        <li style="list-style:none;">
        <ol type='I'>
        <?php
            while($FAM40_row = mysql_fetch_array($FAM40_result)){
                echo "<li>$FAM40_row[destination] ($FAM40_row[counting])</li>";
            }?>
        </ol>
        </li>
    </ul>
  </fieldset>
  
  <hr>

  <fieldset>
    <legend>Average flight time</legend>
    <ul>
        <?php
            while($flightT_row = mysql_fetch_array($flightT_result)){
                $minute=$flightT_row[flight_time]%60;
                $hour=($flightT_row[flight_time]-$minute)/60;
                echo "<li>$flightT_row[destination]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ㅡ ㅡ ㅡ ㅡ ㅡ
                &nbsp;&nbsp;&nbsp;"."$hour hours "."$minute minutes</li>";
        }?>
    </ul>
  </fieldset>

  

    </body>
</html>