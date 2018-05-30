<?php

require_once("../model/utils.php");
require_once("../model/pageRank.php");

$mode = $_GET["mode"] ? $_GET["mode"] : 0;

$data = [];
$filesLinksData = getFilesLinksData($mode);

$data["pageRank"] = pageRankScript($filesLinksData);
$data["hits"] = hitsScript($filesLinksData);

print(json_encode($data));
