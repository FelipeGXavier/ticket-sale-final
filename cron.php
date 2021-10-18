<?php

use App\Datasource;
use App\Model\EmailTrackingModel;
use SendGrid\Mail\Mail;

require('./vendor/autoload.php');

define('API_KEY', '');

$datasource = new Datasource();
$trackingModel = new EmailTrackingModel($datasource);
$userReminders = $trackingModel->getUsersReminders();

foreach ($userReminders as $userReminder) {
    $emailBody = file_get_contents("./template/email.html");
    $emailBody = str_replace('#{USER_NAME}', $userReminder['name'], $emailBody);
    $content = "Gostaria de avisar que o evento <b>" . strtoupper($userReminder['title']) . "</b> está próximo de começar!";
    $emailBody = str_replace('#{BODY}', $content, $emailBody);
    $email = new Mail();
    $email->setFrom("felipexavier20015@gmail.com", "Example User");
    $email->setSubject("Sending with Twilio SendGrid is Fun");
    $email->addTo($userReminder['email'], "Example User");
    $email->addContent(
        "text/html", $emailBody
    );
    $sendgrid = new \SendGrid(API_KEY);
    $logResponse = ['status_code' => 0, 'headers' => '', 'body' => '', 'exception' => ''];
    try {
        $response = $sendgrid->send($email);
        $logResponse['status_code'] = $response->statusCode();
        $logResponse['headers'] = json_encode($response->headers());
        $logResponse['body'] = $response->body();
    } catch (Exception $e) {
        $logResponse['exception'] = $e->getMessage();
    }
    $trackingModel->saveTrackingLog(array_values($logResponse));
}


