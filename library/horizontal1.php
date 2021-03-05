<div class="inner-item">
    <ul class="list-horizontal">
        <?php
        require_once('../server/config.php');

        $query = "SELECT * FROM `b_bipv_color` WHERE `c_approval`='Y' ORDER BY `c_no` DESC;";
        $result = $conn->query( $query );

        if( isset( $result ) && $result->num_rows > 0 ) {
            $cnt = 1;
            while( $res = $result->fetch_array(MYSQLI_ASSOC) ) {
                ?>
                    <li>
                        <dl style="background: <?=$res['c_target_hex_code']?>;" onclick="location.href='./project_preview.php?id=<?=$res['c_no']?>'" class="lists">
                            <dd class="check" style="display: none;">
                                <div class="chkwrap checkBox" style="display: none;">
                                    <input type="checkbox" id="check<?=$cnt?>" name="check_<?=$res['c_no']?>">
                                    <label for="check<?=$cnt?>" class="text"></label>
                                </div>
                            </dd>
                            <dt><?=$res['c_color_name']?></dt>
                            <dd><?=$res['c_target_hex_code']?></dd>
                        </dl>
                    </li>
                <?php
                $cnt++;
            }
        }
        ?>
    </ul>
</div>