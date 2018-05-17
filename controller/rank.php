<?php

require_once("../model/utils.php");

$data = [];
$filesLinksData = getFilesLinksData();

$data["pageRank"] = pageRankScript($filesLinksData);
$data["hits"] = hitsScript($filesLinksData);

print(json_encode($data));
