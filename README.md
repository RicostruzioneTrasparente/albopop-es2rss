# Items from ES to RSS feed, v1.0.0

Simple php to query last items indexed to Elasticsearch and return them as RSS feed.

## Dipendenze

Php, Composer, Elasticsearch, PHP RSS Writer, Apache2.

## Struttura del progetto

Il progetto usa [Composer](https://getcomposer.org/) per gestire le dipendenze:

* [php-rss-writer](https://github.com/suin/php-rss-writer) - interfaccia di alto livello per costruire e pubblicare un feed RSS;
* [elasticsearch-php](https://github.com/elastic/elasticsearch-php) - client php per elasticsearch.

## Parametri

* format: [ rss* | json ] (string)
  * rss: formato rss
  * json: formato json
* q (string): ricerca libera (es. description:compenso+affidamento)
* source (string): filtro sul channel (es. name:Comune+di+Cittareale)
* filter: [ (empty)* | ricostruzionetrasparente ] (string)
  * (empty): nessun filtro
  * ricostruzionetrasparente: query predefinita "sisma terremoto ricostruzione" in "description"
* size: (int pos) (dafault: 25)

## Esempi

L'url del feed è http://feeds.ricostruzionetrasparente.it/albi_pretori/

* http://feeds.ricostruzionetrasparente.it/albi_pretori/?filter=ricostruzionetrasparente&q=aedes&size=10&format=rss (atti sulle schede aedes)
* http://feeds.ricostruzionetrasparente.it/albi_pretori/?filter=ricostruzionetrasparente&q=compensi&size=10&format=rss (atti che riguardano compensi)
* http://feeds.ricostruzionetrasparente.it/albi_pretori/?q=pubblicazione+matrimonio&size=10&format=rss (pubblicazioni di matrimonio)
* http://feeds.ricostruzionetrasparente.it/albi_pretori/?q=manutenzione+strade&size=10&format=rss (manutenzione strade)

