 <?php

$content=file_get_contents('http://magazin-tolstovok.ru/');

setlocale(LC_ALL, "ru_RU.UTF-8");
preg_match_all('/<span itemprop="name">[а-яА-ЯёЁ\s]*<\/span><\/a><\/div>\s*<div class="price" itemprop="offers" itemscope itemtype="http:\/\/schema.org\/Offer">
                    <span itemprop="price">[\d\,]*\sр?\.<\/span>/u', $content, $matches);



$dom = new DomDocument('1.0', 'utf-8');
$dom->formatOutput = true;

$books = $dom->appendChild($dom->createElement('products'));


foreach ($matches[0] as $value) {
    $value = preg_replace('/^<span itemprop="name">/',"Название: ",$value);
    $value = preg_replace('/<\/span><\/a><\/div>
                <div class="price" itemprop="offers" itemscope itemtype="http:\/\/schema.org\/Offer">
                    <span itemprop="price">/', ", цена: ",$value);
    $value = preg_replace('/<\/span>$/',"",$value);
    echo $value."\n";

    $name_pro=preg_replace('/^Название: /',"",$value);
    $name_pro=preg_replace('/, цена: [\d\,]*\sр?\./',"",$name_pro);

    $price_pro=strstr($value, ', цена', false);
    $price_pro=preg_replace('/^, цена: /',"",$price_pro);
    $price_pro=preg_replace('/ р.$/',"",$price_pro);


    $book = $books->appendChild($dom->createElement('product'));

    $name = $book->appendChild($dom->createElement('name'));
    $price = $book->appendChild($dom->createElement('price'));

    $name->appendChild(
        $dom->createTextNode($name_pro));

    $price->appendChild(
        $dom->createTextNode($price_pro));

}

$dom->formatOutput = true;
$data = $dom->saveXML();
$dom->save('data.xml');

