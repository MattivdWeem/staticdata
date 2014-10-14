<?php
include('staticData.php');

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

echo'<pre>';
print_r($data->getAll(false));
print_r($data->newSet('users'));
echo'</pre>';


?>