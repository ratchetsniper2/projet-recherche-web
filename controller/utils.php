<?php

/**
 * @return array [fileName, [fileName, fileName]]
 */
function getDocuments() {
    $documentFolder = "../model/documents";

    $filesLink = [];

    $files = array_diff(scandir($documentFolder), array('..', '.'));
    foreach($files as $file) {
        $content = file_get_contents($documentFolder . "/" . $file);

        preg_match_all('~<a(.*?)href="([^"]+)"(.*?)>~', $content, $matches);
        $filesLink[$file] = array_diff($matches[2], array($file));
    }

    return $filesLink;
}
