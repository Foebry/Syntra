<?php

    interface LoaderInterface{

        function getById(int $id);
        function getAll($limit=null);
    }