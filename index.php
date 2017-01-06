<?php
    //załadowanie tablicy input oraz klasy szukającej ścieżki
    require 'model/input.php';
    require 'class/pathFinderClass.php';
    require 'config/config.php';
    
    $resultMap = [];
    $pathLen = 0;
    //sprawdzamy numer mapy przekazany w tablicy GET
    $map_num = 0;
    if(filter_input(INPUT_GET, "map_num")!=""){
        $map_num = filter_input(INPUT_GET, "map_num", FILTER_SANITIZE_NUMBER_INT);
        $oneMap = new pathFinderClass;
        $i=0;
        $map_title= '';
        foreach($input as $map=>$data){
          $i++;
          if($i == $map_num){
              $map_title= $map;
              break;
          }
        }
        
        $resultMap = $oneMap->startSearch($input[$map_title]);
        $pathLen = ''.count($oneMap->fPath);
        /*var_dump($oneMap->sPoint);
        echo '<br>';
        var_dump($oneMap->fPath);
        echo '<br>';
        var_dump($resultMap);*/
    }
    
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>PathFinder</title>
        <link rel="stylesheet" href="style/style.css">
        <script>
            var map_num = <?= $map_num ?>;
        </script>    
    </head>
    <body>
        <div id="pack">
            <div class="header">
                <h1>Example of pathFinderClass</h1>
            </div>
            <!-- oryginalne mapy -->
            <?php include('pages/originalMaps.php'); ?>
            
            <?php if($resultMap != null && $resultMap != false): ?>
            <!-- mapa wynikowa -->
            <?php include('pages/resultMap.php'); ?>
            <?php endif; ?>
            
            <?php include('pages/foot.php'); ?>    
        </div>
        <script src="script/script.js"></script>
    </body>
</html>
