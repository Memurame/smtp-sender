<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$config = require_once('config.php');

$directory_queue = 'mail/queue/';
$directory_done = 'mail/done/';
$directory_failed = 'mail/failed/';
$scanned_directory = array_diff(scandir($directory_queue), array('..', '.', 'index.html'));

$i = 0;
foreach($scanned_directory as $file){

    if($i >= $config['limit']) return;
    $i++;

    if($config['delay'] > 0 && $i > 1){
        sleep($config['delay']);
    }
    
    $json = json_decode(file_get_contents($directory_queue . $file), true);
    $time = time();

    $PHPMailer = new PHPMailer(true);
    
    try {
        //$PHPMailer->SMTPDebug = SMTP::DEBUG_SERVER;
        $PHPMailer->isSMTP();
        $PHPMailer->Host       = $config['sender'][$json['from']]['host'];
        $PHPMailer->SMTPAuth   = true;
        $PHPMailer->Username   = $config['sender'][$json['from']]['user'];
        $PHPMailer->Password   = $config['sender'][$json['from']]['pass'];
        $PHPMailer->SMTPSecure = $config['sender'][$json['from']]['secure'];
        $PHPMailer->Port       = $config['sender'][$json['from']]['port'];
    
        //Recipients
        $PHPMailer->setFrom($json['from'], $json['from']);
        $PHPMailer->addAddress($json['to']);
        $PHPMailer->addReplyTo($json['reply_to'], $json['reply_to']);
    
        //Content
        $PHPMailer->isHTML(true);
        $PHPMailer->Subject = $json['subject'];
        $PHPMailer->Body    = $json['text'];
    
        $PHPMailer->send();

        file_put_contents($directory_done . $json['to'] . '_' . $time .'.json', json_encode($json));
    } catch (Exception $e) {
        file_put_contents($directory_failed . $json['to'] . '_' . $time .'.json', json_encode($json));
    }
            
    unlink($directory_queue . $file);


}