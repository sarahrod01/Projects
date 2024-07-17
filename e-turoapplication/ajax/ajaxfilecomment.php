<?php
// PHP script to read file content and return it as response

if (isset($_GET['filePath'])) {
    $file_path = $_GET['filePath'];
    
    if (file_exists($file_path)) {
        $file_content = file_get_contents($file_path);
        echo htmlspecialchars($file_content);
    } else {
        echo 'File not found.';
    }
} else {
    echo 'Invalid file path.';
}
?>
