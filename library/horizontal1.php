<div class="inner-item">
    <ul class="list-horizontal">
        <?php
        require_once('../server/config.php');

        $query = "SELECT * FROM `b_bipv_color` WHERE `c_approval`='Y' ORDER BY `c_insert_datetime` DESC;";
        $result = $conn->query( $query );

        if( isset( $result ) && $result->num_rows > 0 ) {
            while( $res = $result->fetch_array(MYSQLI_ASSOC) ) {
                ?>
                    <li>
                        <dl style="background: <?=$res['c_surface_hex_code']?>;" onclick="location.href='./project_preview.php?id=<?=$res['c_no']?>'">
                            <dt><?=$res['c_color_name']?></dt>
                            <dd class="ellipsis"><?=$res['c_surface_hex_code']?></dd>
                        </dl>
                    </li>
                <?php
            }
        }
        ?>
    </ul>
</div>