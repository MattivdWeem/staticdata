<?php
include('staticData.php');
function p($i){echo '<pre>';print_r($i);echo'</pre>';}

$data = new data('static');

$array = array(

    'first-name' => 'Matti',
    'sur-name' => 'van de Weem',
    'age' => 19,
    'country' => 'nl',
    'Main language' => 'PHP'

);

if($data->runable):
    //$data->create($array);
endif;

p($data->all(false));
echo'<code>';
echo $data->all();
echo'</code>';

p($data->newSet('users'));
p($data->allSets());
?>