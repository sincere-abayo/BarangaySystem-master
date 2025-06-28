<?php
// Simple debug script to check POST data
echo "<h2>Debug: POST Data Received</h2>";
echo "<pre>";
echo "POST data:\n";
print_r($_POST);
echo "\n\nGET data:\n";
print_r($_GET);
echo "\n\nRequest method: " . $_SERVER['REQUEST_METHOD'];
echo "</pre>";
?>