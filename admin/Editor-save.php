<?php
require_once  __DIR__ . "/classes/Editor.php";
$requestType = $_SERVER['REQUEST_METHOD'];
switch ($requestType) {
    case 'POST':
        session_start();
        $pageEditor = $_SESSION['pageEditorHandle'];
        $pageContent = file_get_contents('php://input');
        $pagePath = $pageEditor->getPath();
        $pageEditor->saveFile($pagePath, $pageContent);
        echo "POST-saving was successful";
        break;
}
    //$pagePath = 'testFile.json';
    //$json = file_get_contents('php://input');
    //file_put_contents($pagePath, $json);


