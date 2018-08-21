<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],
		
		// Database connection settings
        "db" => [
            "host" => "localhost",
            "dbname" => "slim",
            "user" => "root",
            "pass" => "root"
        ],
    ],
];