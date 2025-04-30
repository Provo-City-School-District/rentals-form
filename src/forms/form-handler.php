<?php
function create_work_order(string $subject, string $desc, int $location_code, array $attachments = [])
{
    $help_host = $_ENV["HELP_HOST"];
    $url = "$help_host/api/v1/create_ticket.php";
    $api_key = $_ENV["HELP_API_KEY"];
    $data = [
        'ticket_title' => $subject,
        'ticket_description' => $desc,
        'ticket_location' => $location_code,
        'ticket_department' => 1700 // tech dept
    ];

    // Add attachments to the data
    foreach ($attachments as $index => $attachment) {
        $data["attachment[$index]"] = $attachment;
    }

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    //curl_setopt($ch, CURLOPT_PROXY_SSL_VERIFYPEER, false);

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: $api_key",
        "Content-Type: multipart/form-data"
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_VERBOSE, true);

    $response = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($http_status != 200) {
        return null;
    }
    curl_close($ch);

    $response_data = json_decode($response, true);
    return $response_data["ticket_id"];
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $user_ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown IP';
    // Honeypot Validation
    if (!empty($_POST['any_additional_info'])) {
        error_log("Honeypot field was filled out. Possible spam attempt detected. IP: $user_ip");
        die("Spam detected. Submission rejected.");
    }

    // CSRF Token Validation
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        error_log("CSRF token mismatch. Possible CSRF attack detected. IP: $user_ip");
        die("Invalid CSRF token. Submission rejected.");
    }

    $event_name = htmlspecialchars(trim($_POST['event_name']));
    $rate_group = htmlspecialchars(trim($_POST['rate_group']));
    $nonprofit = htmlspecialchars(trim($_POST['nonprofit']));
    $commercial = htmlspecialchars(trim($_POST['commercial']));
    $responsible_party = htmlspecialchars(trim($_POST['responsible_party']));
    $organization = htmlspecialchars(trim($_POST['organization']));
    $primary_contact = htmlspecialchars(trim($_POST['primary_contact']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $description = htmlspecialchars(trim($_POST['description']));
    $location_request = htmlspecialchars(trim($_POST['location_request']));
    $space_request = isset($_POST['space_request']) ? htmlspecialchars(trim($_POST['space_request'])) : null;
    $date = htmlspecialchars(trim($_POST['date']));
    $setup_start_time = htmlspecialchars(trim($_POST['setup_start_time']));
    $event_start_time = htmlspecialchars(trim($_POST['event_start_time']));
    $event_end_time = htmlspecialchars(trim($_POST['event_end_time']));
    $cleanup_end_time = htmlspecialchars(trim($_POST['cleanup_end_time']));
    $number_of_people = filter_var(trim($_POST['number_of_people']), FILTER_SANITIZE_NUMBER_INT);
    $tickets = isset($_POST['tickets']) && $_POST['tickets'] === 'yes' ? 'Yes' : 'No';
    $audio_visual_needs = isset($_POST['audio_visual_needs']) ? htmlspecialchars(implode(", ", array_map('trim', $_POST['audio_visual_needs']))) : 'None';

    // Handle file attachments
    $attachments = [];
    if (isset($_FILES['nonprofit_document']) && $_FILES['nonprofit_document']['error'] === UPLOAD_ERR_OK) {
        $attachments[] = new CURLFile($_FILES['nonprofit_document']['tmp_name'], $_FILES['nonprofit_document']['type'], $_FILES['nonprofit_document']['name']);
    }

    $subject = "Facility Rental Request: $event_name";
    $desc = nl2br(htmlspecialchars(
        "Event Details:\n\n" .
            "Rate Group: $rate_group\n" .
            "Nonprofit: $nonprofit\n" .
            "Commercial: $commercial\n" .
            "Responsible Party: $responsible_party\n" .
            "Organization: $organization\n" .
            "Primary Contact: $primary_contact\n" .
            "Phone: $phone\n" .
            "Email: $email\n\n" .
            "Description: $description\n\n" .
            "Location: $location_request\n" .
            "Space: $space_request\n" .
            "Date: $date\n" .
            "Setup Start Time: $setup_start_time\n" .
            "Event Start Time: $event_start_time\n" .
            "Event End Time: $event_end_time\n" .
            "Cleanup End Time: $cleanup_end_time\n" .
            "Number of People: $number_of_people\n" .
            "Tickets Sold: $tickets\n" .
            "Audio/Visual Needs: $audio_visual_needs"
    ));

    $ticket_id = create_work_order($subject, $desc, (int)$location_request, $attachments);

    if ($ticket_id) {
        error_log("Request submitted successfully. Ticket ID: $ticket_id. User IP: $user_ip");
        echo "<p>Thank you! Your request has been submitted successfully. Your ticket ID is: $ticket_id</p>";
        exit;
    } else {
        error_log("Error submitting request. User IP: $user_ip");
        echo "<p>Sorry, there was an error submitting your request. Please try again later.</p>";
        exit;
    }
}
