<?php

const COEF = 0.85;
const BASE_SCORE = 1;

/**
 * @param $filesLinksData array
 *
 * @return array
 */
function pageRankScript($filesLinksData) {
    $ranking = [];
    foreach ($filesLinksData as $page => $links) {
        $ranking[$page]['score'] = BASE_SCORE;
    }
    for ($i = 0; $i < 100; $i++) {
        pageRankScriptWorker($filesLinksData, $ranking);
    }
    return $filesLinksData;
}

function pageRankScriptWorker($filesLinksData, $ranking) {
    foreach ($ranking as $page => $score) {
        $ranking[$page]['score'] = calculateScore($page, $filesLinksData, $ranking);
    }
}

function calculateScore($page, $filesLinksData, $ranking) {
    $outLinkNumber = count($filesLinksData[$page]['linkTo']);
    $sum = 0;
    foreach ($filesLinksData as $page => $links) {
        if (in_array($page, $links['linkedFrom'])) {
            $sum += ($ranking[$page] / $outLinkNumber);
        }
    }
    return (1 - COEF) + COEF * $sum;
}