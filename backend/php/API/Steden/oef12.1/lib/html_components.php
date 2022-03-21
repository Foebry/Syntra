<?php
require_once "autoload.php";


function PrintHead($title, $css=array(0)) :string{
    /**
     * functie die de hoofding van de webpagina zal genereren.
     * @param $title: de titel van de webpagina
     * @param $css: de verschillende css files nodig om de pagina te stylen.
     * @type $title: string
     * @type $css: array($string)
     *
     * @return: string
     */

    # Inladen van de template nodig om de head te genereren.
    $head = file_get_contents("./templates/head.html");

    # Vervangen van placeholder @title@ door de $title
    $head = str_replace("@@title@@", $title, $head);
    # vervangen van placeholder @css@ door de verschillende css style sheets nodig om de pagina te stylen
    $head = insertCSS($head, $css);


    return $head;
}

function insertCSS($headtxt, $files){
    /**
     * functie die de verschillende style sheets zal inladen.
     * @param $headtxt: html-string van de head.
     * @param $files: verschillende style-sheets nodig om de pagina te stylen
     * @type $headtxt: string
     * @type $files: array(string)
     *
     * @return: string
     */

    $css = '';
    # genereer een link-tag voor iedere css file in files.
    foreach($files as $file){
        $css .= '<link rel="stylesheet" href="../css/'.$file.'">';
    }
    # vervang placeholder @CSS@ door de genenereerde string
    return str_replace("@@CSS@@", $css, $headtxt);
}

function createArticles(array $list , string $template, bool $uppercase=False) :string{
    /**
    * functie die een parentclass articles creëert met daarin een aantal articles aanmaakt aan de
    * hand van de geleverde template samengevoegd met de benodigde data.
    * @param $data: verschillende data nodig om de articles te genereren.
    * @param $template: de gekozen template voor de article tag.
    * @type $data: array[string=>[array(string)]]
    * @type $template: string
    *
    * @return: string
    */

    # aanmaken van de parent tag articles
    $content = "<div class='articles'>";
    

    // var_dump(json_decode($curl_response, true));
    // exit;

    # het aantal keys (rijen) in $data bepaald het aantal articles.
    foreach($list as $city){
        // exit($city->getTitle(false));
        # voor iedere rij wordt een nieuwe article template ingelezen.
        $content .= file_get_contents("./templates/$template");
        $cityName = $city->getTitle(false);
        $url = "https://api.openweathermap.org/data/2.5/weather?q=$cityName&appid=e82afbfe8fcbb0c59952e4e07c5a7524&units=metric&lang=nl";
        $curl = curl_init( $url );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
        $curl_response = curl_exec( $curl );
        $data = json_decode($curl_response, true);

        $desc = $data["weather"][0]["description"];
        $temp = round($data["main"]["temp"]);
        $hum = $data["main"]["humidity"];

        $content = str_replace("@@api_data@@", "Weer: $desc $temp °C, vochtigheid: $hum%", $content);
        // print("<pre>");
        // var_dump($data);
        // print("</pre>");
        // exit;

        $content = replaceCityProperties($content, $city, $uppercase);
    }
    # sluit de parent tag af
    return $content."</div>";
}

function mergeContent($template, $content){
    /**
    * functie om de @content@ placeholder te vervangen met de volledige content-string
    * @param $template: De gewenste template pagina.
    * @param $content: de volledige content string
    * @type $template: string
    * @type $content: string
    */

    # gewenste template pagina inlezen.
    $template = file_get_contents("./templates/$template");
    # @content@ placeholder vervangen door de contentstring
    $template = str_replace("@@content@@", $content, $template);

    return $template;
}

function mergeErrorInfoPlaceholder($templatetxt, $headers, $errors, $info){
    /**
    * functie die de overeenkomende error-placeholders en info-placeholders zal vervangen in geval
    * van errors en info message.
    * @param $templatetxt: de gegenereerde htmlstring
    * @param $headers: kolomhoofden van de tabel
    * @param $errors: error messages
    * @param $info: info message
    * @type $templatetxt: string
    * @type $headers: array(string => array())
    * @type $errors: array(string => string)
    * @type $info: string
    *
    * @return: string
    */

    # vervang de verschillende error-placeholders in de htmlstring
    $templatetxt = mergeErrors($templatetxt, $headers, $errors);
    # vervang de info-placeholders in de htmlstring
    $templatetxt = mergeInfo($templatetxt, $info);

    return $templatetxt;
}

function mergeInfo($templatetxt, $info){
    /**
    * functie die de info-placeholder zal vervangen door de gewenste boodschap.
    * @param $templatetxt: de gegenereerde htmlstring
    * @param $info: de info-message
    * @type $templatetxt: string
    * @type $info: string
    *
    * @return: string
    */

    # vervang de info-placeholder door de gewenste info-message.
    $templatetxt = str_replace("@@info@@", $info, $templatetxt);

    return $templatetxt;
}

function removeEmptyPlaceholder($templatetxt){
    /**
    * functie die de resterende placeholders zal verwijderen.
    * onopgevulde placeholders mogen nu verwijderd worden.
    * @param $templatetxt: de gegenereerde htmlstring
    * @type $templatetxt: string
    *
    * @return: string
    */

    # verzamel alle nog bestaande placeholders
    $tags = getTagsFromTemplate($templatetxt);
    # vervang iedere placeholder door een lege string
    foreach($tags as $tag){
        $templatetxt = str_replace("@@$tag@@", "", $templatetxt);
    }

    return $templatetxt;
}

