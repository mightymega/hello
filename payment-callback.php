<?php
require 'config.php';

$transaction_id = $_GET['transaction_id'];
$tx_ref = $_GET['tx_ref'];

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/{$transaction_id}/verify",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer KeyFLWSECK-8fa1aaf838cc192bef4330ea818fde18-1932c5fdff8vt-X"
    ),
));

$response = curl_exec($curl);
curl_close($curl);
$response_data = json_decode($response, true);

if ($response_data['status'] === 'success' && $response_data['data']['status'] === 'successful') {
    $amount = $response_data['data']['amount'];
    $stmt = $db->prepare("UPDATE users SET total_investments = total_investments + ? WHERE id = ?");
    $stmt->execute([$amount, $_SESSION['user_id']]);
    echo "Payment successful! Your investment has been updated.";
} else {
    echo "Payment failed or was not successful.";
}
?>
