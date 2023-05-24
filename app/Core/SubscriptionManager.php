
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
//
class SubscriptionManager {
    private $db;

    public function __construct() {
        // Initialize the database connection
        $this->db = new PDO("mysql:host=your_database_host;dbname=your_database_name", "your_username", "your_password");
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function createPayment($userId, $amount) {
        // Create a new payment record in the database
        $query = "INSERT INTO payments (user_id, amount, created_at) VALUES (:user_id, :amount, NOW())";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':amount', $amount);
        $stmt->execute();

        // Return the payment ID
        return $this->db->lastInsertId();
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
$paymentId = $subscriptionManager->createPayment(123, 50.00);

// Track payments per month
$paymentPerMonth = $subscriptionManager->trackPaymentsPerMonth();
print_r($paymentPerMonth);

// Send payment expiration notifications
$subscriptionManager->sendPaymentExpirationNotifications();

?>
