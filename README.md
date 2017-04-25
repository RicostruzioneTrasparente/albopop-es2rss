# Items from ES to RSS feed, v1.0.0

Simple php to query last items indexed to Elasticsearch and return them as RSS feed.

## Dipendenze

Php, Composer, Elasticsearch, PHP RSS Writer, Apache2.

## Struttura del progetto

Il progetto usa [Composer](https://getcomposer.org/) per gestire le dipendenze:

* [php-rss-writer](https://github.com/suin/php-rss-writer) - interfaccia di alto livello per costruire e pubblicare un feed RSS;
* [elasticsearch-php](https://github.com/elastic/elasticsearch-php) - client php per elasticsearch.

## Parametri

* format: [rss|json] (string)
  * rss: formato rss
  * json: formato json
* q (string): ricerca libera (es. description:compenso+affidamento)
* source (string): filtro sul channel (es. name:Comune+di+Cittareale)
* filter: [ricostruzionetrasparente] (string)
  * ricostruzionetrasparente: query predefinita "sisma terremoto ricostruzione" in "description"
* size: (int pos) (dafault: 25)
