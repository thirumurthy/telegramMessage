<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('simple_html_dom.php');
$apiToken = "655929815:AAFSQ5_Iri6vD-SyLcBT3r5_hULPq9Yaqrc";
$Fullcontent ="";
//base url
$base = 'https://www.firstpost.com/tech';

$curl = curl_init();
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_URL, $base);
curl_setopt($curl, CURLOPT_REFERER, $base);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
$str = curl_exec($curl);
curl_close($curl);

// Create a DOM object
$html_base = new simple_html_dom();
// Load HTML from a string
$html_base->load($str);
 
//echo "content:".$html_base;
foreach($html_base->find('ul.most-popular-list li') as $newselement) 
    {
        $Fullcontent = $Fullcontent.$newselement->find('span', 0)->plaintext.".";
        $Fullcontent = $Fullcontent.$newselement->find('p', 0)->plaintext;
        $Fullcontent = $Fullcontent."\n";

    } 

    $Fullcontent = $Fullcontent."\n\n<b>Other Updates :</b>\n";
    foreach($html_base->find('div.title-wrap h3') as $newselement) 
    {
        $Fullcontent = $Fullcontent.$newselement->plaintext.".";
        $Fullcontent = $Fullcontent."\n\n";

    } 


    // send message.
    $post = [
        'chat_id' => '@technewsup',
        'text' => $Fullcontent,
        'parse_mode' => 'HTML',
    ];
    var_dump($post); 
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL,"https://api.telegram.org/bot".$apiToken."/sendMessage?");
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
// execute!
$response = curl_exec($curl);
if (curl_error($curl)) {
    $error_msg = curl_error($curl);
    echo $error_msg;
}
// close the connection, release resources used
curl_close($curl);
var_dump($response);


/*
$apiToken = "my_bot_api_token";

$data = [
    'chat_id' => '@my_channel_name',
    'text' => 'Hello world!'
];

$response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($data) );

*/


?>