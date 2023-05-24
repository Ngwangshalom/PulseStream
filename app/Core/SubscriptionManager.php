<?php
// company: PulseStream
// Developed by: Ngwang Shalom
// Location: Cameroon/Bamenda
// Languages: php/hack/javascript/node(library)
// position: Senior dev
//
//
// Please add your own description if you are a contributor
//
//

require 'vendor/autoload.php';

use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class SubscriptionManager {
    private $db;
    private $apiContext;

    public function __construct() {
        // Initialize the database connection
        $this->db = new PDO("mysql:host=localhost;dbname=your_database_name", "your_username", "your_password");
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Initialize the PayPal API context
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                'YOUR_CLIENT_ID',
                'YOUR_CLIENT_SECRET'
            )
        );
    }

    public function createPayment($userId, $amount) {
        // Create a new PayPal payment
        $payment = new Payment();
        $payment->setIntent('sale');

        // Set the payer details
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $payment->setPayer($payer);

        // Set the transaction details
        $transaction = new Transaction();
        $amountObject = new Amount();
        $amountObject->setCurrency('USD');
        $amountObject->setTotal($amount);
        $transaction->setAmount($amountObject);
        $payment->setTransactions([$transaction]);

        // Set the redirect URLs
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl('http://localhost/success');
        $redirectUrls->setCancelUrl('http://localhost/cancel');
        $payment->setRedirectUrls($redirectUrls);

        // Create the payment using the PayPal API
        try {
            $payment->create($this->apiContext);

            // Store the payment information in the database
            $query = "INSERT INTO payments (user_id, amount, payment_id, created_at) VALUES (:user_id, :amount, :payment_id, NOW())";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':amount', $amount);
            $stmt->bindParam(':payment_id', $payment->getId());
            $stmt->execute();

            // Return the PayPal approval URL
            return $payment->getApprovalLink();
        } catch (Exception $e) {
            // Handle any errors that occurred during payment creation
            return null;
        }
    }

    public function trackPaymentsPerMonth() {
        // Get the total payments per month for the current year
        $query = "SELECT MONTH(created_at) as month, SUM(amount) as total_amount FROM payments WHERE YEAR(created_at) = YEAR(CURDATE()) GROUP BY MONTH(created_at)";
        $stmt = $this->db->query($query);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return the payment per month data
        return $results;
    }

    public function sendPaymentExpirationNotifications() {
        // Get the users whose payment has expired
        $query = "SELECT u.email FROM users u LEFT JOIN payments p ON u.id = p.user_id WHERE p.created_at < DATE_SUB(NOW(), INTERVAL 1 YEAR) OR p.id IS NULL";
        $stmt = $this->db->query($query);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Send notification emails to the users
        foreach ($results as $row) {
            $email = $row['email'];
            // Send the email notification to $email
            // ...
        }
    }
}

// Usage example:
$subscriptionManager = new SubscriptionManager();

// Create a payment for a user
$approvalUrl = $subscriptionManager->createPayment(123, 50.00);

// Redirect the user to the PayPal approval URL
if ($approvalUrl) {
    header("Location: $approvalUrl");
} else {
    echo "Error creating PayPal payment.";
}

// Track payments per month
$paymentPerMonth = $subscriptionManager->trackPaymentsPerMonth();
print_r($paymentPerMonth);

// Send payment expiration notifications
$subscriptionManager->sendPaymentExpirationNotifications();

?>
