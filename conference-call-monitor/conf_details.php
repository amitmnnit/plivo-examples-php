<?php
session_start(); 
require_once 'plivo.php';
$member_id = $_POST['memberid'];
$auth_id=$_SESSION['auth_id'];
$auth_token=$_SESSION['auth_token'];
#echo $auth_id;
echo '<h1 align="center">Plivo Conference</h1>';
$p = new RestAPI($auth_id, $auth_token);
if( isset($_GET['Room']))
{
    $room = $_GET['Room'];
}
else if(isset($_POST['Room']))
{
    $room = $_POST['Room'];
}
if(empty($room))
{
if ($_POST['alldetails']=="Get details")
{
    $alldetails = $_POST['alldetails'];
    echo "<h2 align='center'>$alldetails</h2>";
    $response = $p->get_live_conferences();
}
else if ($_POST['hangupall']=="Hangup conferences")
{
    $hangupall = $_POST['hangupall'];
    echo "<h2 align='center'>$hangupall</h2>";
    $response = $p->hangup_all_conferences();
}
else
{
    echo '<br><br>';
    echo "<h2 align='center'>Please enter conference room!</h2>";
}
}
else{

$params = array(
     'conference_name' => $room,
      );
if (isset($_POST['details']))
{
    $details =  $_POST['details'];
}
else
{
    $details = $_GET['details'];
}
if ($details == "Get details")
{
    echo "<h2 align='center'>Details and actions for Conference Room: $room</h2>";
    $response = $p->get_live_conference($params);
    echo '<h3>Member actions in conference</h3>
        <form action="conf_details.php" method="post">
        Conference name:
        <input type="text" name="Room"><br><br>
        Member&nbsp;&nbsp;&nbsp;&nbsp;Id:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="text" name="memberid"><br><br>
        <input type="submit" name="submit" value="Deaf">
        <input type="submit" name="submit" value="UnDeaf">
        <input type="submit" name="submit" value="Mute">
        <input type="submit" name="submit" value="UnMute">
        <input type="submit" name="submit" value="Kick">
        <input type="submit" name="submit" value="Hangup"><br>
        <br>URL of the sound file to be played:<br>
        <input type="text" name="url"><br>
        <input type="submit" name="submit" value="Play">
        <input type="submit" name="submit" value="Stop Play">
        <br><br>Text Speach:<br>
        <input type="text" name="speach"><br>
        <input type="submit" name="submit" value="Speak">
        </from>  ';
    echo '<br><h3>Conference Details</h3>';
}
else if ($_POST['hangup']=="Hangup conference")
{
    $hangup = $_POST['hangup'];
    echo "<h2 align='center'>$hangup</h2>";
    $response = $p->hangup_conference($params);
}
else if ($_POST['record']=="Start Recording")
{
    $record = $_POST['record'];
    echo "<h2 align='center'>$record</h2>";
    $response = $p->record_conference($params);
}
else if ($_POST['stop']=="Stop Recording")
{
    $stop =  $_POST['stop'];
    echo "<h2 align='center'>$stop</h2>";
    $response = $p->stop_record_conference($params);
}
else if ($_POST['memberid']==$member_id)
{
    $param = array(
        'conference_name' => $room,
        'member_id' => $member_id,
    );
    if ($_POST['submit']=="Play")
    {
        $url = $_POST['url'];
        $parameter = array(
            'conference_name' => $room,
            'member_id' => $member_id,
            'url' => $url,
            );
        $submit = $_POST['submit'];
        echo "<h2 align='center'>$submit</h2>";
        $response = $p->play_member($parameter);
    }
    else if ($_POST['submit']=="Stop Play")
    {
        $submit = $_POST['submit'];
        echo "<h2 align='center'>$submit</h2>";
        $response = $p->stop_play_member($param);
    }
    else if ($_POST['submit']=="Speak")
    {
        $speach = $_POST['speach'];
        $para = array(
            'conference_name' => $room,
            'member_id' => $member_id,
            'text' => $speach,
            );
        $submit = $_POST['submit'];
        echo "<h2 align='center'>$submit</h2>";
        $response = $p->speak_member($para);
    }
    else if ($_POST['submit']=="Deaf")
    {
        $submit = $_POST['submit'];
        echo "<h2 align='center'>$submit</h2>";
        $response = $p->deaf_member($param);
    }
    else if ($_POST['submit']=="UnDeaf")
    {
        $submit = $_POST['submit'];
        echo "<h2 align='center'>$submit</h2>";
        $response = $p->undeaf_member($param);
    }
    else if ($_POST['submit']=="Mute")
    {
        $submit = $_POST['submit'];
        echo "<h2 align='center'>$submit</h2>";
        $response = $p->mute_member($param);
    }
    else if ($_POST['submit']=="UnMute")
    {
        $submit = $_POST['submit'];
        echo "<h2 align='center'>$submit</h2>";
        $response = $p->unmute_member($param);
    }
    else if ($_POST['submit']=="Kick")
    {
        $submit = $_POST['submit'];
        echo "<h2 align='center'>$submit</h2>";
        $response = $p->kick_member($param);
    }
    else if ($_POST['submit']=="Hangup")
    {
        $submit = $_POST['submit'];
        echo "<h2 align='center'>$submit</h2>";
        $response = $p->hangup_member($param);
    }
}

}
if($response)
{
echo "HTTP status code:",$response['status'],"<br />";
$res = $response['response'];
foreach ($res as $key => $value)
{
    if(is_array($value))
    {
        echo $key,": <br />";
        foreach ($value as $mem_count => $mem_array)
        {
            $count =intval($mem_count)+1;
            if(is_array($mem_array))
            {
                echo "<br \>member $count:<br \>";
                foreach($mem_array as $mem_key => $mem_val)
                echo "$mem_key: $mem_val</br />";
            }
            else
            {
                echo "<br \>Conference $count: $mem_array<br \>";
            }
        }
    }
    else
    {
        echo "$key: $value<br />";
    }
}
#echo json_encode($response);
$details="Get details";
echo '<br><br><br>';
echo "<a href='conf_details.php?Room=$room&details=$details'>Conference details</a>";
}
echo '<br><br>
<a href="index.php">HOME PAGE</a><br><br>
Visit Plivo
<a href="http://www.plivo.com">www.plivo.com</a>'
?>
