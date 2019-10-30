<?php

/* Exibir erros */
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

require 'functions.php';

if (file_exists('../inc/config.php')) {
    include '../inc/config.php';
}

if (file_exists('../elasticfind/elasticfind.php')) {
    include '../elasticfind/elasticfind.php';
}

//print("<pre>".print_r($_REQUEST, true)."</pre>");

$body["doc"]["name"] = $_REQUEST["name"];
$body["doc"]["alternateName"] = $_REQUEST["alternateName"];
$body["doc"]["doi"] = $_REQUEST["doi"];
$body["doc"]["datePublished"] = $_REQUEST["datePublished"];
$body["doc"]["isPartOf"]["name"] = $_REQUEST["isPartOf_name"];
$body["doc"]["isPartOf"]["ISSN"] = $_REQUEST["isPartOf_ISSN"];
$body["doc"]["isPartOf"]["volume"] = $_REQUEST["isPartOf_volume"];
$body["doc"]["isPartOf"]["issue"] = $_REQUEST["isPartOf_issue"];
$body["doc"]["isPartOf"]["pageStart"] = $_REQUEST["isPartOf_pageStart"];
$body["doc"]["isPartOf"]["pageEnd"] = $_REQUEST["isPartOf_pageEnd"];

$body["doc_as_upsert"] = true;

//print("<pre>".print_r($body, true)."</pre>");

$upsert = Elasticsearch::update($_REQUEST["rppbci_id"], $body);
//print_r($upsert);

header("Location: ../index.php");

?>