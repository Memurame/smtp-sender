<?php

return [
    'sender' => [
        'smtp1@mail.ch' => [
            'host' => 'host',
            'port' => 587,
            'secure' => 'tls',
            'user' => '[USER]',
            'pass' => '[PASS]'],
        'smtp2@mail.ch' => [
            'host' => 'host',
            'port' => 587,
            'secure' => 'tls',
            'user' => '[USER]',
            'pass' => '[PASS]']
        ],
        'limit' => 100, // Send limit per run
        'delay' => 0 // Delay in seconds between sending the mails
    
];