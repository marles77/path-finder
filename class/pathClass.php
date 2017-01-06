<?php
    
    //require $_SERVER['DOCUMENT_ROOT'].'/a_path_finder/model/input.php';
    //http://gregtrowbridge.com/a-basic-pathfinding-algorithm/
/**
 * Description of pathFinderClass
 *
 * @author Martinez
 * 
 * This class implements an algorithm which finds the shortest path from point A
 * to point B on a 2D grid. The basic method has one argument of an array type
 * which is a grid of fields marked as start point, end point, obstacles, and 
 * empty fields. 
 *  
 */
class pathFinderClass {
    
    public $fPath = array();
    public $sPoint = array();
    
    public function __construct(){
        
    }
    
    public function __get($name){
        return $this->$name;
    }
    
    public function __set($name, $value){
        $this->$name = $value;
    }
    
    //metoda odczytująca pojedynczą mapę i punkt startowy
    public function markMap($inputMap){
        
        $num_rows= count($inputMap);
        $num_cols= count($inputMap[0]); 
       
        //$grid = array($num_rows, $num_cols);
   
        //wyszukiwanie punktu startowego na mapie
        $startPoint = [];
        for($i=0; $i< $num_rows; $i++){
            if($startPoint != null){
                break;
            }else{
                for($j=0; $j < $num_cols; $j++){
                    if($inputMap[$i][$j]=='s'){
                        $startPoint = array($i, $j);
                        break;
                    }
                }
            }
        }
        //zaczynamy szukać ścieżki
        $resultMap = $this->findPath($startPoint, $inputMap);
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
        /*var_dump($queue);
        echo '<br>';
        
        $currLocation = array_shift($queue);
        var_dump($queue);*/
        
        $countQ = count($queue);
        //pętla wyszukująca mety
        $count = 0;
        while($countQ > 0){
            $count++;
            
            $currLocation = array_shift($queue);
            $directions = ['Up', 'Right', 'Down', 'Left'];
            foreach($directions as $dir){
                $newLocation = $this->exploreInDirection($currLocation, $dir, $inputMap); 
                if($newLocation['status'] == 'meta') {
                    /*
                    echo 'count: '.$count.'<br>';
                    var_dump($newLocation['path']);
                    echo '<br>';
                    var_dump($inputMap);
                    return $newLocation['path'];*/
                    $resultMap = $this->returnPathGrid($startPoint, $newLocation['path'], $inputMap);
                    return $resultMap;
                }elseif($newLocation['status'] == 'valid'){
                    array_push($queue, $newLocation);
                }
            }
            $countQ = count($queue);
        }
        //ścieżka nie znaleziona
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
    private function exploreInDirection($currLocation, $direction, $inputMap){ //to do: tu cos nie dziala nie widzi tablic
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
        }else if($inputMap[$dft][$dfl]=='m'){
            return 'meta';
        }else if($inputMap[$dft][$dfl]!= ' '){
            return'block';
        }else{
            return 'valid';
        }
        
    }
}
