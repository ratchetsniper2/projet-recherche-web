<?php


/**
 * @return array ["linkTo" => [], "linkedFrom" => []]
 */
function getFilesLinksData() {
    $documentFolder = "../model/documents";

    $files = array_diff(scandir($documentFolder), array('..', '.'));

    foreach($files as $file) {
        $filesLink[$file]["linkTo"] = [];
        $filesLink[$file]["linkedFrom"] = [];
    }

    foreach($files as $file) {
        $content = file_get_contents($documentFolder . "/" . $file);

        preg_match_all('~<a(.*?)href="([^"]+)"(.*?)>~', $content, $matches);

        foreach ($matches[2] as $linkFile) {
            if ($linkFile !== $file) {
                if (!in_array($linkFile, $filesLink[$file]["linkTo"])) {
                    $filesLink[$file]["linkTo"][] = $linkFile;
                }

                if (!in_array($file, $filesLink[$linkFile]["linkedFrom"])) {
                    $filesLink[$linkFile]["linkedFrom"][] = $file;
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
    return $filesLinksData;
}
