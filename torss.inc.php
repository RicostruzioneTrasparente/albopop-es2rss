<?php

# Standard libs loading by composer:
# https://getcomposer.org/doc/00-intro.md
require_once __DIR__ . '/vendor/autoload.php';

use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Feed;
use Suin\RSSWriter\Item;

function toRss($results,$label) {

	# Following official documentation:
	# https://github.com/suin/php-rss-writer#suinrsswriter
	$feed = new Feed();
	$channel = new Channel();

    # Feed meta-data
    $domain = "http://feeds.ricostruzionetrasparente.it";
	$channel
		->title("AlboPOP per $label")
		->description("Documenti degli Albi Pretori dei comuni italiani per $label.")
		->url("$domain/albi_pretori/")
		->appendTo($feed);

	# Feed population
	foreach ($results as $result) {

		$doc = $result['_source'];
        $item = new Item();

		$item
			->title('['.$doc['channel']['name'].'] '.$doc['title'])
            ->description($doc['description'])
            ->category($doc['country'])
            ->category($doc['region'])
            ->category($doc['province'])
            ->category($doc['municipality'])
            ->category($doc['type']);

        foreach ($doc['enclosure'] as $enclosure) {
            $enclosure_url = $domain . "/albi_pretori/atti/" . $enclosure['path'];
            $item->enclosure(
                $enclosure_url,
                filesize("atti/" . $enclosure['path']),
                'application/' . pathinfo($enclosure_url, PATHINFO_EXTENSION)
            );
        }

		$item
			->guid($doc['guid'], substr($doc['guid'], 0, 4) === "http")
			->pubDate(strtotime($doc['pubDate']))
            ->url($doc['link'])
            ->preferCdata(true)
			->appendTo($channel);

	}

	return $feed;

}
?>
