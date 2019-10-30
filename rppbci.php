<?php

require 'functions.php';

print("<pre>".print_r($_REQUEST, true)."</pre>");

$body["doc"]["name"] = $_REQUEST["name"];
$body["doc"]["alternateName"] = $_REQUEST["alternateName"];
$body["doc"]["doi"] = $_REQUEST["doi"];
$body["doc"]["isPartOf"]["name"] = $_REQUEST["isPartOf_name"];
$body["doc"]["isPartOf"]["ISSN"] = $_REQUEST["isPartOf_ISSN"];
$body["doc"]["isPartOf"]["name"] = $_REQUEST["isPartOf_name"];
$body["doc"]["isPartOf"]["name"] = $_REQUEST["isPartOf_name"];
$body["doc"]["isPartOf"]["name"] = $_REQUEST["isPartOf_name"];



print("<pre>".print_r($body, true)."</pre>");


?>