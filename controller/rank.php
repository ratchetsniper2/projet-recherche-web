<?php

require_once("../model/utils.php");
require_once("../model/pageRank.php");

$data = [];
$filesLinksData = getFilesLinksData();

$data["pageRank"] = pageRankScript($filesLinksData);
$data["hits"] = hitsScript($filesLinksData);

print(json_encode($data));
