<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute([':id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <script src="https://checkout.flutterwave.com/v3.js"></script>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($user['email']); ?></h2>
    <p>Total Investments: <?php echo $user['total_investments']; ?></p>
    <button onclick="makePayment()">Invest Now</button>

    <script>
        function makePayment() {
            FlutterwaveCheckout({
                public_key: "FLWPUBK-cccb06067243941e893e48c6aaa11612-X",
                tx_ref: "investmentTx-" + new Date().getTime(),
                amount: 1000,
                currency: "UGX",
                payment_options: "card, ussd, mobilemoneyuganda, banktransfer",
                redirect_url: "http://localhost/your_project/payment-callback.php",
                customer: {
                    email: "<?php echo htmlspecialchars($user['email']); ?>",
                    phonenumber: "+256123456789",
                    name: "<?php echo htmlspecialchars($user['email']); ?>"
                },
                customizations: {
                    title: "Invest with Us",
                    description: "Investment Payment",
                }
            });
        }
    </script>
</body>
</html>
