<?php

function zip_current_folder($zipFileName = 'archive.zip')
{
    $zip = new ZipArchive();

    if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
        // Get all files in the current directory
        $files = glob('*');

        // Add each file to the zip
        foreach ($files as $file) {
            if (is_file($file) && $file != $zipFileName) {
                $zip->addFile($file, $file);
            }
        }

        $zip->close();
        echo "ZIP file created successfully!";
    } else {
        echo "Failed to create ZIP file.";
    }
}

zip_current_folder('callus-widget.zip'); // Run the function
