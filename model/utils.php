<?php

/**
 * @return array [fileName, [linkFileName, linkFileName]]
 */
function getFilesLinksData() {
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

/**
 * @param $filesLinksData array
 *
 * @return array
 */
function pageRankScript($filesLinksData) {
    return [];
}

/**
 * @param $filesLinksData array
 *
 * @return array
 */
function hitsScript($filesLinksData) {
    return [];
}
