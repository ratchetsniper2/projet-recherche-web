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
    for ($i = 0; $i < 10; $i++) {
        $ranking = pageRankScriptWorker($filesLinksData, $ranking);
    }
    uasort($ranking, function ($a, $b) {
        if ($a == $b) {
            return 0;
        }
        return ($a < $b) ? 1 : -1;
    });
    return $ranking;
}

function pageRankScriptWorker($filesLinksData, $ranking) {
    foreach ($ranking as $page => $score) {
        $ranking[$page]['score'] = calculateScore($page, $filesLinksData, $ranking);
    }
    return $ranking;
}

function calculateScore($pageRank, $filesLinksData, $ranking) {
    $sum = 0;
    foreach ($filesLinksData[$pageRank]['linkedFrom'] as $page) {
        $sum += ($ranking[$page]['score'] / count($filesLinksData[$page]['linkTo']));
    }
    return (1 - COEF) + COEF * $sum;
}