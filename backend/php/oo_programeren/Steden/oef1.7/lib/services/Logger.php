<?php

    class Logger{
        private $fp;
        private $logfile;

        function __construct($file="log.txt"){
            $root = $_SERVER["DOCUMENT_ROOT"];
            $this->logfile = "$root\log\\$file";
        }

        function Log($msg){
            $datetime = new DateTime("now");
            $datetime_str = $datetime->format('Y-m-d H:i:s');
            $fp = fopen($this->logfile, "a");
            fwrite($fp, "$datetime_str - $msg\r\n");
        }

        function showLog(){
            $content = file_get_contents($this->logfile);
            return "<p>".nl2br($content)."</p>";
        }
    }
