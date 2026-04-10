<?php
require_once 'app/config/config.php';
require_once 'app/libraries/Database.php';

$db = new Database();
$db->query("SELECT * FROM disease_reports WHERE status = 'under_review' LIMIT 1");
$row = $db->single();
print_r($row);
