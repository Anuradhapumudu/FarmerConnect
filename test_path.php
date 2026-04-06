<?php 
echo "APPROOT: " . dirname(__FILE__) . "/app<br>";
echo "DOCUMENT_ROOT: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Proposed Path: " . $_SERVER['DOCUMENT_ROOT'] . "/FarmerConnect/public/uploads/officer_responses/<br>";
echo "Real Path (via __FILE__): " . dirname(__FILE__) . "/public/uploads/officer_responses/<br>";
?>
