<?php

// URL a la que se harán las solicitudes
$url = "https://polly.eu-west-3.amazonaws.com/v1/speech";

// Número de solicitudes a realizar
$num_requests = 200;

// Datos para la solicitud POST
$data = array(
    'Text' => 'Hello, world!',
    'OutputFormat' => 'mp3',
    'VoiceId' => 'Joanna'
);

// Codificar los datos a JSON
$json_data = json_encode($data);

// Función para realizar la solicitud cURL
function make_request($url, $json_data) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($json_data)
    ));
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

// Realizar las solicitudes en un bucle
for ($i = 1; $i <= $num_requests; $i++) {
    $response = make_request($url, $json_data);
    echo "Response $i: " . $response . "\n";
}

?>

