<?php
require_once "autoload.php";

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

    # het aantal keys (rijen) in $data bepaald het aantal articles.
    foreach($list as $city){
        # voor iedere rij wordt een nieuwe article template ingelezen.
        $content .= file_get_contents("./templates/$template");
        //exit(var_dump($city->getTitle()));

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
