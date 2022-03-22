<?php
if (!isset($_SESSION)) session_start();

class MessageService
{
    private $errors;
    private $input_errors;
    private $infos;

    public function __construct()
    {
        $this->saveSession();
    }

    public function saveSession()
    {
        $this->infos = $_SESSION["infos"];
        $this->errors = $_SESSION["errors"];
        $this->input_errors = $_SESSION["input_errors"];
        $_SESSION["infos"] = [];
        $_SESSION["errors"] = [];
        $_SESSION["input_errors"] = [];
    }

    private function countErrors(): int
    {
        return count($this->errors);
    }
    private function countInputErrors(): int
    {
        return count($this->input_errors);
    }
    private function countInfos(): int
    {
        return count($this->infos);
    }

    private function countNewErrors(): int
    {
        return count($_SESSION["errors"]);
    }
    private function countNewInputErrors(): int
    {
        return count($_SESSION["input_errors"]);
    }
    private function countNewInfos(): int
    {
        return count($_SESSION["infos"]);
    }

    public function getInputErrors(): array
    {
        if ($this->countNewInputErrors() == 0) return null;
        return $this->input_errors;
    }

    public function addMessage($type, $msg, $key = null)
    {
        if ($type == "input_errors" and !$key) {
            $_SESSION["errors"][] = "Voor het aanmaken van een nieuwe input_error moet je de key van het veld meegeven";
        } elseif ($type == "input_errors") {
            $_SESSION["input_errors"][$key] = $msg;
        } elseif ($type == "errors") $_SESSION["errors"][] = $msg;

        else $_SESSION["infos"][] = $msg;
    }

    public function ShowErrors($template)
    {

        $errorMessages = [];
        foreach ($this->errors as $error) {
            $errorMessages[] = "<p class='error'>$error</p>";
        }
        $template = str_replace("@@error@@", implode("<br>", $errorMessages), $template);

        foreach ($this->input_errors as $key => $value) {
            $template = str_replace("@@err_$key@@", $value, $template);
        }
        return $template;
    }

    public function ShowInfos($template)
    {
        $infoMessages = [];
        foreach ($this->infos as $info) {

            $infoTemplate = file_get_contents("./templates/messageTemplate.html");
            $infoTemplate = str_replace("@@class@@", "info", $infoTemplate);
            $infoTemplate = str_replace("@@message@@", $info, $infoTemplate);
            $infoMessages[] = $infoTemplate;
        }
        return str_replace("@@info@@", implode("", $infoMessages), $template);
    }
}
