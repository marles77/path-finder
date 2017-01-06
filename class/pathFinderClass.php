<?php
    
    //require $_SERVER['DOCUMENT_ROOT'].'/a_path_finder/model/input.php';
    //http://gregtrowbridge.com/a-basic-pathfinding-algorithm/
/**
 * Description of pathFinderClass
 *
 * @author Martinez
 * 
 * W klasie zaimplementowano algorytm (rodzaj algorytmu Dijkstry) znajdujący 
 * najkrótszą ścieżkę z punktu początkowego do końcowego omijajaca przeszkody na
 * dwuwymiarowej siatce.
 * Podstawowa metoda przyjmuje jeden argument w postaci tablicy reprezentujacej
 * siatke pól oznaczonych jako start, end, empty lub obstacle. Metoda zwraca
 * tablicę wynikową będącą kopią oryginalnej mapy z zaznaczoną ścieżką. Klasa 
 * daje również dostęp do tablicy z poszczególnymi krokami (jako kierunki), 
 * tablicy reprezentującej punkt początkowy oraz liczbę iteracji potrzebnych do
 * osiągnięcia punktu docelowego.
 *  
 */
class pathFinderClass {
    
    private $_start;
    private $_end;
    private $_obstacle;
    private $_empty;
    
    public $fPath = array();   //ścieżka wynikowa
    public $sPoint = array();  //punkt początkowy
    public $nIterations;       //liczba iteracji 
    
    public function __construct(){
        //oznaczenia punktów na mapie zdefiniowane w pliku config.php
        $this->_start = __START__;
        $this->_end = __END__;
        $this->_obstacle = __OBSTACLE__;
        $this->_empty = __EMPTY__;
    }
    
    public function __get($name){
        return $this->$name;
    }
    
    public function __set($name, $value){
        $this->$name = $value;
    }
    
    //metoda odczytująca pojedynczą mapę i punkt startowy
    public function startSearch($inputMap){
        
        $num_rows= count($inputMap);
        $num_cols= count($inputMap[0]); 
       
        //wyszukiwanie punktu startowego na mapie
        $startPoint = [];
        for($i=0; $i< $num_rows; $i++){
            if($startPoint != null){
                break;
            }else{
                for($j=0; $j < $num_cols; $j++){
                    if($inputMap[$i][$j]=== $this->_start){
                        $startPoint = array($i, $j);
                        break;
                    }
                }
                //jeśli nie ma punktu startowego
                if($i==$num_rows-1){
                    echo 'Sorry, I could not find the start point on the map.';
                    return false;
                }
            }
        }
        //zaczynamy szukać ścieżki
        $resultMap = $this->findPath($startPoint, $inputMap);
        //i zwracamy mapę wynikową
        return $resultMap;
    }
    
    //metoda wyszukująca najkrótszą ścieżkę
    private function findPath($startPoint, $inputMap){
        
        $distFromTop = $startPoint[0];
        $distFromLeft = $startPoint[1];
        $location = array(
            'distFromTop'=>$distFromTop,
            'distFromLeft'=>$distFromLeft,
            'path'=>[],
            'status'=>'start'
        );
        
        $queue = array($location);
        $countQ = count($queue);
        //pętla szukująca mety
        $count = 0;
        while($countQ > 0){
            $count++;
            
            $currLocation = array_shift($queue);
            $directions = ['Up', 'Right', 'Down', 'Left'];
            $countD=0;
            foreach($directions as $dir){
                $countD++;
                $newLocation = $this->exploreDirection($currLocation, $dir, $inputMap); 
                if($newLocation['status'] == 'meta') {
                    $this->nIterations = $count;
                    $resultMap = $this->returnPathGrid($startPoint, $newLocation['path'], $inputMap);
                    return $resultMap;
                }elseif($newLocation['status'] == 'valid'){
                    array_push($queue, $newLocation);
                }
            }
            $countQ = count($queue);
            if($count > 500){
                break;
            }
        }
        //ścieżka nie znaleziona
        echo 'Sorry, I could not find any path.'.$countQ;
        return false;
    }
    
    //metoda zwracająca tablicę ze ścieżką
    private function returnPathGrid($startPoint, $finalPath, $inputMap){
        $this->fPath = $finalPath;
        $this->sPoint = $startPoint;
        $pathGrid= $inputMap;
        $fp_length= count($finalPath);
        $pathRow = $startPoint[0];
        $pathCol = $startPoint[1];
        $pathGrid[$pathRow][$pathCol] = '0';
        //pętla wpisująca kolejne kroki ścieżki do tablicy wynikowej
        for($i = 0; $i < $fp_length; $i++){
            
            switch($finalPath[$i]){
                case 'Up':
                    $pathRow--;
                    break;
                case 'Right':
                    $pathCol++;
                    break;
                case 'Down':
                    $pathRow++;
                    break;
                case 'Left': 
                    $pathCol--;
                    break;
                default: 
                    $pathRow = $pathRow;
                    $pathCol = $pathCol;
            }
            $num = $i+1;
            $pathGrid[$pathRow][$pathCol] = ''.$num;
        }
        
        return $pathGrid;
    }
    
    //metoda dodająca nową pozycję
    private function exploreDirection($currLocation, $direction, $inputMap){
        $newPath = array_splice($currLocation['path'], 0);
        array_push($newPath, $direction);
        $dft = $currLocation['distFromTop'];
        $dfl = $currLocation['distFromLeft'];
        
        switch($direction){
            case 'Up': 
                $dft -=1;
                break;
            case 'Right': 
                $dfl +=1;
                break;
            case 'Down': 
                $dft +=1;
                break;
            case 'Left': 
                $dfl -=1;
                break;
            default: 
                $dfl = $dfl;
                $dft = $dft;
        }
        
        $newLocation= array(
            'distFromTop'=>$dft,
            'distFromLeft'=>$dfl,
            'path'=>$newPath,
            'status'=>'unknown'
        );
        
        $newLocation['status']= $this->locationStatus($newLocation, $inputMap);
        if($newLocation['status']== 'valid'){
            $row= $newLocation['distFromTop'];
            $col= $newLocation['distFromLeft'];
            $inputMap[$row][$col] = 'visited';
        }
        
        return $newLocation;
    }
    
    //metoda zwracająca status pozycji
    private function locationStatus($location, $inputMap){
        
        $num_rows= count($inputMap);
        $num_cols= count($inputMap[0]); 
        
        $dft = $location['distFromTop'];
        $dfl = $location['distFromLeft'];
        
        if($location['distFromLeft'] < 0 || 
           $location['distFromLeft'] >= $num_cols || 
           $location['distFromTop'] < 0 || 
           $location['distFromTop'] >= $num_rows){
            return 'invalid';
        }else if($inputMap[$dft][$dfl]=== $this->_end){
            return 'meta';
        }else if($inputMap[$dft][$dfl]!= $this->_empty){
            return 'block';
        }else{
            return 'valid';
        }
        
    }
}

//end of pathfinderClass