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
		->title("AlboPOP - Aggregato - $label")
		->description("*non ufficiale* RSS feed degli Albi Pretori dei comuni italiani per $label")
        ->url("$domain/albi_pretori/")
        ->language("it")
        ->pubDate(new DateTime())
        ->copyright("Creative Commons Attribution 4.0")
        //->webMaster("alessio.cimarelli@ondata.it (Alessio Cimarelli)")
        //->docs("https://github.com/RicostruzioneTrasparente/albopop-es2rss")
        //->category("Aggregato", "http://albopop.it/specs#channel-category-type")
        //->category($label, "http://albopop.it/specs#channel-category-name")
		->appendTo($feed);

	# Feed population
	foreach ($results as $result) {

		$doc = $result['_source'];
        $item = new Item();

		$item
			->title('['.$doc['channel']['name'].'] '.$doc['title'])
            ->description($doc['description']);

        $item
            ->category($doc['channel']['uid'], "http://albopop.it/specs#channel-category-uid")
            ->category($doc['channel']['type'], "http://albopop.it/specs#channel-category-type")
            ->category($doc['channel']['name'], "http://albopop.it/specs#channel-category-name");

        $item
            ->category($doc['uid'], "http://albopop.it/specs#item-category-uid");

        if (isset($doc['country']))
            $item->category($doc['country'], "http://albopop.it/specs#item-category-country");
        if (isset($doc['region']))
            $item->category($doc['region'], "http://albopop.it/specs#item-category-region");
        if (isset($doc['province']))
            $item->category($doc['province'], "http://albopop.it/specs#item-category-province");
        if (isset($doc['municipality']))
            $item->category($doc['municipality'], "http://albopop.it/specs#item-category-municipality");
        if (isset($doc['latitude']))
            $item->category($doc['latitude'], "http://albopop.it/specs#item-category-latitude");
        if (isset($doc['longitude']))
            $item->category($doc['longitude'], "http://albopop.it/specs#item-category-longitude");
        if (isset($doc['type']))
            $item->category($doc['type'], "http://albopop.it/specs#item-category-type");
        if (isset($doc['pubStart']))
            $item->category($doc['pubStart'], "http://albopop.it/specs#item-category-pubStart");
        if (isset($doc['pubEnd']))
            $item->category($doc['pubEnd'], "http://albopop.it/specs#item-category-pubEnd");
        if (isset($doc['relStart']))
            $item->category($doc['relStart'], "http://albopop.it/specs#item-category-relStart");
        if (isset($doc['exeStart']))
            $item->category($doc['exeStart'], "http://albopop.it/specs#item-category-exeStart");
        if (isset($doc['chapter']))
            $item->category($doc['chapter'], "http://albopop.it/specs#item-category-chapter");
        if (isset($doc['unit']))
            $item->category($doc['unit'], "http://albopop.it/specs#item-category-unit");
        if (isset($doc['amount']))
            $item->category($doc['amount'], "http://albopop.it/specs#item-category-amount");
        if (isset($doc['currency']))
            $item->category($doc['currency'], "http://albopop.it/specs#item-category-currency");
        if (isset($doc['annotation']))
            $item->category($doc['annotation'], "http://albopop.it/specs#item-category-annotation");

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
