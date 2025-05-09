<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once __DIR__ . '/twilio-php/src/Twilio/autoload.php';
use Twilio\Rest\Client;

$sid    = getenv('TWILIO_SID');
$token  = getenv('TWILIO_TOKEN');
$from   = getenv('TWILIO_FROM');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['to']) || !isset($data['message'])) {
    echo json_encode(['success' => false, 'error' => 'Paramètres manquants']);
    exit;
}

$client = new Client($sid, $token);

try {
    $message = $client->messages()->create(
        $data['to'],
        ['from' => $from, 'body' => "AgroPastoral : " . $data['message']]
    );
    echo json_encode(['success' => true, 'sid' => $message->sid]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
