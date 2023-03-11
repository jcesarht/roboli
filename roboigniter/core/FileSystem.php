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
    function createFile($filename = ''){
        
    }
}