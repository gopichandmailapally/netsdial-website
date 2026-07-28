<?php
/**
 * NetsDial - Review Submission API
 */
define('NETSDIAL', true);
require_once dirname(__DIR__) . '/config/config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$name     = cleanInput($_POST['name'] ?? '');
$email    = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
$phone    = cleanInput($_POST['phone'] ?? '');
$location = cleanInput($_POST['location'] ?? '');
$service  = cleanInput($_POST['service'] ?? '');
$rating   = (int)($_POST['rating'] ?? 5);
$review   = cleanInput($_POST['review'] ?? '');

// Honeypot
if (!empty($_POST['website'])) {
    echo json_encode(['success' => true]);
    exit;
}

// Validation
if (empty($name)) { echo json_encode(['success' => false, 'message' => 'Name is required.']); exit; }
if (empty($review) || strlen($review) < 20) { echo json_encode(['success' => false, 'message' => 'Please write at least 20 characters in your review.']); exit; }
if ($rating < 1 || $rating > 5) { $rating = 5; }

// Sanitize rating
$rating = max(1, min(5, $rating));

try {
    db()->insert(
        "INSERT INTO reviews (customer_name, customer_email, customer_phone, customer_location, service_used, rating, review_text, is_approved) VALUES (?, ?, ?, ?, ?, ?, ?, 0)",
        [$name, $email, $phone, $location, $service, $rating, $review]
    );
    echo json_encode(['success' => true, 'message' => 'Thank you for your review! It will be visible after admin approval.']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error saving review. Please try again.']);
}
