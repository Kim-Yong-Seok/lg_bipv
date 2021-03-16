<?php
require_once('../server/config.php');

$query = "SELECT * FROM `b_bipv_color` WHERE `c_approval`='N' ORDER BY `c_no` DESC;";
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
    $j = 1;
    for( $i=0; $i<$size; $i++ ) {
        
        ?>
        <div class="inner-item">
            <div class="tit <?=$i==0 ? 'active' : ''?>">
                <a href="#a">
                    <h2 style="color: <?=$colors[$i]?>;"><?=$colors[$i]?></h2>
                </a>
            </div>
            <ul class="list-vertical <?=$i==0 ? 'active' : ''?>">
                <?php
                    $query = "SELECT * FROM `b_bipv_color` WHERE `c_target_hex_code`='$colors[$i]';";
                    $result = $conn->query( $query );
                    
                    while( $res = $result->fetch_array(MYSQLI_ASSOC) ) {
                        ?>
                        <li onclick="location.href='./project_preview.php?id=<?=$res['c_no']?>'" class="lists">
                            <div class="title">
                                <div class="chkwrap checkBox" style="display: none;">
                                    <input type="checkbox" id="check<?=$j?>" name="check_<?=$res['c_no']?>">
                                    <label for="check<?=$j?>" class="text"></label>
                                </div>
                                <?=$res['c_color_name']?>
                            </div>
                            <dl class="color_area">
                                <dd class="color_box" style="background-color: <?=$res['c_target_hex_code']?>;" id="vertical_target<?=$j?>" name="<?=$res['c_target_hex_code']?>"></dd>
                                <dt class="ellipsis">Target Color</dt>
                                <dd class="info_box">
                                    <p id="t_lab<?=$j?>"></p>
                                    <p id="t_cmyk<?=$j?>"></p>
                                    <p id="t_rgb<?=$j?>"></p>
                                </dd>
                            </dl>
                            <!-- <div style="width: 60%; display: inline-block;"> -->
                            <dl class="color_area">
                                <dd class="color_box" style="background-color: <?=$res['c_surface_hex_code']?>;" id="vertical_surface<?=$j?>" name="<?=$res['c_surface_hex_code']?>"></dd>
                                <dt class="ellipsis">Print Color</dt>
                                <dd class="info_box">
                                    <p id="s_lab<?=$j?>"></p>
                                    <p id="s_cmyk<?=$j?>"></p>
                                    <p id="s_rgb<?=$j?>"></p>
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
                        $j++;
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