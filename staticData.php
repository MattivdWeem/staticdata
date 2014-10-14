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
    * Create a new data set
    * @param str name , the name of the new set
    */
    public function newSet($name){
        $path = $this->folder.$name;
        if (!file_exists($path)):
            mkdir($path, 0755, true);
            return true;
        endif;
        return array('message'=>'Set already exists','e'=>false);
    }

    /*
    *   Create a new data object.
    *   @param array data The data you want to push into the set.
    *   @return void
    */
    public function create($data = array()){
        $content = json_encode($data);
        $id = $this->last();
        $id++;
        file_put_contents($this->folder.$this->data_set.'/'.$id.$this->extension,$content);
    }

    /*
    *   obtain the latest id from this data set
    *
    *   @return int max id
    */
    public function last(){
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

    /*
    *   obtain the total from this data set
    *
    *   @return int total count
    */
    public function total(){
        $files = glob($this->folder.$this->data_set.'/*.{'.substr($this->extension,1).'}', GLOB_BRACE);
        $total = 0;
        foreach($files as $file):
            $total++;
        endforeach;
        return $total;
    }

    /*
    *   obtain the min id from this data set
    *
    *   @return int min id
    */
    public function first(){
        $files = glob($this->folder.$this->data_set.'/*.{'.substr($this->extension,1).'}', GLOB_BRACE);
        $min = $this->total();
        foreach($files as $file):
            $int = str_replace($this->extension,'',basename($file));
            if($int <= $min ):
                $min = $int;
            endif;
        endforeach;
        return $min;
    }


    /*
    *
    *   Delete object with given id
    *
    *   @param int id given id to remove
    *   @return bool
    */
    public function delete($id){
        $file = $this->folder.$this->data_set.'/'.$id.$this->extension;
        if(file_exists($file)):
            unlink($file);
            return true;
        endif;
        return false;
    }

    /*
    *
    *   Read given id
    *
    *   @param id, the given id to read
    *   @param json, if json is false, the content will be returned as an array
    *   @return json/array of selected object
    */
    public function read($id,$json = true){
        $file = $this->folder.$this->data_set.'/'.$id.$this->extension;
        $give = '';
        if(file_exists($file)):
            $give = file_get_contents($file);
        endif;
        if($json):return ($give);endif;
        return json_decode($give,true);
    }

    /*
    *
    *   update the given id with new data
    *
    *   @param id the id to update
    *   @param data the new data
    *   @return bool
    */
    public function update($id,$data){
        $file = $this->folder.$this->data_set.'/'.$id.$this->extension;
        if(file_exists($file)):
            file_put_contents($file,json_encode($data));
            return true;
        endif;
        return false;
    }

    /*
    *
    *   Retrieve all rows from collection
    *
    *   @param json Return as json or as array
    *   @return array or json
    */
    public function all($json = true){
        $files = glob($this->folder.$this->data_set.'/*.{'.substr($this->extension,1).'}', GLOB_BRACE);
        $give = array();
        $contents = array();
        foreach($files as $file):
            $contents = array();
            $contents['id'] = $id = str_replace($this->extension,'',basename($file));
            $contents_f = file_get_contents($file);
            $contents_f = json_decode($contents_f, true);
            $contents += $contents_f;
            $give[$id] = $contents;
        endforeach;
        asort($give);
        if($json):return json_encode($give);endif;
        return $give;
    }

    /*
    *   Get a list of all sets
    *
    *   @return array of  data stacks
    */
    public function allSets(){
        return str_replace($this->folder,'',array_filter(glob($this->folder.'*'), 'is_dir'));
    }

    /*
    *   Select from where key = value
    *
    *   @param str key the given key to search
    *   @param str value    the given string the key should match
    *   @return array of matching objects
    */
    public function where($key,$value){
        $return_array = array();
        foreach($this->getAll(false) as $construct):
            if(isset($construct[$key]) && $construct[$key] == $value):
                $return_array += $construct;
            endif;
        endforeach;
        return $return_array;
    }


    /*
    *   Create a backup of the file
    *   @return file name of json file with backup
    */
    public function export(){
        $all = $this->all(false);
        $file = $this->folder.'backups/'.$this->data_set.'-backup'.time().'.json';
        file_put_contents($file,json_encode($all));
        return $file;
    }

    /*
    *   Read backup
    *   @param str input the file or string that will be imported
    *   @return void
    */
    public function import($input){
        if(file_exists($input)):
            $input = file_get_contents($input);
        endif;
        $import = json_decode($input);
        foreach($import as $i):
            $this->create($i);
        endforeach;
    }



}