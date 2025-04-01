<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AssetEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $filePaths; // Store file paths for attachment

    public function __construct(array $filePaths)
    {
        $this->filePaths = $filePaths;
    }

    public function build()
    {
        $email = $this->subject('Your Selected Assets')
                      ->view('emails.asset-email'); // Pass assets to view

        // Attach multiple files
        foreach ($this->filePaths as $filePath) {
            if (file_exists($filePath)) {
                $email->attach($filePath, [
                    'as' => basename($filePath), // Use the original file name
                ]);
            }
        }

        return $email;
    }
}