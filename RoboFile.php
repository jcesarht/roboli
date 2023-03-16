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
                        $this->say('<info>Generando archivos</info>');
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
            $this->say("<info>Controlador creado en {$file}</info>");
        } else {
            $this->say("<error>Controlador ya existía en {$file}</error>");
        }
    }
    private function createView($viewName,$inputs_view){
        $inputs = $inputs_view;
        $vName = strtolower($viewName);
        $folderName = $vName;
        //creao el objeto buildForm para pasar los input a formato HTML
        $fm = new BuildForm(); 
        // creo un div para cada input
        $fm->setInputs($inputs);
        $inputsHTML = $fm->configLayout();
        $file = "views/{$folderName}/add.php";
        $fs = new Filesystem();
        if (!$fs->exists("views/{$folderName}")) {
            $fs->mkdir("views/{$folderName}");
        }
        if (!$fs->exists($file)) {
            $this->say("<info>Creando vista add.php</info>");
            //crear archivo
            $fs->touch($file);
            $this->taskWriteToFile($file)
                ->textFromFile("roboigniter/template_jchtml/{$this->template}/views/{$this->type_pattern}/add.php")
                ->run();
            //reemplazar elementos
            $reemplazar = array('%Inputs%');
            $reemplazo = array(
                    $inputsHTML,
            );
            $this->taskReplaceInFile($file)
                    ->from($reemplazar)
                    ->to($reemplazo)
                    ->run();
            $this->say("<info>Vista creada en {$file}</info>");
        } else {
            $this->say("<error>Vista ya existía en {$file}</error>");
        }
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
        do{
            $inputName = trim($this->ask("<info>Por favor escribe el nombre del input. Debe ser el mismo nombre al campo de tabla de la base de datos </info>"));
            do{
                $this->say("<info>Selecciona el tipo de input</info>");
                $this->say("<info>1. type:text</info>");
                $this->say("<info>2. type:password</info>");
                $this->say("<info>3. type:number</info>");
                $this->say("<info>4. type:date</info>");
                $this->say("<info>5. type:checkbox</info>");
                $this->say("<info>6. type:radio</info>");
                $this->say("<info>7. type:select</info>");
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
                        $type = 'date';
                        $select_type = false;
                        break;
                    case '5' :
                        $type = 'checkbox';
                        $select_type = false;
                        break;
                    case '6' :
                        $type = 'radio';
                        $select_type = false;
                        break;
                    case '7' :
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
            array_push($input,['type'=>$type,'name'=>$inputName,'id'=>'id_'.$inputName,'required'=>$required,'label' => $label,'placeholder' => $label]);
            $continuar = strtolower($this->ask("<info>¿Deseas crear otro input? (si/no) (s/n)</info>"));
            if($continuar === 'n' || $continuar === 'no' ){
                $continuar = false;
            }
        }while($continuar);
        return $input;
    }
}
?>