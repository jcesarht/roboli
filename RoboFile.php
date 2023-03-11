<?php
/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;
class RoboFile extends \Robo\Tasks
{
    //define variable
    private $nombre_patron = '';
    private $tableName = '';
    // define public methods as commands
    public function cgStart(){
        $this->say('<info>Hola. ¿Que deseas hacer?</info>');
        $this->say('<info>1. ¿Crear entorno base bajo la técnica SCAFFOLD para API (Controller + Model)?</info>');
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
                        $this->say('<info>Generando archivos</info>');
                        $this->cgApiScaffoldConsole();
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
    function cgApiScaffoldConsole(){
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
            ->textFromFile("template_robo/tmodel.scaff.php")
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
                ->textFromFile("template_robo/tcontroller.scaff.php")
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
}