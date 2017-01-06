<?php
    //załadowanie tablicy input oraz klasy szukającej ścieżki i kofiguracji
    require 'model/input.php';
    require 'class/pathFinderClass.php';
    require 'config/config.php';
    
    $resultMap = [];
    $pathLen = 0;
    //sprawdzamy numer mapy przekazany w tablicy GET
    $map_num = 0;
    if(filter_input(INPUT_GET, "map_num")!=""){
        $map_num = filter_input(INPUT_GET, "map_num", FILTER_SANITIZE_NUMBER_INT);
        if($map_num!= "" && $map_num > 0 && $map_num <= count($input)){
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
            //przekazujemy mapę wynikową z obiektu
            $resultMap = $oneMap->startSearch($input[$map_title]);
            //pobieramy długość ścieżki
            $pathLen = ''.count($oneMap->fPath);
        }
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
            <a id="reload" href="index.php">Reload</a>
            <div class="header">
                <h1>Example of pathFinderClass</h1>
            </div>
            <!-- oryginalne mapy -->
            <?php include('pages/originalMaps.php'); ?>
            <?php if($resultMap != null && $resultMap != false): ?>
            <!-- mapa wynikowa -->
            <?php include('pages/resultMap.php'); ?>
            <?php endif; ?>
            <!-- stopka -->
            <?php include('pages/foot.php'); ?>    
        </div>
        <script src="script/script.js"></script>
    </body>
</html>
