<?php


/**
 * @param $mode int (0 : page / 1 : graphe)
 *
 * @return array [pageName => ["linkTo" => [], "linkedFrom" => []]]
 */
function getFilesLinksData($mode) {
    $filesLink = [];

    if ($mode) {
        $lines = explode("\n", file_get_contents("../model/documents2/data.txt"));
        $nodesNames = [];
        $nodesLinksTemp = [];
        foreach ($lines as $line) {
            $data = explode(" ", $line);

            if ($data[0] === "n") {
                $nodesNames[$data[1]] = $data[2];

                $filesLink[$data[2]]["linkTo"] = [];
                $filesLink[$data[2]]["linkedFrom"] = [];
            } elseif ($data[0] === "e") {
                $nodesLinksTemp[$data[1]] = $data[2];
            }
        }

        foreach ($nodesLinksTemp as $pageNodeNum => $linkNodeNum) {
            if (array_key_exists($pageNodeNum, $nodesNames) && array_key_exists($linkNodeNum, $nodesNames)) {
                $pageName = $nodesNames[$pageNodeNum];
                $linkName = $nodesNames[$linkNodeNum];

                $filesLink[$pageName]["linkTo"][] = $linkName;
                $filesLink[$linkName]["linkedFrom"][] = $pageName;
            }
        }

    } else {
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
