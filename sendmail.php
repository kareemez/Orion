<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Decode JSON body
    $input = json_decode(file_get_contents("php://input"), true);

    // Safely extract fields
    $name    = isset($input["name"]) ? trim($input["name"]) : "";
    $email   = isset($input["email"]) ? trim($input["email"]) : "";
    $subject = isset($input["subject"]) ? trim($input["subject"]) : "";
    $message = isset($input["message"]) ? trim($input["message"]) : "";

    // Validate
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Please fill in all fields."]);
        exit;
    }

    $to = "info@orion-innovation.com";
    $body = "Name: $name\nEmail: $email\n\nSubject: $subject\n\nMessage:\n$message";

    $headers = "From: no-reply@orion-innovation.com\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send email
    if (mail($to, $subject, $body, $headers)) {
        echo json_encode(["status" => "success", "message" => "Your message has been sent successfully!"]);
    } else {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Sorry, there was a problem sending your message."]);
    }
} else {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>
