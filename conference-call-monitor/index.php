<html><body><h1 align="center">Plivo Conference</h1>
<h3>Add member to conference</h3>
<form action="index.php" method="post">
Conference name:<input type="text" name="Room"><br><br>
Add&nbsp;&nbsp;Number:&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="Number"><br><br>
Caller&nbsp;ID(From):
<input type="text" name="from"><br><br>
<input type="submit" value="Call">
</form>
<?php
    session_start(); 
    require_once 'plivo.php';
    $auth_id = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
    $auth_token = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
    $_SESSION['auth_id'] =  $auth_id;
    $_SESSION['auth_token'] = $auth_token;
    $room = $_POST['Room'];
    $number = $_POST['Number'];
    $from = $_POST['from'];
    $p = new RestAPI($auth_id, $auth_token);
    #api call to a number
    if($number && $room && $from)
    {
    $params = array(
            'from' => "$from",
            'to' => "$number",
            'answer_url' => "http://162.209.56.40/amit/conference/conference_xml.php?Room=$room"
        );
        $response = $p->make_call($params);
        if($response['status']=='201')
        {
            echo "<h4 align='center'>Success: $number added to Conference: $room</h4><br>";
        }
        else
        {
            $status = $response['status'];
            echo  "<h4 align='center'>ERROR: $status, Please check entered number!</h4><br>";
        }
    }
    else
    {
        echo "<h4 align='center'>Please Enter Number, caller ID and Conference Room to add number to Conference.</h4>";
    }
?>
<br>
<h3>Conference actions</h3>
<form action="conf_details.php" method="post">
Conference name:<input type="text" name="Room"><br>
<input type="submit" name="details" value="Get details">
<input type="submit" name="hangup" value="Hangup conference">
<input type="submit" name="record" value="Start Recording">
<input type="submit" name="stop" value="Stop Recording">
<h3>All Conference actions</h3>
<input type="submit" name="alldetails" value="Get details">
<input type="submit" name="hangupall" value="Hangup conferences">
</form>
Visit Plivo
<a href="http://www.plivo.com">www.plivo.com</a>
</body>
</html>

