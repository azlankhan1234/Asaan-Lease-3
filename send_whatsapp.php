<?php
header("Content-Type: application/json");

// Replace with your permanent token & phone number ID
$access_token = "YOUR_PERMANENT_ACCESS_TOKEN";
$phone_number_id = "853988167787979";
$admin_number = "923487481301"; // Your WhatsApp number

// Get posted data
$data = json_decode(file_get_contents("php://input"), true);

$name = $data['fullname'] ?? '';
$father = $data['fatherName'] ?? '';
$cnic = $data['cnic'] ?? '';
$dob = $data['dob'] ?? '';
$phone = $data['phone'] ?? '';
$address = $data['address'] ?? '';
$make = $data['make'] ?? '';
$model = $data['model'] ?? '';
$variant = $data['variant'] ?? '';
$storage = $data['storage'] ?? '';

// Create WhatsApp message
$message = "
📋 New Lease Application
👤 Name: $name
👨‍👩 Father/Husband: $father
🆔 CNIC: $cnic
📅 DOB: $dob
📞 Phone: $phone
🏠 Address: $address

📱 Phone Requested:
Make: $make
Model: $model
Variant: $variant
Storage: $storage
";

// WhatsApp API endpoint
$url = "https://graph.facebook.com/v17.0/$phone_number_id/messages";
$payload = json_encode([
    "messaging_product" => "whatsapp",
    "to" => $admin_number,
    "type" => "text",
    "text" => ["body" => $message]
]);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $access_token",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

echo $response;
?>
