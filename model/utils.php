<?php


/**
 * @return array ["linkTo" => [], "linkedFrom" => []]
 */
function getFilesLinksData() {
    $documentFolder = "../model/documents";

    $filesLink["linkTo"] = [];
    $filesLink["linkedFrom"] = [];

    $files = array_diff(scandir($documentFolder), array('..', '.'));

    foreach($files as $file) {
        $filesLink["linkTo"][$file] = [];
        $filesLink["linkedFrom"][$file] = [];
    }

    foreach($files as $file) {
        $content = file_get_contents($documentFolder . "/" . $file);

        preg_match_all('~<a(.*?)href="([^"]+)"(.*?)>~', $content, $matches);

        foreach ($matches[2] as $linkFile) {
            if ($linkFile !== $file) {
                if (array_search($linkFile, $filesLink["linkTo"][$file]) === false) {
                    $filesLink["linkTo"][$file][] = $linkFile;
                }

                if (array_search($file, $filesLink["linkedFrom"][$linkFile]) === false) {
                    $filesLink["linkedFrom"][$linkFile][] = $file;
                }
            }
        }
    }

    return $filesLink;
}

/**
 * @param $filesLinksData array
 *
 * @return array
 */
function hitsScript($filesLinksData) {
    return [];
}
