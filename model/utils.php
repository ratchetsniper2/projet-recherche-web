<?php


/**
 * @return array [pageName => ["linkTo" => [], "linkedFrom" => []]]
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
    $result = [];

    foreach ($filesLinksData as $pageName => $data) {
        $result[$pageName]["authority"] = 1;
        $result[$pageName]["hub"] = 1;
    }

    for ($i = 0 ; $i < 5 ; $i++) {
        // update autority
        $norm = 0;
        foreach ($filesLinksData as $pageName => $data) {
            $authority = 0;

            foreach ($data["linkedFrom"] as $linkedFromPageName) {
                $authority += $result[$linkedFromPageName]["hub"];
            }

            $result[$pageName]["authority"] = $authority;
            $norm += $authority**2;
        }

        $norm = $norm ? sqrt($norm) : 1;

        foreach ($filesLinksData as $pageName => $data) {
            $result[$pageName]["autorhity"] = $result[$pageName]["authority"] / $norm;
        }

        // update hub
        $norm = 0;
        foreach ($filesLinksData as $pageName => $data) {
            $hub = 0;

            foreach ($data["linkTo"] as $linkToPageName) {
                $hub += $result[$linkToPageName]["authority"];
            }

            $result[$pageName]["hub"] = $hub;
            $norm += $hub**2;
        }

        $norm = $norm ? sqrt($norm) : 1;

        foreach ($filesLinksData as $pageName => $data) {
            $result[$pageName]["hub"] = $result[$pageName]["hub"] / $norm;
        }
    }

    uasort($result, function ($a, $b) {
        if ($a == $b) {
            return 0;
        }
        return ($a["authority"] < $b["authority"]) ? 1 : -1;
    });

    return $result;
}
