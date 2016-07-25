<?php
require_once('DBClass.php');

$_SESSION['count'] = time();

class captcha{
public $image;
public function display()
{
    ?>

        <div style="display:block;margin-bottom:20px;margin-top:20px;">
            <img src="captcha\image<?php echo $_SESSION['count'] ?>.png">
        </div>
<?php
}

public function create_image()
{
    global $image;
    $image = imagecreatetruecolor(200, 50) or die("Cannot Initialize new GD image stream");

    $background_color = imagecolorallocate($image, 255, 255, 255);
    $text_color = imagecolorallocate($image, 0, 255, 255);
    $line_color = imagecolorallocate($image, 64, 64, 64);
    $pixel_color = imagecolorallocate($image, 0, 0, 255);

    imagefilledrectangle($image, 0, 0, 200, 50, $background_color);

    for ($i = 0; $i < 3; $i++) {
        imageline($image, 0, rand() % 50, 200, rand() % 50, $line_color);
    }

    for ($i = 0; $i < 1000; $i++) {
        imagesetpixel($image, rand() % 200, rand() % 50, $pixel_color);
    }


    $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $len = strlen($letters);
    $letter = $letters[rand(0, $len - 1)];

    $text_color = imagecolorallocate($image, 0, 0, 0);
    $word = "";
    for ($i = 0; $i < 6; $i++) {
        $letter = $letters[rand(0, $len - 1)];
        imagestring($image, 7, 5 + ($i * 30), 20, $letter, $text_color);
        $word .= $letter;
    }
    $_SESSION['captcha_string'] = $word;

    $images = glob("captcha\*.png");
    foreach ($images as $image_to_delete) {
        @unlink($image_to_delete);
    }
    
    $expiration = time()- 60; 
	// Two hour limit
    $db_class = new DBClass();
    $db_class->_delete_where('captcha','captcha_time < ',$expiration);
    
    $data['captcha_time']=time();
    $data['ip_address']=$_SERVER['SERVER_ADDR'];
    $data['word']=$_SESSION['captcha_string'];
    $db_class = new DBClass();
    $db_class->_insert('captcha',$data);
    
    
    imagepng($image, "captcha\image" . $_SESSION['count'] . ".png");
    
}

}