<?php
    include('staticData.php');

    $data = new data('static');

    $array = array(

        'name' => 'Matti',
        'age' => 19,
        'awsome' => true,
        'tagx' => 'Tagggg'

    );

    if($data->runable):
        $data->create($array);
    endif;

?>