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
p($data->newSet('users'));
p($data->allSets());


echo 'Min :' . $data->first() .'<br />';
echo 'max :' . $data->last() .'<br />';
echo 'total :' . $data->total() .'<br />';

//$data->import('data/backups/static-backup1413322445.json');
//echo $data->import('data/backups/static-backup1413322898.json');
?>