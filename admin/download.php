<?php
// Check if the file parameter is set
if (isset($_GET['file'])) {
    // Get the file name from the parameter
    $file_name = basename($_GET['file']);

    // Set the file path
    $file_path = 'uploads/' . $file_name;

    // Check if the file exists
    if (file_exists($file_path)) {
        // Set the headers for the file download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));
        readfile($file_path);
        exit;
    } else {
        // File not found
        echo 'File not found.';
    }
} else {
    // File parameter not set
    echo 'File parameter not set.';
}
?>
