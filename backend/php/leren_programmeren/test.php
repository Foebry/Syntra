<?php
function update_light($current){
    return ["green"=>"yellow", "yellow"=>"red", "red"=>"green"][$current];
}

print(update_light("green"));