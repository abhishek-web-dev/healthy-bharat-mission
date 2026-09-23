<?php
$data = json_decode(file_get_contents('php://input'), true);
file_put_contents('js_error.log', print_r($data, true) . "\n", FILE_APPEND);
