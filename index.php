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
            <?php 
                $map_num = 0;
                foreach($input as $map=>$data):
                $map_num++;    ?>
            <section>
                <div class="map">
                    <h3><?= $map ?></h3>
                    
                    <table>
                        
                        <?php 
                            $num_rows= count($data);
                            for($i= 0; $i<$num_rows; $i++): ?>
                                <tr>
                                    
                                    <?php
                                        $num_cols= count($data[$i]);
                                        for($j= 0; $j<$num_cols; $j++){
                                            switch($data[$i][$j]){
                                                case 's': 
                                                          echo '<td class="map_start">s</td>';
                                                          break;
                                                case 'm': 
                                                          echo '<td class="map_meta">m</td>';
                                                          break;
                                                case 'x': 
                                                          echo '<td>x</td>';
                                                          break;
                                                case ' ':  echo '<td></td>';
                                                          break;
                                                default:  echo '<td class="map_path"></td>';     
                                            }
                                        }
                                    ?>
                                    
                                </tr>
                        <?php endfor ?>
                    </table>
                    
                    
                </div>
                <div class="a_wrap">
                    <!-- przekazujemy numer mapy metodą GET -->
                    <a href="?map_num=<?= $map_num ?>">Find path > </a>
                </div>
            </section>
                    
            <?php endforeach; ?>
            
            <?php if($resultMap != null && $resultMap != false): ?>
            <!-- mapa wynikowa -->
            <div class="map" id="result_map">
                    <h3>Mapa wynikowa</h3>
                    <table>
                        <?php 
                            $num_rows= count($resultMap);
                            for($i= 0; $i<$num_rows; $i++): ?>
                                <tr>
                                    
                                    <?php
                                        $num_cols= count($resultMap[$i]);
                                        for($j= 0; $j<$num_cols; $j++){
                                            switch($resultMap[$i][$j]){
                                                case '0': 
                                                          echo '<td class="map_start">0</td>';
                                                          break;
                                                case $pathLen: 
                                                          echo '<td class="map_meta">'.$pathLen.'</td>';
                                                          break;
                                                case 'x': 
                                                          echo '<td>x</td>';
                                                          break;
                                                case ' ':  echo '<td></td>';
                                                          break;
                                                default:  echo '<td class="map_path">'.$resultMap[$i][$j].'</td>';     
                                            }
                                        }
                                    ?>
                                    
                                </tr>
                        <?php endfor ?>
                    </table>
                </div>
            <?php endif; ?>
            
                
        </div>
        <script src="script/script.js"></script>
    </body>
</html>
