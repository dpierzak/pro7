<?php
header('Content-Type: application/json');
$passPhrase = md5('Syj0n123!');
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    switch($_POST['type']){
        case 'healthcheck':
            $url = 'http://' . $_POST['ip'] . ':'.$_POST['port'] . '/v1/presentation/active?chunked=false';
            $resp = request($url);
            http_response_code(200);
            echo json_encode(['error' => $resp]);
            break;
        case 'credential':
            if(md5($_POST['content']) === $passPhrase){
                http_response_code(200);
                echo json_encode(['error' => 'Authorized']);
            } else {
                http_response_code(403);
                echo json_encode(['error' => 'Unauthorized']);
            }
            break;
        case 'change':
            if($_POST['content'] === 'prev'){
                $url = 'http://' . $_POST['ip'] . ':'.$_POST['port'] . '/v1/presentation/active/previous/trigger';
            } else {
                $url = 'http://' . $_POST['ip'] . ':'.$_POST['port'] . '/v1/presentation/active/next/trigger';
            }
            $resp = request($url);
            http_response_code(200);
            echo json_encode(['error' => $resp]);
            break;
        default:
            http_response_code(403);
            echo json_encode(['error' => 'Unauthorized']);
            break;
    }

} else {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
}

function request($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'accept: */*',
    ));

    $response = curl_exec($ch);
    if(curl_errno($ch)){
        http_response_code(500);
        echo json_encode(['error' => curl_error($ch)]);
    }
    curl_close($ch);

    return $response;
}
?>