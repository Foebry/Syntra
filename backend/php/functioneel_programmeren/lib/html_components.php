<?php
require_once "../lib/database.php";

function insertCSS($head, $files){
    $css = '';
    foreach($files as $file){
        $css .= '<link rel="stylesheet" href="../css/'.$file.'">';
    }
    return str_replace("@CSS@", $css, $head);
}


function PrintHead($title, $css=array(0)){
    $head = file_get_contents("../templates/head.html");

    $head = str_replace("@title@", $title, $head);
    $head = insertCSS($head, $css);

    return $head.PrintBody();
}

function PrintJumbo($titel, $subtitel=""){
    $jumbo = file_get_contents("../templates/jumbo.html");

    $jumbo = str_replace("@titel@", $titel, $jumbo);
    $jumbo = str_replace("@subtitel@", $subtitel, $jumbo);

    return $jumbo;
}

function PrintBody(){
    return "<body>";
}

function PrintTitle($header, $title){
    return "<h$header>$title</h$header>";
}

function PrintParagraphLorem($length){
    $lorem = file_get_contents('http://loripsum.net/api/1');
    $words = explode(" ", $lorem);

    return implode(" ", array_slice($words, 0, $length));
}

function PrintImgHolder($path){
    return "<div class='imgholder'>
                <img src='$path'>
            </div>";
}

function PrintLink($path, $txt){
    return "<a href=$path>$txt</a>";
}

function PrintForm($data, $fields, $action){
    $form = "<form method='POST' action='{$action}' id='mainform' name='mainform'>";
    // overloop alle velden die we willen tonen
    foreach ($fields as $field){
        // indien het veld '_id' bevat zetten we het label op "ID"
        $is_id = strpos($field, "_id");
        if($is_id) $label = "ID";

        // indien het veld een '_' bevat, zet het label gelijk aan alles wat volgt
        $pos = strpos($field, "_");
        $label = substr($field, $pos+1);

        // Kijk na of het veldnaam overeenkomt met een key in de array data
        if (array_key_exists($field, $data)){
            $value = $data[$field];
            $form .= '<div class="form-group row">';
            $form .= "<label for='$field' class='col-sm-2 col-form-label'>$label</label>";
            $form .= '<div class="col-sm-10">';

            // indien het veld het id is maak een readonly input aan
            if ($is_id){
                $form .= "<input type='text' readonly class='form-control-plaintext' name=$field id=$field value='$value'>";
                $form .= "</div></div>";
                continue;
            }

            // anders maak een normale input aan
            $form .= "<input type='text' class='form-control' name=$field id=$field value='$value'>";
            $form .= "</div></div>";
        }
    }

    // maak een submit knop aan
    $form .= '<div class="form-group row">';
    $form .= '<div class="col-sm-10">';
    $form .= '<input type="submit" value="save">';
    $form .= "</div></div>";

    return $form;
}


function createFormView($template, $action, $id){
    $form_string = file_get_contents($template);
    $search = ["@action@", "@id@", "@name@"];
    $replace = [$action, $id, $id];
    $form_string = str_replace($search, $replace, $form_string);

    return $form_string;
}


function viewModelTemplate($data, $template, $select=null){
    if (strpos($template, "@data@")){
        $template = str_replace("@data@", setFormData($data), $template);
    }
    if (strpos($template, "@select@")){
        $template = str_replace("@select@", setFormSelect($select, $data), $template);
    }
    if (strpos($template, "@img@")){
        $template = str_replace("@img@", setFormImage($data), $template);
    }
    if (strpos($template, "@submit@")) {
        $template = str_replace("@submit@", setFormSubmit(), $template);
    }
    return $template;
}


function setFormData($data){
    $conn = connectDb();
    $headers = getData($conn, "select * from INFORMATION_SCHEMA.columns where TABLE_NAME = 'images'");
    
    $replace_data = "";
    $i = 0;
    foreach ($data as $key => $value){
        $readonly = $headers[$i]["COLUMN_KEY"] == "PRI" ? "readonly" : "";
        $replace_data .= '<div class="form-group row">';
        $replace_data .= "<label for='$key' class='col-sm-2 col-form-label'>$key</label>";
        $replace_data .= '<div class="col-sm-3">';
        $replace_data .= "<input type='text' $readonly class='form-control' name=$key id=$key value='$value'>";
        $replace_data .= "</div></div>";
        $i += 1;
    }
    return $replace_data;
}
function setFormSelect($select, $select_data){

    $conn = connectDb();
    $sql = "select $select[0] from $select[1]";
    $data = GetData($conn, $sql);

    $replace_data = '<div class="form-group row">';
    $replace_data .= "<label for=".$select[1]."_select"." class='col-sm-2 col-form-label'>$select[1]</label>";
    $replace_data .= '<div class="col-sm-2">';
    $replace_data .= "<select class='form-control' id=".$select[1]."_select>";
    $replace_data .= "<option value=-1 name=$select[1]_option></option>";
    foreach($data as $row => $row_data){
        $selected = $select_data["id"]-1 == $row ? "selected" : "";
        $value = $row_data[$select[0]];
        $replace_data .= "<option $selected value=$row name=$select[1]._option>$value</option>";
    }
    $replace_data .= "</select>";
    $replace_data .= "</div></div>";
    return $replace_data;
}
function setFormImage($data){
    $path = "../images/".$data["filename"];
    return "<div class='imgholder'>
                <img src='$path'>
            </div>";
}
function setFormSubmit(){
    return "<input type='submit' value='Submit'>";
}

 ?>
