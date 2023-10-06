<?php
/*Return HTTP Request 200*/
http_response_code(200);

$messages = [];

$all = getAll();
$text = "Date: " . $all['timestamp'] . "\nTemp: " . $all['temp'] . "\nHumidity: " . $all['humidity'];
$messages['messages'][0] = getFormatTextMessage($text);


$encodeJson = json_encode($messages);
$LINEDatas['url'] = "https://api.line.me/v2/bot/message/broadcast";
$LINEDatas['token'] = "ufB9G8vmXhLFXzJi/U9zP1U9CxNch4QQBVYPM3VDRdy/n+SOsXh0iHIfParqXCCRdB4sRM7L2pjNV9eNioT+BMWrb6FN1fdl/9uQUT1fcmGGz17art5bqoZFu59m02mYvJnYiViquqV8uc/NcTJhGAdB04t89/1O/w1cDnyilFU=";


$results = sentMessage($encodeJson, $LINEDatas);

file_put_contents('boardcast.txt', json_encode($results, true) . PHP_EOL, FILE_APPEND);


function getAll()
{
  //php get data from db return as json
  $datas = file_get_contents("https://3d5b-183-88-227-151.ngrok-free.app/iot_project/select.php");
  $deCode = json_decode($datas, true);
  return $deCode[0];
}

function getFormatTextMessage($text)
{
  $datas = [];
  $datas['type'] = 'text';
  $datas['text'] = $text;
  return $datas;
}


function sentMessage($encodeJson, $datas)
{
  $datasReturn = [];
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => $datas['url'],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $encodeJson,
    CURLOPT_HTTPHEADER => array(
      "authorization: Bearer " . $datas['token'],
      "cache-control: no-cache",
      "content-type: application/json; charset=UTF-8",
    ),
  ));
  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);
  if ($err) {
    $datasReturn['result'] = 'E';
    $datasReturn['message'] = $err;
  } else {
    if ($response == "{}") {
      $datasReturn['result'] = 'S';
      $datasReturn['message'] = 'Success';
      $datasReturn['timestamp'] = date("Y-m-d H:i:s");
    } else {
      $datasReturn['result'] = 'E';
      $datasReturn['message'] = $response;
    }
  }
  return $datasReturn;
}
