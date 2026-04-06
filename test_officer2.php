<?php
require_once 'app/config/config.php';
require_once 'app/libraries/Database.php';
require_once 'app/models/M_disease.php';

$model = new M_disease();
$res = $model->submitOfficerResponse('DR013', 'O0003', 'Test message', null);
echo "Result: " . ($res ? 'success' : 'failed');
