<?php

# Standard libs loading by composer:
# https://getcomposer.org/doc/00-intro.md
require_once __DIR__ . '/vendor/autoload.php';

function fromEs($search,$filter,$source,$from,$size) {

    $query = [
        "bool" => [
            "must" => [],
            "should" => [],
            "must_not" => [],
            "filter" => []
        ]
    ];

    if (!empty($search)) {
        $fields = explode(':', $search, 2);
        $search_value = end($fields);
        $search_key = count($fields) > 1 ? $fields[1] : 'description';
        $query['bool']['must'][] = [
            "match" => [
				$search_key => $search_value
            ]
        ];
    }

    if (!empty($source)) {
        $fields = explode(':', $source, 2);
        $search_value = end($fields);
        $search_key = count($fields) > 1 ? $fields[1] : 'name';
        $query['bool']['must'][] = [
            "term" => [
			   $search_key => $search_value
            ]
        ];
    }

	switch($filter) {
		case 'ricostruzionetrasparente':
            $query['bool']['filter'][] = [
                "match" => [
                    "description" => "sisma terremoto ricostruzione"
                ]
			];
			break;
		default:
		    break;
	}

	if (!empty($from)) {
		$query['bool']['filter'][] = [
            "range" => [
                "timestamp" => [
                    "gte" => $from
                ]
            ]
		];
    }

	# Query last items from Elasticsearch documents:
	$client = Elasticsearch\ClientBuilder::create()
        ->setHosts(['localhost:9200'])
        ->allowBadJSONSerialization() # From https://github.com/elastic/elasticsearch-php/issues/529
		->build();

	function now($from) {
		return $from ? new DateTime("@$from") : new DateTime();
	}

	$current_month = now($from);
	$last_month = now($from)->add(DateInterval::createFromDateString('1 month ago'));
	$prefix = "albopop-v4";

	$params = [
		"index" => $prefix."-".$last_month->format('Y.m').",".$prefix."-".$current_month->format('Y.m'),
		"type" => "item",
        "body" => [
            "size" => $size,
            "sort" => [ [ "pubDate" => "desc" ] ],
            "query" => $query
        ],
		"client" => [ 'ignore' => 404 ],
		"ignore_unavailable" => True
    ];

	try {
		$result = $client->search($params);
		return $result["hits"]["hits"] ?: [];
	} catch (Exception $e) {
		return [];
    }

}
?>
