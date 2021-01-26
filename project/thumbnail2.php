<?php
require_once('../server/config.php');

$query = "SELECT * FROM `b_bipv_color`;";
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

    for( $i=0; $i<$size; $i++ ) {
        ?>
        <div class="inner-item">
            <div class="tit <?=$i==0 ? 'active' : ''?>">
                <a href="#a">
                    <h2><?=$colors[$i]?></h2>
                </a>
            </div>
            <ul class="list-thumbnail <?=$i==0 ? 'active' : ''?>">
                <?php
                    $query = "SELECT * FROM `b_bipv_color` WHERE `c_target_hex_code`='$colors[$i]';";
                    $result = $conn->query( $query );
                    while( $res = $result->fetch_array(MYSQLI_ASSOC) ) {
                        ?>
                        <li>
                            <dl>
                                <dd style="background: <?=$res['c_surface_hex_code']?>;"></dd>
                                <dt class="ellipsis"><?=$res['c_color_name']?></dt>
                            </dl>
                        </li>
                        <?php
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