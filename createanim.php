<?php
set_time_limit( 5 * 60 );

function check_int_input( $data, $default_value )
{
	if( strval(intval($data)) == strval($data) )
		return intval( $data );
	else
		return $default_value;
}

$size = check_int_input( $_POST['size'], 64 );
$minXAngle = check_int_input( $_POST['minXAngle'], -90 );
$maxXAngle = check_int_input( $_POST['maxXAngle'], 90 );
$stepsX = check_int_input( $_POST['stepsX'], 11 );
$minYAngle = check_int_input( $_POST['minYAngle'], -45 );
$maxYAngle = check_int_input( $_POST['maxYAngle'], 45 );
$stepsY = check_int_input( $_POST['stepsY'], 5 );

$format = $_POST['format'];
$quality = check_int_input( $_POST['quality'], 2 );
$compression = check_int_input( $_POST['compression'], 75 );

if( !is_uploaded_file( $_FILES['jsurffile']['tmp_name'] ) )
	die( "no jsurf file given" );
$surface_name = basename( $_FILES['jsurffile']['name'], '.jsurf' );

if( $format == 'PNG' )
{
	$extension = '.png';
}
else if( $format == 'GIF' )
{
	$extension = '.gif';
}
else
{	// assume jpg
	$format = 'JPG';
        $extension = '.jpg';
}

// make sure the 'pics' dir is writable
$img_filename_rel = exec( "mktemp -p pics \"{$surface_name}_tiles_{$stepsY}x{$stepsX}_XXXXXX\"" );
exec( "mv {$img_filename_rel} {$img_filename_rel}{$extension}" );
$img_filename_rel = "{$img_filename_rel}{$extension}";
$img_filename_abs = exec( "readlink -f \"{$img_filename_rel}\"" );
$cmd_line = "bash createanim.sh {$compression} {$img_filename_abs} --size {$size} --minXAngle {$minXAngle} --maxXAngle {$maxXAngle} --stepsX {$stepsX} --minYAngle {$minYAngle} --maxYAngle {$maxYAngle} --stepsY {$stepsY} --quality {$quality} \"{$_FILES['jsurffile']['tmp_name']}\"";
exec( $cmd_line );
?>
<!DOCTYPE html>
<!-- $img_filename_rel=<?php echo $img_filename_rel; ?> -->
<!-- $img_filename_abs=<?php echo $img_filename_abs; ?> -->
<!-- $cmd_line=<?php echo $cmd_line; ?> -->
<html>
  <head>
    <title>Surfer2jQueryReel</title>
    <meta charset='utf-8' content='text/html' http-equiv='Content-type' />
    <script src='js/jquery-1.7.min.js' type='text/javascript'></script>
    <script src='js/jquery.reel-min.js' type='text/javascript'></script>
  </head>
  <body>
    <div align="center">
    <br/>
    <img id="image" src='<?php echo $img_filename_rel;?>' width="<?php echo $size;?>" height="<?php echo $size;?>" />
    <script>
      $(function(){ // when DOM ready

        $('#image').reel({
          indicator:   5, // For no indicator just remove this line
          frames:      <?php echo $stepsY; ?>,
          frame:       <?php echo intval(($stepsY+1)/2); ?>,
<?php if( $stepsX > 1 ) {?>
	  footage:    <?php echo $stepsY; ?>,
          rows:        <?php echo $stepsX; ?>,
          row:         <?php echo intval(($stepsX+1)/2); ?>,
<?php } ?>
	  image: 	"<?php echo $img_filename_rel;?>",
	  loops: false
        });

      });
    </script>
    <br/>
    <a href="<?php echo $img_filename_rel;?>">Download image</a>
    </div>
  </body>
</html>

