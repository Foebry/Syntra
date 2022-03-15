<?php

    interface LoaderInterface{

        function getById();
        function getAll($limit=null);
    }