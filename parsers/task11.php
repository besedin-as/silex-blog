
<?php

$file = "https://www.wildberries.ru/catalog/muzhchinam/odezhda/futbolki-i-mayki";
$doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
$doc->loadHTMLFile($file);

$xpath = new DOMXpath($doc);

$names = $xpath->query("/html/body/div/div/div/div/div[@class='dtList']/a/strong");
$prices = $xpath->query("/html/body/div/div/div/div/div[@class='dtList']/a/span/ins");


$dom = new DomDocument('1.0', 'utf-8');
$dom->formatOutput = true;

$books = $dom->appendChild($dom->createElement('products'));

$i=0;
while ($names[$i] != null) {
    $book = $books->appendChild($dom->createElement('product'));

    $name = $book->appendChild($dom->createElement('name'));
    $price = $book->appendChild($dom->createElement('price'));

    $name->appendChild(
        $dom->createTextNode($names[$i]->nodeValue));

    $price->appendChild(
        $dom->createTextNode($prices[$i]->nodeValue));
    $i++;
}
$dom->formatOutput = true;
$data = $dom->saveXML();
$dom->save('data.xml');
