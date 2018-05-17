<?php

/**
 * @return array [fileName, content]
 */
function getDocuments() {
    $documentFolder = "../model/documents";

    $filesData = [];

    $files = array_diff(scandir($documentFolder), array('..', '.'));
    foreach($files as $file) {
        $filesData[$file] = file_get_contents($documentFolder . "/" . $file);
    }

    return $filesData;
}
