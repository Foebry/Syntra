<?php

function injectColumn($data){
  return "
  <div class='col-sm-4'>
      <h3>{$data["title"]}</h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris...</p>
      <div class='imgholder'>
        <img src='{$data["path"]}' />
      </div>
    </div>
  ";
}
 ?>
