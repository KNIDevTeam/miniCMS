<?php
    $pagePath = 'testFile.json';
    $json = file_get_contents('php://input');

    file_put_contents($pagePath, $json);

    echo "hello world";
