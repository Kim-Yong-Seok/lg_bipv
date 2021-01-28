<div class="inner-item">
    <ul class="list-thumbnail">
        <?php
        require_once('../server/config.php');

        $query = "SELECT * FROM `b_bipv_color` WHERE `c_approval`='N' ORDER BY `c_insert_datetime` DESC;";
        $result = $conn->query( $query );

        if( isset( $result ) && $result->num_rows > 0 ) {
            while( $res = $result->fetch_array(MYSQLI_ASSOC) ) {
                ?>
                    <li>
                        <dl onclick="location.href='./project_preview.php?id=<?=$res['c_no']?>'">
                            <dd style="background: <?=$res['c_surface_hex_code']?>;"></dd>
                            <dt class="ellipsis"><?=$res['c_color_name']?></dt>
                        </dl>
                    </li>
                <?php
            }
        }
        ?>
    </ul>
</div>
