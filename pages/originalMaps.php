<!-- oryginalne mapy -->
<?php
$map_num = 0;
foreach ($input as $map => $data):
    $map_num++;
    ?>
    <section>
        <div class="map">
            <h3><?= $map ?></h3>

            <table>

                <?php
                $num_rows = count($data);
                for ($i = 0; $i < $num_rows; $i++):
                    ?>
                    <tr>

                        <?php
                        $num_cols = count($data[$i]);
                        for ($j = 0; $j < $num_cols; $j++) {
                            switch ($data[$i][$j]) {
                                case 's':
                                    echo '<td class="map_start">s</td>';
                                    break;
                                case 'm':
                                    echo '<td class="map_meta">m</td>';
                                    break;
                                case 'x':
                                    echo '<td>x</td>';
                                    break;
                                case ' ': echo '<td></td>';
                                    break;
                                default: echo '<td class="map_path"></td>';
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



