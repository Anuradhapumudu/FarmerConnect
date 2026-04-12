<?php
/**
 * GitHub Webhook Handler for Auto-Update
 * FarmerConnect Deployment Script
 */

// Your custom secret (set this in GitHub Webhook settings)
$secret = 'farmerconnect_secure_update_2026';

// The path to your repository on the server
$path = '/var/www/farmerconnect';

// Log file for verification
$logFile = $path . '/webhook.log';

function logMessage($msg) {
    global $logFile;
    file_put_contents($logFile, date('Y-m-d H:i:s') . ' - ' . $msg . PHP_EOL, FILE_APPEND);
}

// 1. Verify Request Signature (Security)
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';
if (!$signature) {
    logMessage("Error: Missing signature header");
    http_response_code(403);
    die('Forbidden');
}

$payload = file_get_contents('php://input');
$expectedSignature = 'sha256=' . hash_hmac('sha256', $payload, $secret);

if (!hash_equals($expectedSignature, $signature)) {
    logMessage("Error: Invalid signature. Expected: $expectedSignature, Got: $signature");
    http_response_code(403);
    die('Forbidden');
}

// 2. Process the Payload
$data = json_decode($payload, true);
if ($data && ($data['ref'] ?? '') === 'refs/heads/main') {
    logMessage("Received push to main. Starting git pull...");
    
    // 3. Execute Git Pull
    $output = [];
    $exitCode = 0;
    
    // We use -C to change directory and run git
    exec("cd $path && git fetch --all && git reset --hard origin/main 2>&1", $output, $exitCode);
    
    if ($exitCode === 0) {
        logMessage("SUCCESS: " . implode("\n", $output));
        echo "OK - Updated";
    } else {
        logMessage("FAILURE: " . implode("\n", $output));
        http_response_code(500);
        echo "Error: Pull failed";
    }
} else {
    logMessage("Ignored: Push to branch " . ($data['ref'] ?? 'unknown'));
    echo "OK - Ignored";
}