function getTagsFromTemplate($templatetxt, $offset=0){
    /**
    * functie die alle bestaande placeholders zal zoeken.
    * @param $templatetxt: de gegenereerde htmlstring
    * @param $offset: startplaats om te zoeken naar placeholders in de htmlstring
    * @type $templatetxt: string
    * @type $offset: int
    * @default $offset: 0
    *
    * @return: array(string)
    */


    $placeholders = [];
    # zoek naar de eerste positie waar een @ voorkomt.
    # @ duidt de start van een placeholder aan
    $offset = strpos($templatetxt, "@@", $offset);

    # zolang placeholders gevonden worden, voeg deze toe aan de placeholders array
    while($offset){
        # zoek naar de closing @ van de placeholder, vanaf de positie ná de opening @
        $start = $offset+2;
        $end = strpos($templatetxt, "@@", $start);
        # indien geen closing @ gevonden, zijn er geen verdere placeholders en eindigd de while loop
        if ($end == 0) break;
        # indien wel een closing @ gevonden, voeg de waarde tussen opening en closing @ toe aan de placeholders array
        $placeholders[] = substr($templatetxt, $start, $end-$start);
        # zet $offset gelijk aan de positie van de volgende opening @
        # indien geen gevonden if $offset gelijk aan 0 (ofwel false) en eindigt de while loop
        $offset = strpos($templatetxt, "@@", $end+2);
    }
    return $placeholders;
}

function PrintJumbo($titel, $subtitel=""): string{
    /**
    * functie die de bootstrap Jumbo zal genereren.
    * @param $title: titel voor de Jumbo
    * @param $subtitel: subtitel voor de Jumbo
    * @type $title: string
    * @type $subtitel: string
    *
    * @return: string
    */

    # inladen van de Jumbo template
    $jumbo = file_get_contents("./templates/jumbo.html");

    # vervangen van titel en subtitel placeholders door hun respectievelijke waarden
    $jumbo = str_replace("@@titel@@", $titel, $jumbo);
    return str_replace("@@subtitel@@", $subtitel, $jumbo);
}

function PrintNavBar($template):string {
    /**
    * functie die de bootstrap navbar zal genereren.
    * @param $template: navbar-template
    * @type $template: string
    *
    * @return: string
    */

    # ophalen content van template
    return file_get_contents("./templates/$template");
}

function replaceCityProperties(string $template, City $city, $uppercase) :string{
    $title = $city->getTitle($uppercase);
    $template = str_replace("@@img_title@@", $title, $template);
    $template = str_replace("@@img_filename@@", $city->getFilename(), $template);
    $template = str_replace("@@img_height@@", $city->getHeight(), $template);
    $template = str_replace("@@img_width@@", $city->getWidth(), $template);
    $template = str_replace("@@img_filename@@", $city->getFileName(), $template);
    $template = str_replace("@@img_desc@@", $city->getDesc(), $template);
    $template = str_replace("@@img_id@@", $city->getId(), $template);

    return $template;
}

function createCityDetail(string $template, City $city, $uppercase) :string{

    $content = file_get_contents("./templates/$template");
    $content = replaceCityProperties($content, $city, $uppercase);


    return $content;

}

function createForm($template, $headers, $old_post) :string{
    /**
    * functie die een form zal genereren aan de hand van de te gebruiken template en de data uit old_post
    * @param $template: de te gebruiken template voor de form
    * @param $headers: kolomhoofden van de tabel
    * @param $old_post: waarden ingegeven door de gebruiker.
    * @type $template: string
    * @type $headers: array(string => array())
    * @type $old_post: array(string => string)
    *
    * @return string
    */
    # inladen van template
    $template = file_get_contents("./templates/$template");

    # voor iedere hoofding in headers nagaan of deze voorkomt in de old_post array.
    # zoja vervang de overeenkomende placeholder met de waarde in old_post anders door een lege string
    //exit(var_dump($old_post["usr_email"]));
    foreach ($headers as $tag => $values) {
        $value_verification = key_exists($tag."_verification", $old_post) ? $old_post[$tag."_verification"] : "";
        $value = key_exists($tag, $old_post) ?  $old_post[$tag] : "";
        $template = str_replace("@@$tag@@", $value, $template);
        $template = str_replace("@@$tag"."_verification@@", $value_verification, $template);
    }
    # indien het form ook een csrf placeholder bevat, vervang deze door de gegenereerde csrf-token
    if (strpos($template, "@@csrf@@")){
        $template = str_replace("@@csrf@@", generateCSRF(), $template);
    }

    return $template;
}

function makeSelect($templatetxt, $data, $headers, $id, $option_template){
    //exit(var_dump($id));
    $select = "";
    foreach($data as $row){
        $selected = "";
        $option = file_get_contents("./templates/$option_template");
        foreach($row as $key => $value){

            if ($headers[$key]["key"] == "PRI" and $value == $id) $selected = "selected";

            $option = str_replace("@@$key@@", $value, $option);
            $option = str_replace("@@selected@@", $selected, $option);

        }
        $select .= $option;
    }
    return str_replace("@@makeselect@@", $select, $templatetxt);
}
