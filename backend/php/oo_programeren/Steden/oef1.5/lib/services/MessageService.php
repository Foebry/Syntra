<?php
    if(!isset($_SESSION)) session_start();

    class MessageService{
        private $errors;
        private $input_errors;
        private $infos;

        public function __construct($info, $error, $input_error){
            $this->infos = $info;
            $this->errors = $error;
            $this->input_errors = $input_error;
            $_SESSION["infos"] = [];
            $_SESSION["errors"] = [];
            $_SESSION["input_errors"] = [];
        }

        private function countErrors() :int{
            return count($this->errors);
        }
        private function countInputErrors() :int{
            return count($this->input_errors);
        }
        private function countInfos() :int{
            return count($this->infos);
        }

        private function countNewErrors() :int{
            return count($_SESSION["errors"]);
        }
        private function countNewInputErrors() :int{
            return count($_SESSION["input_errors"]);
        }
        private function countNewInfos() :int{
            return count($_SESSION["infos"]);
        }

        public function getInputErrors() :array{
            if ($this->countNewInputErrors() == 0) return null;
            return $this->input_errors;
        }

        public function addMessage($type, $msg, $key=null){
            if($type == "input_errors" AND !$key){
                $_SESSION["errors"][] = "Voor het aanmaken van een nieuwe input_error moet je de key van het veld meegeven";
            }

            elseif($type == "input_errors"){
                $_SESSION["input_errors"][$key] = $msg;
            }

            elseif ($type == "errors") $_SESSION["errors"][] = $msg;

            else $_SESSION["infos"][] = $msg;
        }

        public function ShowErrors($template){
            $template = str_replace("@@error@@", implode("<br>",$this->errors), $template);

            foreach($this->input_errors as $key => $value){
                $template = str_replace("@@err_$key@@", $value, $template);
            }
            return $template;
        }

        public function ShowInfos($template){
            return str_replace("@@info@@", implode("<br>", $this->infos), $template);
        }
    }
