<div class="inner-item">
    <ul class="list-thumbnail">
        <?php
        require_once('../server/config.php');

        $query = "SELECT * FROM `b_bipv_color` WHERE `c_approval`='Y' ORDER BY `c_insert_datetime` DESC;";
        $result = $conn->query( $query );

        if( isset( $result ) && $result->num_rows > 0 ) {
            $cnt = 1;
            while( $res = $result->fetch_array(MYSQLI_ASSOC) ) {
                ?>
                    <li>
                        <dl onclick="location.href='./project_preview.php?id=<?=$res['c_no']?>'" class="lists">
                            <dd style="background: <?=$res['c_target_hex_code']?>;">
                                <ul>
                                    <li class="left" style="background: <?=$res['c_surface_hex_code']?>;"></li>
                                    <li class="right" style="background: #000;"></li>
                                </ul>
                                <div class="chkwrap checkBox" style="display: none;">
                                    <input type="checkbox" id="check<?=$cnt?>" name="check_<?=$res['c_no']?>">
                                    <label for="check<?=$cnt?>" class="text"></label>
                                </div>
                            </dd>
                            <dt class="ellipsis"><?=$res['c_color_name']?></dt>
                        </dl>
                    </li>
                <?php
                $cnt++;
            }
        }
        ?>
    </ul>
</div>