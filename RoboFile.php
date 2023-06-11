<?php
/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;
//use roboigniter\core\BuildView\BuildView as BuildView;
require_once('roboigniter\core\BuildForm.php');
class RoboFile extends \Robo\Tasks
{
    //define variable
    private $nombre_patron = '';
    private $tableName = '';
    private $template = 'simply_crud';
    private $type_pattern = 'api';
    private $primaryKey = '';
    // define public methods as commands
    public function cgStart(){
        $this->say('<info>Hola. ¿Que deseas hacer?</info>');
        $this->say('<info>1. ¿Crear entorno base bajo la técnica SCAFFOLD para API (Controller + Model)?</info>');
        $this->say('<info>2. ¿Crear entorno base bajo la técnica SCAFFOLD para MVC (Controller + Model + Vista)?</info>');
        $this->say('<info>0. Salir.</info>');
    	//$this->say('<info>1. ¿Solo crear un modelo (Model)?</info>');
    	//$this->say('<info>2. ¿Solo crear un controlador (Controller)?</info>');
    	//$this->say('<info>3. ¿Crear entorno base bajo la técnica SCAFFOLD (Controller + View)?</info>');
    	//$this->say('<info>4. ¿Crear entorno completo bajo la técnica SCAFFOLD (Model + Controller + View)?</info>');
        do{
    		$opt = false ;
    		$accion = $this->ask("Escribe el número de la opción: ");
    		switch ($accion) {
    			case '0' :
                    $opt=false;
    				$this->say('<info>Usted ha salido. Hasta luego</info>');
    				break;
                case '1':
    				$confirm = $this->ask("¿Esta usted seguro?. responda con (si/no) o (s/n): ");
                    if(strtolower($confirm) === 's' || strtolower($confirm) === 'si' || strtolower($confirm) === 'sí' ){
                        $this->type_pattern = 'api';
                        $this->cgApiScaffoldConsoleAPI();
                    }else{
                        $this->say('<info>De nuevo: </info>');
                        $this->cgStart();
                    }
                    break;
                case '2':
                    $confirm = $this->ask("¿Esta usted seguro?. responda con (si/no) o (s/n): ");
                    if(strtolower($confirm) === 's' || strtolower($confirm) === 'si' || strtolower($confirm) === 'sí' ){
                        $this->type_pattern = 'mvc';
                        $this->cgApiScaffoldConsoleMVC();
                        break;
                    }else{
                        $this->say('<info>De nuevo: </info>');
                        $this->cgStart();
                        break;
                    }
    			default:
    				$opt=true;
    				$this->say('<info>Por favor escoge una opción válida</info>');
    				break;
    		}
    	}while($opt);
    }
    function cgApiScaffoldConsoleAPI(){ 
        $this->say("<info>Dime si generemos de manera automática y predeterminada un modelo y un controlador para un CRUD</info>");
        $confirm = $this->ask("<info>¿Estas de acuerdo? (sí/no) (s/n): </info>");
        if(strtolower($confirm) === 's' || strtolower($confirm) === 'si' || strtolower($confirm) === 'sí' ){
            $this->say('<info>-------------------------------------------------------------------------</info>');
            $this->say('<info>Por favor escribe el nombre en singular del modelo. Con este nombre generaré el modelo y el controlador. </info>');
            $this->say('<info>Si el nombre esta compuesto por varios nombres, por favor separalos con un guión de piso o underscode "_". </info>');
            $this->say('<info>-------------------------------------------------------------------------</info>');
            $this->nombre_patron = $this->ask("<info>Por favor escribe el nombre del modelo en singular: </info>");
            $this->tableName = $this->ask("<info>Por favor escribe el nombre de la tabla asociada al modelo: </info>");
            $this->cgCreateModel();
            $this->cgCreateController();
        }else{
            $this->say('<info>Esta bien, Generaremos un modelo y controlador con plantilla en blanco: </info>');
            $confirm = $this->ask("<info>¿Estas de acuerdo? (sí/no) (s/n): </info>");
            if(strtolower($confirm) === 's' || strtolower($confirm) === 'si' || strtolower($confirm) === 'sí' ){
                $this->say('<info>Otras instrucciones</info>');
            }else{
                $this->say('<info>Otras preguntas pendientes.</info>');
                $this->cgStart();
            }
        }
    }
    function cgApiScaffoldConsoleMVC(){
        $this->say("<info>Dime si generemos de manera automática y predeterminada un modelo, un controlador y una vista para un CRUD</info>");
        $confirm = $this->ask("<info>¿Estas de acuerdo? (sí/no) (s/n): </info>");
        if(strtolower($confirm) === 's' || strtolower($confirm) === 'si' || strtolower($confirm) === 'sí' ){
            $this->say('<info>-------------------------------------------------------------------------</info>');
            $this->say('<info>Por favor escribe el nombre en singular del modelo. Con este nombre generaré el modelo y el controlador. </info>');
            $this->say('<info>Si el nombre esta compuesto por varios nombres, por favor separalos con un guión de piso o underscode "_". </info>');
            $this->say('<info>-------------------------------------------------------------------------</info>');
            $this->nombre_patron = $this->ask("<info>Por favor escribe el nombre del modelo en singular: </info>");
            $this->tableName = $this->ask("<info>Por favor escribe el nombre de la tabla asociada al modelo: </info>");
            $this->primaryKey = $this->ask("<info>Por favor escribe el nombre de la llave primaria del modelo: </info>");
            $this->cgCreateModel();
            $this->cgCreateController();
            $this->cgCreateView();
        }else{
            $this->say('<info>Esta bien, Generaremos un modelo y controlador con plantilla en blanco: </info>');
            $confirm = $this->ask("<info>¿Estas de acuerdo? (sí/no) (s/n): </info>");
            if(strtolower($confirm) === 's' || strtolower($confirm) === 'si' || strtolower($confirm) === 'sí' ){
                $this->say('<info>Otras instrucciones</info>');
            }else{
                $this->say('<info>Otras preguntas pendientes.</info>');
                $this->cgStart();
            }
        }
    }
    function cgCreateModel($modelName = '', $tableName = '' ){
        if($modelName === '') 
        $modelName = strtolower($this->nombre_patron);
        if($tableName === '') 
        $tableName = strtolower($this->tableName);
        $this->createModel($modelName,$tableName);
    }
    private function createModel($modelName,$tableName){
        $modelName = strtolower($modelName);
        $fileModelName = ucfirst($modelName);
        $file = "models/{$fileModelName}Model.php";
        $fs = new Filesystem();
        if (!$fs->exists($file)) {
          $this->say("<info>Creando Modelo</info>");
          //crear archivo
          $fs->touch($file);
          //escribir template
          
        //crear archivo a partir del template
        $this->taskWriteToFile($file)
            ->textFromFile("roboigniter/template_jchtml/{$this->template}/models/{$this->type_pattern}/model.scaff.php")
            ->run();
        //reemplazar elementos
        $reemplazar = array('%Model%','%tableName%');
        $reemplazo = array(
             $modelName,
             $tableName
        );
        $this->taskReplaceInFile($file)
                ->from($reemplazar)
                ->to($reemplazo)
                ->run();
          $this->say("<info>Modelo creado en {$file}</info>");
        } else {
          $this->say("<error>Modelo ya existía en {$file}</error>");
        }
    }

