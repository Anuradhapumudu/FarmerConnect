<?php
// Direct test of media serving - bypass MVC
$testFile = __DIR__ . '/public/uploads/disease_reports/DR013_close-up-of-raindrops-on-leave_1775414818_0.jpg';
$testFile2 = __DIR__ . '/public/uploads/officer_responses/DR013_officer_O0001_close-up-of-raindrops-on-leave_1775415920_0.jpg';

$mode = isset($_GET['mode']) ? $_GET['mode'] : 'info';

if ($mode === 'info') {
    header('Content-Type: text/html');
    echo "<h2>Media Debug</h2>";
    echo "<h3>Disease Report File</h3>";
    echo "Path: " . $testFile . "<br>";
    echo "Exists: " . (file_exists($testFile) ? 'YES' : 'NO') . "<br>";
    echo "Size: " . (file_exists($testFile) ? filesize($testFile) : 'N/A') . "<br>";
    echo "Readable: " . (is_readable($testFile) ? 'YES' : 'NO') . "<br>";
    
    echo "<h3>Officer Response File</h3>";
    echo "Path: " . $testFile2 . "<br>";
    echo "Exists: " . (file_exists($testFile2) ? 'YES' : 'NO') . "<br>";
    echo "Size: " . (file_exists($testFile2) ? filesize($testFile2) : 'N/A') . "<br>";
    echo "Readable: " . (is_readable($testFile2) ? 'YES' : 'NO') . "<br>";
    
    echo "<h3>Direct Serve Tests</h3>";
    echo '<p><a href="?mode=serve&type=disease">Serve Disease Report Image</a></p>';
    echo '<p><a href="?mode=serve&type=officer">Serve Officer Response Image</a></p>';
    echo '<p><img src="?mode=serve&type=disease" style="max-width:300px" alt="disease test"></p>';
    echo '<p><img src="?mode=serve&type=officer" style="max-width:300px" alt="officer test"></p>';
    
    // Check output buffering status
    echo "<h3>Output Buffering</h3>";
    echo "ob_get_level: " . ob_get_level() . "<br>";
    echo "ob_get_length: " . ob_get_length() . "<br>";
    
} elseif ($mode === 'serve') {
    $type = isset($_GET['type']) ? $_GET['type'] : 'disease';
    $file = ($type === 'officer') ? $testFile2 : $testFile;
    
    if (file_exists($file)) {
        // Clean any output buffers
        while (ob_get_level()) {
            ob_end_clean();
        }
        
        header('Content-Type: image/jpeg');
        header('Content-Length: ' . filesize($file));
        header('Content-Disposition: inline; filename="' . basename($file) . '"');
        readfile($file);
        exit();
    } else {
        echo "File not found: $file";
    }
}
