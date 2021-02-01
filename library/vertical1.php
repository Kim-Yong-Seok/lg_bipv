<div class="inner-item">
    <ul class="list-vertical">
        <?php
            require_once('../server/config.php');

            $query = "SELECT * FROM `b_bipv_color` WHERE `c_approval`='Y' ORDER BY `c_insert_datetime` DESC;";
            $result = $conn->query( $query );

            if( isset($result) && $result->num_rows > 0 ) {
                $i = 1;
                while( $res = $result->fetch_array(MYSQLI_ASSOC) ) {
                    ?>
                    <li onclick="location.href='./project_preview.php?id=<?=$res['c_no']?>'" class="lists">
                        <div class="title">
                            <div class="chkwrap checkBox" style="display: none;">
                                <input type="checkbox" id="check<?=$i?>" name="check_<?=$res['c_no']?>">
                                <label for="check<?=$i?>" class="text"></label>
                            </div>
                            <?=$res['c_color_name']?>
                        </div>
                        <dl class="color_area">
                            <dd class="color_box" style="background-color: <?=$res['c_target_hex_code']?>;" id="vertical_target<?=$i?>" name="<?=$res['c_target_hex_code']?>"></dd>
                            <dt class="ellipsis">Target Color</dt>
                            <dd class="info_box">
                                <p id="t_lab<?=$i?>"></p>
                                <p id="t_cmyk<?=$i?>"></p>
                                <p id="t_rgb<?=$i?>"></p>
                            </dd>
                        </dl>
                        <!-- <div style="width: 60%; display: inline-block;"> -->
                        <dl class="color_area">
                            <dd class="color_box" style="background-color: <?=$res['c_surface_hex_code']?>;" id="vertical_surface<?=$i?>" name="<?=$res['c_surface_hex_code']?>"></dd>
                            <dt class="ellipsis">Surface Color</dt>
                            <dd class="info_box">
                                <p id="s_lab<?=$i?>"></p>
                                <p id="s_cmyk<?=$i?>"></p>
                                <p id="s_rgb<?=$i?>"></p>
                            </dd>
                        </dl>
                        <dl class="pv_area">
                            <dd class="color_box" style="background-color: #000;"></dd>
                            <dt class="ellipsis">PV</dt>
                            <dd class="info_box">
                                <p>Ratio <?=$res['c_pv']?>%</p>
                            </dd>
                        </dl>
                        <!-- </div> -->
                    </li>
                    <?php
                    $cnt++;
                    $i++;
                }
            }
        ?>
    </ul>
</div>