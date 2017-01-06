<!-- mapa wynikowa -->
<div class="map" id="result_map">
    <h3>Result Map</h3>
    <table>
        <?php
        $num_rows = count($resultMap);
        for ($i = 0; $i < $num_rows; $i++):
            ?>
            <tr>

                <?php
                $num_cols = count($resultMap[$i]);
                for ($j = 0; $j < $num_cols; $j++) {
                    switch ($resultMap[$i][$j]) {
                        case '0':
                            echo '<td class="map_start">0</td>';
                            break;
                        case $pathLen:
                            echo '<td class="map_meta">' . $pathLen . '</td>';
                            break;
                        case 'x':
                            echo '<td>x</td>';
                            break;
                        case ' ': echo '<td></td>';
                            break;
                        default: echo '<td class="map_path">' . $resultMap[$i][$j] . '</td>';
                    }
                }
                ?>

            </tr>
        <?php endfor ?>
    </table>
    <p id="iterations"> Number of iterations: <?= $oneMap->nIterations; ?> </p>
</div>
<br>
<br>
