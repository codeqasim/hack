<?php
// Path to the CSV file
$file_path = 'bulk_emails.csv';

// Function to read the CSV file into an array
function read_csv($file_path) {
    $emails = [];
    if (($handle = fopen($file_path, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $emails[] = $data;
        }
        fclose($handle);
    }
    return $emails;
}

// Function to write the array back to the CSV file
function write_csv($file_path, $emails) {
    if (($handle = fopen($file_path, 'w')) !== FALSE) {
        foreach ($emails as $email) {
            fputcsv($handle, $email);
        }
        fclose($handle);
    }
}

// Read the CSV file into an array of emails with statuses
$emails = read_csv($file_path);

// Initialize variables
$found = false;

foreach ($emails as &$email) {
    if ($email[1] == '0' && !$found) {
        // Send the email
        $to = $email[0];
        $subject = "Your Subject Here";
        $htmlContent = "
        <html>
        <head>
            <title>Your Email Title</title>
        </head>
        <body>
            <p>Hello,</p>
            <p>This is a sample email message sent using a PHP script.</p>
            <p>Best regards,<br>Your Name</p>
        </body>
        </html>";
        $plainTextContent = "Hello,\n\nThis is a sample email message sent using a PHP script.\n\nBest regards,\nYour Name";

        $boundary = md5(uniqid(time()));

        // Headers
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/alternative; boundary=\"{$boundary}\"\r\n";
        $headers .= "From: Zahid <info@https://etravelplus.com>\r\n";
        $headers .= "Reply-To: info@https://etravelplus.com\r\n";
        
        // Message
        $message = "--{$boundary}\r\n";
        $message .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $message .= "Content-Transfer-Encoding: 7bit\r\n";
        $message .= "\r\n";
        $message .= $plainTextContent;
        $message .= "\r\n\r\n--{$boundary}\r\n";
        $message .= "Content-Type: text/html; charset=UTF-8\r\n";
        $message .= "Content-Transfer-Encoding: 7bit\r\n";
        $message .= "\r\n";
        $message .= $htmlContent;
        $message .= "\r\n\r\n--{$boundary}--";

        if (mail($to, $subject, $message, $headers)) {
            echo "Email sent to $to<br>";
            $email[1] = '1';
            $found = true;
        } else {
            echo "Failed to send email to $to<br>";
        }
    }
}

// Write the updated array back to the CSV file
write_csv($file_path, $emails);

if ($found) {
    // Wait for 5 seconds before refreshing the page
    sleep(5);

    // Refresh the page
    echo '<script>setTimeout(function(){ window.location.reload(); }, 0);</script>';
} else {
    echo "All emails have been sent!";
}
?>
