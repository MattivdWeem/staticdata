<?php

/*
*
* Static data For php
*
* @desciption: Replacement for SQL, will use server stored files to read write and use.
*
* @author: Matti van de Weem
*
*/

class data{

    public $data_set;
    public $folder;
    public $extension = '.sd';
    public $runable;


    /*
    *  Construct the data set and the datasource
    *  @param str data_set The set of data that will be used
    *  @param str folder The folder your data sets are housed.
    */
    public function __construct($data_set, $folder = 'data/'){
        $this->data_set = $data_set;
        $this->folder = $folder;
        $this->runable = $this->runable();
    }

    // simple check if this class is runable on you server with this settings returns bool
    public function runable(){
        if(!is_writable (__FILE__)):
            return array('message'=> __FILE__.' Has not enough rights (try 0755)');
        endif;
        if(!is_writable ($this->folder.$this->data_set)):
            return array('message'=> $this->folder.$this->data_set.' Has not enough rights (try 0755)');
        endif;
        return true;

    }

    /*
    *   Create a new data object.
    *   @param array data The data you want to push into the set.
    *   @return void
    */
    public function create($data = array()){
        $content = json_encode($data);
        $id = $this->latestId();
        $id++;
        file_put_contents($this->folder.$this->data_set.'/'.$id.$this->extension,$content);
    }

    /*
    *   obtain the latest id from this data set
    *
    *   @return int max id
    */
    public function latestId(){
        $files = glob($this->folder.$this->data_set.'/*.{'.substr($this->extension,1).'}', GLOB_BRACE);
        $max = 0;
        foreach($files as $file):
            $int = str_replace($this->extension,'',basename($file));
            if($int >= $max ):
                $max = $int;
            endif;
        endforeach;
        return $max;
    }





}