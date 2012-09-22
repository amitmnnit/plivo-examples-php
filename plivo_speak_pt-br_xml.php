<?php
    require_once 'plivo.php';

    $convmap = array(0x80, 0xffff, 0, 0xffff);
    $body = mb_encode_numericentity("Olá a todos! Esta é uma chamada de teste de plivo. O português é uma língua muito doce.", $convmap, 'UTF-8'); 
    $url = 'http://examples.com/playTrumpet.mp3';
    $attributes = array (
        'loop' => 2,
    );

    $r = new Response();

    // Add speak element
    $r->addSpeak($body, $attributes);

    // Add play element
    $r->addPlay($url, $attributes);

    // Add wait element
    $wait_attribute = array(
        'length' => 3,
    );
    $r->addWait($wait_attribute);

    echo($r->toXML());

    //  Output:
    //  <Response>
    //  <Speak loop="2">Calling from Plivo</Speak>
    //  <Play loop="2">http://examples.com/playTrumpet.mp3</Play>
    //  <Wait length="3" />
    //  </Response>
    //
    //
?>