    function cgCreateController($controllerName = '' ){
        if($controllerName === '') 
        $controllerName = strtolower($this->nombre_patron);
        $this->createController($controllerName,$this->nombre_patron);
    }
    private function createController($controllerName,$patronName){
        $controllerName = ucfirst(strtolower($controllerName));
        $fileControllerName = $controllerName;
        $file = "controllers/{$fileControllerName}.php";
        $fs = new Filesystem();
        if (!$fs->exists($file)) {
            $this->say("<info>Creando Controlador</info>");
            //crear archivo
            $fs->touch($file);
            $this->taskWriteToFile($file)
                ->textFromFile("roboigniter/template_jchtml/{$this->template}/controllers/{$this->type_pattern}/controller.scaff.php")
                ->run();
            //reemplazar elementos
            $reemplazar = array('%Controller%','%Model%');
            $reemplazo = array(
                    $controllerName,
                    $patronName
            );
            $this->taskReplaceInFile($file)
                    ->from($reemplazar)
                    ->to($reemplazo)
                    ->run();
            //volvemos a remplazar sobre lo remplazado para ubicar la llave primaria y permita que funcione el metodo update and delete
            $this->taskReplaceInFile($file)
            ->from(array('%primaryKey%'))
            ->to([$this->primaryKey])
            ->run();
            $this->say("<info>Controlador creado en {$file}</info>");
        } else {
            $this->say("<error>Controlador ya existía en {$file}</error>");
        }
    }
    private function createView($viewName,$inputs_view){
        $inputs = $inputs_view;
        $vName = strtolower($viewName);
        $folderName = $vName;
        //create the objet buildForm for casting the input to HTML format
        $fm = new BuildForm(); 
        // creo un div para cada input
        $fm->setInputs($inputs);
        $inputsHTML = $fm->configLayout();
        $file_add = "views/{$folderName}/add.php";
        $fs = new Filesystem();
        if (!$fs->exists("views/{$folderName}")) {
            $fs->mkdir("views/{$folderName}");
        }
        if (!$fs->exists($file_add)) {
            $this->say("<info>Creando vista add.php</info>");
            //create file
            $fs->touch($file_add);
            $this->taskWriteToFile($file_add)
                ->textFromFile("roboigniter/template_jchtml/{$this->template}/views/{$this->type_pattern}/add.php")
                ->run();
            //replace elements
            $reemplazar = array('%Inputs%','%Controller%');
            $reemplazo = array(
                    $inputsHTML,
                    $viewName,
            );
            $this->taskReplaceInFile($file_add)
                    ->from($reemplazar)
                    ->to($reemplazo)
                    ->run();
            //volvemos a remplazar sobre lo remplazado para ubicar la llave primaria y permita que funcione como un formulario para update
            $this->taskReplaceInFile($file_add)
                    ->from(array('%primaryKey%'))
                    ->to([$this->primaryKey])
                    ->run();
            $this->say("<info>Vista creada en {$file_add}</info>");
        } else {
            $this->say("<error>Vista ya existía en {$file_add}</error>");
        }
        //view update
        $file_update = "views/{$folderName}/update.php";
        $fs = new Filesystem();
        $fm->setInputs($inputs);
        $inputsHTML = $fm->configLayout('update');
        if (!$fs->exists($file_update)) {
            $this->say("<info>Creando vista update.php</info>");
            //create file
            $fs->touch($file_update);
            $this->taskWriteToFile($file_update)
                ->textFromFile("roboigniter/template_jchtml/{$this->template}/views/{$this->type_pattern}/update.php")
                ->run();
            //replace elements
            $reemplazar = array('%Inputs%','%Controller%');
            $reemplazo = array(
                    $inputsHTML,
                    $viewName,
            );
            $this->taskReplaceInFile($file_update)
                    ->from($reemplazar)
                    ->to($reemplazo)
                    ->run();
            //volvemos a remplazar sobre lo remplazado para ubicar la llave primaria y permita que funcione como un formulario para update
            $this->taskReplaceInFile($file_update)
                    ->from(array('%primaryKey%'))
                    ->to([$this->primaryKey])
                    ->run();
            $this->say("<info>Vista creada en {$file_update}</info>");
        } else {
            $this->say("<error>Vista ya existía en {$file_update}</error>");
        }
        $codeshow = $fm->embebCodeToViewShow();
        $file_show = "views/{$folderName}/show.php";
        $fs = new Filesystem();
        if (!$fs->exists($file_show)) {
            $this->say("<info>Creando vista show.php</info>");
            //crear archivo
            $fs->touch($file_show);
            $this->taskWriteToFile($file_show)
                ->textFromFile("roboigniter/template_jchtml/{$this->template}/views/{$this->type_pattern}/show.php")
                ->run();
            //reemplazar elementos
            $reemplazar = array('%Thead%','%Tbody%');
            $reemplazo = array(
                    $codeshow['thead'],
                    $codeshow['tbody'],
            );
            $this->taskReplaceInFile($file_show)
                    ->from($reemplazar)
                    ->to($reemplazo)
                    ->run();
            //volvemos a remplazar sobre lo remplazado para ubicar la llave primaria en los botones edit y delete
            $this->taskReplaceInFile($file_show)
                    ->from(array('%primaryKey%'))
                    ->to([$this->primaryKey])
                    ->run();
            $this->say("<info>Vista creada en {$file_show}</info>");
        } else {
            $this->say("<error>Vista ya existía en {$file_show}</error>");
        }
    }
    private function createFileView(){

    }
    public function cgCreateView($viewName = ''){
        if($viewName === '') 
        $viewName = strtolower($this->nombre_patron);
        $inputs = $this->createInputs();      
        $this->createView($viewName,$inputs);
    }
    private function createInputs(){
        $input =[];
        $label = '';
        $this->say("<info>___________________________________________________________</info>");
        $this->say("<info>Crearemos los inputs para el formulario</info>");
        $continuar = true;
        $type = 'text';
        $inputName = '';
        $options=[];
        do{
            $inputName = trim($this->ask("<info>Por favor escribe el nombre del input. Debe ser el mismo nombre al campo de tabla de la base de datos </info>"));
            do{
                $this->say("<info>Selecciona el tipo de input</info>");
                $this->say("<info>1. type:text</info>");
                $this->say("<info>2. type:password</info>");
                $this->say("<info>3. type:number</info>");
                $this->say("<info>4. type:email</info>");
                $this->say("<info>5. type:tel</info>");
                $this->say("<info>6. type:date</info>");
                $this->say("<info>7. type:checkbox</info>");
                $this->say("<info>8. type:radio</info>");
                $this->say("<info>9. type:select</info>");
                $select_type = $this->ask("<info>Escoge el type del input</info>");
                switch($select_type){
                    case '1' :
                        $type = 'text';
                        $select_type = false;
                        break;
                    case '2' :
                        $type = 'password';
                        $select_type = false;
                        break;
                    case '3' :
                        $type = 'number';
                        $select_type = false;
                        break;
                    case '4' :
                        $type = 'email';
                        $select_type = false;
                        break;
                    case '5' :
                        $type = 'tel';
                        $select_type = false;
                        break;
                    case '6' :
                        $type = 'date';
                        $select_type = false;
                        break;
                    case '7' :
                        $type = 'checkbox';
                        $select_type = false;
                        break;
                    case '8' :
                        $type = 'radio';
                        $select_type = false;
                        break;
                    case '9' :
                        $type = 'select';
                        $select_type = false;
                        break;
                    default :
                        $select_type = true;
                        break;
                }
            }while($select_type);
            $label = trim($this->ask("<info>Escriba la etiqueta (label) del input</info>"));
            $required = strtolower($this->ask("<info>¿Es esta entrada requerida?(si/no)(s/n)</info>"));
            if($required === 's' || $required === 'si'){
                $required = 'required';
            }
            if($type === 'radio' || $type === 'select'){
                $selec_option = true;
                do{
                    $label_option = trim($this->ask("<info>Escriba la etiqueta (label) o nombre del radio input</info>"));
                    $valor_option = trim($this->ask("<info>Escriba el valor del ".$type." input</info>"));
                    array_push($options,[$label_option => $valor_option]);
                    $selec_option = strtolower($this->ask("<info>¿Deseas crear otro input radio? (si/no) (s/n)</info>"));
                    if($selec_option === 'n' || $selec_option === 'no' ){
                        $selec_option = false;
                    } 
                }while($selec_option);
                array_push($input,['type'=>$type,'name'=>$inputName,'required'=>$required,'options'=>$options,'label' => $label]);
            }else{
                array_push($input,['type'=>$type,'name'=>$inputName,'id'=>'id_'.$inputName,'required'=>$required,'label' => $label,'placeholder' => $label]);
            }
            $continuar = strtolower($this->ask("<info>¿Deseas crear otro input? (si/no) (s/n)</info>"));
            if($continuar === 'n' || $continuar === 'no' ){
                $continuar = false;
            }
        }while($continuar);
        return $input;
    }
}
?>