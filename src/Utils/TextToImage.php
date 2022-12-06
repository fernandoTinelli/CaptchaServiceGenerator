<?php
/**
 * TextToImage class
 * This class converts text to image
 * 
 * @author    CodexWorld Dev Team
 * @link    http://www.codexworld.com
 * @license    http://www.codexworld.com/license/
 */
class TextToImage {
    private $img;
    
    /**
     * Create image from text
     * @param string text to convert into image
     * @param int font size of text
     * @param int width of the image
     * @param int height of the image
     */
    function createImage($text, $fontSize = 40, $imgWidth = 250, $imgHeight = 80){
        //text font path
        $font = 'fonts/Kingthings_Trypewriter_2.ttf';
        
        //create the image
        $this->img = imagecreatetruecolor($imgWidth, $imgHeight);
        
        //create some colors
        $white = imagecolorallocate($this->img, 245, 240, 204);
        $grey = imagecolorallocate($this->img, 128, 128, 128);
        $black = imagecolorallocate($this->img, 97, 94, 67);
        imagefilledrectangle($this->img, 0, 0, $imgWidth - 1, $imgHeight - 1, $white);
        
        //break lines
        $splitText = explode ( "\\n" , $text );
        $lines = count($splitText);
        
        foreach ($splitText as $txt){
            $textBox = imagettfbbox($fontSize,0,$font,$txt);
            $textWidth = abs(max($textBox[2], $textBox[4]));
            $textHeight = abs(max($textBox[5], $textBox[7]));
            $x = (imagesx($this->img) - $textWidth)/2;
            $y = ((imagesy($this->img) + $textHeight)/2)-($lines-2)*($textHeight/8);
            $lines = $lines-1;
        
            //add some shadow to the text
            imagettftext($this->img, $fontSize, 0, $x, $y, $grey, $font, $txt);
            
            //add the text
            imagettftext($this->img, $fontSize, 0, $x, $y, $black, $font, $txt);
        }

        $this->dirtyImage(200, 40, $black, $imgWidth, $imgHeight);

	    return true;
    }

    public function getImg()
    {
        return $this->img;
    }

    public function showImage() {
        header('Content-Type: image/png');
        return imagepng($this->img);
    }
    
    /**
     * Display image
     */
    public function getBase64(){
        ob_start(); 

        imagejpeg($this->img);

        $image_data = ob_get_contents(); 

        ob_end_clean(); 

        return base64_encode($image_data);
    }
    
    /**
     * Save image as png format
     * @param string file name to save
     * @param string location to save image file
     */
    public function saveAsPng($fileName = 'text-image', $location = ''){
        $fileName = $fileName.".png";
        $fileName = !empty($location)?$location.$fileName:$fileName;
        return imagepng($this->img, $fileName);
    }
    
    /**
     * Save image as jpg format
     * @param string file name to save
     * @param string location to save image file
     */
    public function saveAsJpg($fileName = 'text-image', $location = ''){
        $fileName = $fileName.".jpg";
        $fileName = !empty($location)?$location.$fileName:$fileName;
        return imagejpeg($this->img, $fileName);
    }

    
    private function dirtyImage(int $totalDots, int $totalLines,  int $color, int $imgWidth, int $imgHeight): void
    {
        $halfWidth = $imgWidth / 2;
        $halfHeight = $imgHeight / 2;

        for ($i = 0; $i < $totalLines; $i++) {
            $quadrante = random_int(0, 3);

            switch ($quadrante) {
                case 0:
                    $x1 = random_int(0, $halfWidth);
                    $y1 = random_int(0, $halfHeight);
        
                    $x2 = random_int($halfWidth, $imgWidth);
                    $y2 = random_int($halfHeight, $imgHeight);
                    break;

                case 1:
                    $x1 = random_int($halfWidth, $imgWidth);
                    $y1 = random_int(0, $halfHeight);

                    $x2 = random_int(0, $halfWidth);
                    $y2 = random_int($halfHeight, $imgHeight);
                    break;
                
                case 2:
                    $x1 = random_int(0, $halfWidth);
                    $y1 = random_int($halfHeight, $imgHeight);

                    $x2 = random_int($halfWidth, $imgWidth);
                    $y2 = random_int(0, $halfHeight);
                    break;

                case 3:
                    $x1 = random_int($halfWidth, $imgWidth);
                    $y1 = random_int($halfHeight, $imgHeight);

                    $x2 = random_int($halfWidth, $imgWidth);
                    $y2 = random_int(0, $halfHeight);
                    break;
            }
            
            imageline($this->img, $x1, $y1, $x2, $y2, $color);
        }

        for ($i = 0; $i < $totalDots; $i++) {
            $x1 = random_int(0, $imgWidth);
            $y1 = random_int(0, $imgHeight);

            imageline($this->img, $x1 - 1, $y1, $x1 + 1, $y1, $color);
            imageline($this->img, $x1, $y1 - 1, $x1, $y1 + 1, $color);
        }
    }
}
