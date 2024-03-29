<?php
// company: PulseStream
// Developed by: Ngwang Shalom
// Location: Cameroon/Bamenda
// Languages: php/hack/javascript/node(library)
// position: Senior dev
//
//
// Please add your own description if you are a contributor
//
//
//

namespace App\API\Controllers;

class HomeController
{
    public static function index()
    {
        $message = "Welcome to Pulsestream!";

        // Animation frames
        $frames = [
            "⠋",
            "⠙",
            "⠹",
            "⠸",
            "⠼",
            "⠴",
            "⠦",
            "⠧",
            "⠇",
            "⠏"
        ];
        
        // Calculate the total animation duration in seconds
        $duration = 5;
        $frameRate = 10;
        $totalFrames = $duration * $frameRate;
        
        // Clear the console
        echo "\033[2J";
        
        // Loop through the framesf
        for ($i = 0; $i < $totalFrames; $i++) {
            // Get the current frame
            $frame = $frames[$i % count($frames)];
        
            // Clear the previous line
            echo "\033[F";
        
            // Display the welcome message with animation
            echo $frame . " " . $message;
        
            // Delay for a short duration
            usleep(1000000 / $frameRate);
        }
        
        // Add a new line after the animation completes
        echo PHP_EOL;
    }
}

