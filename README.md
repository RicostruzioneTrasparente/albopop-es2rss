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
* q (string): ricerca libera nella forma `[campo di ricerca[, campo di ricerca[, ...]]]:[stringa di ricerca]` (es. `title,description:sisma+ricostruzione` oppure `pubblicazioni+matrimonio`)
* source (string): filtro sul channel nella forma `[campo di ricerca]:[chiave di ricerca[, chiave di ricecrca[, ...]]]` (es. `name:Comune+di+Cittareale` oppure `Comune+di+Cittareale,Amatrice,Arquata+del+Tronto`)
* filter: [ (empty)* | ricostruzionetrasparente ] (string)
  * (empty): nessun filtro
  * ricostruzionetrasparente: query predefinita "sisma terremoto ricostruzione" in "description"
* size: (int pos) (dafault: 25)

## Esempi

L'url del feed è http://feeds.ricostruzionetrasparente.it/albi_pretori/

* http://feeds.ricostruzionetrasparente.it/albi_pretori/?filter=ricostruzionetrasparente&q=aedes&size=10&format=rss (atti sulle schede aedes)
* http://feeds.ricostruzionetrasparente.it/albi_pretori/?filter=ricostruzionetrasparente&q=compensi&size=10&format=rss (atti che riguardano compensi)
* http://feeds.ricostruzionetrasparente.it/albi_pretori/?filter=ricostruzionetrasparente&source=Amatrice,Arquata+del+Tronto&size=10&format=rss (atti che riguardano compensi ad Amatrice o Arquata del Tronto)
* http://feeds.ricostruzionetrasparente.it/albi_pretori/?q=pubblicazione+matrimonio&size=10&format=rss (pubblicazioni di matrimonio)
* http://feeds.ricostruzionetrasparente.it/albi_pretori/?q=traffico&source=Amatrice,Arquata+del+Tronto&size=10&format=rss (atti riguardanti il traffico ad Amatrice)
* http://feeds.ricostruzionetrasparente.it/albi_pretori/?q=manutenzione+strade&size=10&format=rss (manutenzione strade)

