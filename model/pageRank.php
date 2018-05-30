<?php

const COEF = 0.85;
const BASE_SCORE = 1;

/**
 * Point d'entrée du PageRank
 * Prend en entrée le modèle de données qui décrit les liens entre les pages
 *
 * @param $filesLinksData array modèle de données qui décrit les liens entre les pages
 * @return array les scores du PageRank
 */
function pageRankScript($filesLinksData) {
    $ranking = [];
    foreach ($filesLinksData as $page => $links) {
        $ranking[$page]['score'] = BASE_SCORE;
    }
    for ($i = 0; $i < 10; $i++) {
        $ranking = pageRankScore($filesLinksData, $ranking);
    }
    uasort($ranking, function ($a, $b) {
        if ($a == $b) {
            return 0;
        }
        return ($a < $b) ? 1 : -1;
    });
    return $ranking;
}

/**
 * Calcule le PageRank d'un ensemble de pages
 *
 * @param $filesLinksData array modèle de données qui décrit les liens entre les pages
 * @param $ranking array Les scores actuels du PageRank
 * @return array Les nouveaux scores du PageRank
 */
function pageRankScore($filesLinksData, $ranking) {
    foreach ($ranking as $page => $score) {
        $ranking[$page]['score'] = calculateScore($page, $filesLinksData, $ranking);
    }
    return $ranking;
}

/**
 * Calcule le PageRank d'une page données
 *
 * @param $pageRank string la page dont on doit calculer le PageRank
 * @param $filesLinksData array modèle de données qui décrit les liens entre les pages
 * @param $ranking array Les scores actuels du PageRank
 * @return float|int le score calculé
 */
function calculateScore($pageRank, $filesLinksData, $ranking) {
    $sum = 0;
    foreach ($filesLinksData[$pageRank]['linkedFrom'] as $page) {
        $sum += ($ranking[$page]['score'] / count($filesLinksData[$page]['linkTo']));
    }
    return (1 - COEF) + COEF * $sum;
}