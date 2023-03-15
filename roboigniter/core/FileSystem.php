<?php
class FileSystem{
    private $path = '';
    private $file_name = '';
    function __construct(){

    }

    function setPath($path){
        $this->path = $path;       
    }
    function setFileName($path){
        $this->file_name = $path;       
    }
    function getPath(){
        return $this->path;       
    }
    function getFileName(){
        return $this->file_name;       
    }
    function createFile($file_name = ''){
        $fileName = $file_name;
        $message = '';
        $file = false;
        if($fileName === ''){
            $fileName = $this->getPath().$this->getFileName();
        }
        if($fileName === ''){
            $message = 'No se puede crear archivo sin el nombre de archivo ';
        }else{
            $file = fopen($fileName);
            fclose($file);
        }
        return ['message' => $message,'file' => $file];
    }
    function write($contenido){
        $file_system = $this->createFile();
        $file = false;
        if($file_system['file'] !== false){
            $file = $file_system['file'];
        }
    }
}
?>