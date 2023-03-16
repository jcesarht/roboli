<?php
//use Symfony\Component\Finder\Finder;
//use Symfony\Component\Filesystem\Filesystem;
class BuildForm{
    private $inputs = [];
    public function __construct(){

    }
    public function setInputs($inputs):void{
        $this->inputs = $inputs;
    }
    public function getInputs(){
        return $this->inputs;
    }
    //create the inputs in html lenguage with div and boobstraps
    private function createInputHTML(){
        $input = $this->getInputs();
        $total_input = count($input);
        $html_inputs = '';
        if($total_input !== 0){
            for($x=0; $x < $total_input; $x++ ){
                $id_input = $input[$x]['id'];
                $label_name = $input[$x]['label'];
                if($label_name === ''){
                    $label_name = ucwords(str_replace('_',' ',strtolower($input[$x]['name'])));
                }
                $html_inputs .= '<div class="form-group">';
                if($input[$x]['type'] == 'text' || $input[$x]['type'] == 'password' || $input[$x]['type'] == 'date' || $input[$x]['type'] == 'number'){
                    $html_inputs .= '<label for="'.$id_input.'">'.$label_name.'</label>';
                    $html_inputs .= '<input ';
                    foreach($input[$x] as $attribute => $value){
                        $html_inputs .= $attribute.' = "'.$value.'" ';
                    }
                    $html_inputs .= '/> ';
                }else if($input[$x]['type'] == 'checkbox'){
                    $html_inputs .= '<input ';
                    foreach($input[$x] as $attribute => $value){
                        $html_inputs .= $attribute.' = "'.$value.'" ';
                    }
                    $html_inputs .= '/>';
                    $html_inputs .= '<label for="'.$id_input.'">'.$label_name.'</label>';
                }else if($input[$x]['type'] == 'select'){
                    $html_inputs .= '<label for="'.$id_input.'">'.$label_name.'</label>';
                    $html_inputs .= '<select ';
                    foreach($input[$x] as $attribute => $value){
                        if(is_string($value) === true && $attribute !== 'type'){ 
                            $html_inputs .= $attribute.' = "'.$value.'" ';
                        }
                    }
                    $html_inputs .= '/> ';
                    foreach($input[$x]['option'] as $option => $value){
                        $html_inputs .= '<option value = "'.$value.'">'.$option.'</option>';
                    }
                }
                $html_inputs .= ' </select></div>';
            }
        }else{
            $html_inputs = '<!-- put the html code for input here -->';
        }
        return $html_inputs;
    }
    //create the div like columns to every six "6" inputs
    public function configLayout (){
        $inputs = $this->getInputs();
        //divido el array en 6 partes y los almaceno en otro array llamado $input_content 
        $input_content = array_chunk($inputs,6,false);
        $total_input = count($inputs);
        $total_columns = ceil($total_input/6);
        $size_column = (12/$total_columns);
        $html_content = '';
        //recorre la cantidad de columnas o divs obtenidos y le agrega los respectivos inputs
        for($x=0; $x < $total_columns; $x++){
            $html_content .= '<div class="col-'.$size_column.' ">';
            $this->setInputs($input_content[$x]);
            $html_content .= $this->createInputHTML();
            $html_content .= '</div>';
        }
        return $html_content;
    }
}/*
$fm = new BuildForm();
$input = [
    ['type'=>'text','name'=>'first_name','id'=>'first_name','placeholder'=>'First Name'],
    ['type'=>'text','name'=>'last_name','id'=>'last_name','placeholder'=>'Last Name'],
    ['type'=>'text','name'=>'phone','id'=>'phone','placeholder'=>'Phone'],
    ['type'=>'text','name'=>'email','id'=>'email','placeholder'=>'Email'],
    ['type'=>'text','name'=>'address','id'=>'address','placeholder'=>'Address'],
    ['type'=>'select','name'=>'state','id'=>'state','option'=>['opcion 1'=>1,'opcion 2'=>2,'opcion 3'=>3,]],
    ['type'=>'checkbox','name'=>'Agreement','id'=>'agreement','value'=>'Agreement'],    
];
$fm->setInputs($input);
$input = $fm->configLayout();
echo $input;*/
?>