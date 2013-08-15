<?php
require_once 'plivo.php';
$body = $_GET['Room'];
$r = new Response();
$r->addConference($body);
echo($r->toXML());
?>
