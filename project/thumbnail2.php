<?php
require_once('../server/config.php');

$query = "SELECT * FROM `b_bipv_color` WHERE `c_approval`='N' ORDER BY `c_insert_datetime` DESC;";
$result = $conn->query( $query );

$colors = array();
$size = 0;
if( isset($result) && $result->num_rows > 0 ) {
    while( $res = $result->fetch_array(MYSQLI_ASSOC) ) {
        $flag = false;

        for( $i=0; $i<$size; $i++ ) {
            if( $colors[$i] == $res['c_target_hex_code'] ) {
                $flag = true;
            }
        }
        if( !$flag ) {
            $colors[$size] = $res['c_target_hex_code'];
            $size++;
        }
    }

    $cnt = 1;
    for( $i=0; $i<$size; $i++ ) {
        ?>
        <div class="inner-item">
            <div class="tit <?=$i==0 ? 'active' : ''?>">
                <a href="#a">
                    <h2 style="color: <?=$colors[$i]?>;"><?=$colors[$i]?></h2>
                </a>
            </div>
            <ul class="list-thumbnail <?=$i==0 ? 'active' : ''?>">
                <?php
                    $query = "SELECT * FROM `b_bipv_color` WHERE `c_target_hex_code`='$colors[$i]' and `c_approval`='N';";
                    $result = $conn->query( $query );
                    
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
                ?>
            </ul>
        </div>
        <?php
    }
}
?>
<script type="text/javascript">
    $('.tit a').click(function(){
		$(this).parent().toggleClass('active');
		$(this).parent().siblings('ul').toggleClass('active');
	});
</script>