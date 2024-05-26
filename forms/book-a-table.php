<?php
/**
 * Database Connection
 */

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vyumba_chap";

// Attempt to establish a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/**
 * Email Form Processing
 */

// Replace contact@example.com with your real receiving email address
$receiving_email_address = 'contact@example.com';

if (file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php')) {
    include($php_email_form);
} else {
    die('Unable to load the "PHP Email Form" Library!');
}

$book_a_table = new PHP_Email_Form;
$book_a_table->ajax = true;

$book_a_table->to = $receiving_email_address;
$book_a_table->from_name = $_POST['name'];
$book_a_table->from_email = $_POST['email'];
$book_a_table->subject = "New table booking request from the website";

// Uncomment below code if you want to use SMTP to send emails. You need to enter your correct SMTP credentials
/*
$book_a_table->smtp = array(
    'host' => 'example.com',
    'username' => 'example',
    'password' => 'pass',
    'port' => '587'
);
*/

$book_a_table->add_message($_POST['name'], 'Name');
$book_a_table->add_message($_POST['email'], 'Email');
$book_a_table->add_message($_POST['phone'], 'Phone', 4);
$book_a_table->add_message($_POST['date'], 'Date', 4);
$book_a_table->add_message($_POST['time'], 'Time', 4);
$book_a_table->add_message($_POST['people'], '# of people', 1);
$book_a_table->add_message($_POST['message'], 'Message');

// Send email
$email_sent = $book_a_table->send();

// Close the database connection
$conn->close();

// Output result of email sending
echo $email_sent;
?>
