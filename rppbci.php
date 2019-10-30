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

print("<pre>".print_r($_REQUEST, true)."</pre>");

$body["doc"]["name"] = $_REQUEST["name"];
$body["doc"]["alternateName"] = $_REQUEST["alternateName"];

$i = 0;
do {
    $key =  'author_'.$i.'_person_name';
    $key_person_identifier_value =  'author_'.$i.'_person_identifier_value';
    $key_organization_name =  'author_'.$i.'_organization_name';
    $key_organization_external =  'author_'.$i.'_organization_external';

    if (isset($_REQUEST[$key])) {
        $body["doc"]["author"][$i]["person"]["name"] = $_REQUEST[$key];
        $body["doc"]["author"][$i]["person"]["identifier"]["value"] = $_REQUEST[$key_person_identifier_value];        
        $body["doc"]["author"][$i]["organization"]["name"] = $_REQUEST[$key_organization_name];
        
    }
    $i++;
} while ($i < 100);



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