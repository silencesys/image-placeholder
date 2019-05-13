<?php

class ImagePlaceholder
{
    /** @param string */
    protected $text;
    protected $fontFamily;
    /** @param int */
    protected $fontSize;


    /** 
     * Construct Image class
     * 
     * @param int $fontSize
     * @param string $text
    */
    public function __construct(int $fontSize = null, string $fontFamily = null) 
    {
        $this->fontSize   = $fontSize;
        $this->fontFamily = isset($fontFamily) ? $fontFamily : './Roboto.ttf';
    }

    /**
    * Render an image with given width, height and colours.
    * 
    * @param  int    $width   - set image width in pixels
    * @param  int    $height  - set image height in pixels
    * @param  string $bgcolor - set background color, accepted is hex string
    * @param  string $color   - set text color, accepted is hex string 
    * @return resource
    */
    public function create (
        $width, 
        $height, 
        string $bgcolor = '#fafafa', 
        string $color = '#cdcdcd',
        string $text = null
    ) {        
        $image = imagecreatetruecolor($width, $height);
        $image = $this->paintImage($image, $bgcolor);
        $color = $this->painImageText($image, $color);        

        // Check whether there is globally set font size or not.
        $fontSize = isset($this->fontSize) ? $this->fontSize : $this->setFontSize($width, $height);
        $image    = $this->typeOnImage($image, $fontSize, $color, $text);
        
        return $image;
    }

    /**
    * Write size or given text on image.
    *
    * @param  resource $image    - gd resource.
    * @param  int      $fontSize - size of the text.
    * @param  int      $color    - allocated colour with imagecolorallocate.
    * @param  string   $text     - text that should be writteon image.
    * @return resource
    */
    public function typeOnImage($image, int $fontSize, int $color, string $text = null)
    {
        $width  = imagesx($image);
        $height = imagesy($image);
        $text   = isset($text) ? $text : "$width x $height";

        $position = $this->getTextPosition($image, $fontSize, $text);

        imagettftext(
            $image,
            $fontSize,
            0,
            $position['x'],
            $position['y'],
            $color, 
            $this->fontFamily, 
            $text
        ); 

        return $image;
    }

    public function getTextPosition($image, int $fontSize, string $text) 
    {
        $textBox = imagettfbbox($fontSize, 0, $this->fontFamily, $text);

        $textWidth   = abs($textBox[2]) - abs($textBox[0]); 
        $textHeight  = abs($textBox[5]) - abs($textBox[3]);
        $imageWidth  = imagesx($image);
        $imageHeight = imagesy($image);

        return [
            'x' => ($imageWidth - $textWidth) / 2,
            'y' => ($imageHeight + $textHeight) /2 ,
        ];
    }

    /**
    * Set text colour.
    *
    * @param  resource $image - gd resource.
    * @param  string      $color - hex encoded colour.
    * @return int
    */
    public function painImageText($image, string $color): int
    {
        $textColor = $this->hexToRgb($color);
        $textColor = imagecolorallocate(
            $image, 
            $textColor['red'], 
            $textColor['green'],
            $textColor['blue']
        );

        return $textColor;
    }

    /**
    * Fill image with given colour.
    *
    * @param resource $image
    * @param string $color
    * @return resource
    */
    public function paintImage($image, string $color)
    {
        $backgroundColor = $this->hexToRgb($color);
        $backgroundColor = imagecolorallocate(
            $image, 
            $backgroundColor['red'], 
            $backgroundColor['green'],
            $backgroundColor['blue']
        );

        imagefill($image, 0, 0, $backgroundColor);

        return $image;
    }

    /**
    * Convert HEX string into RGB array.
    *
    * @param string $hexColor 
    * @return array
    */
    public function hexToRgb(string $hexColor): array
    {
        $hexColor = str_replace('#', '', $hexColor);
        $hexColor = strlen($hexColor) <= 3 
                  ? $hexColor[0].$hexColor[0].$hexColor[1].$hexColor[1].$hexColor[2].$hexColor[2] 
                  : $hexColor;

        return [
            'red' => hexdec(substr($hexColor, 0, 2)),
            'green' => hexdec(substr($hexColor, 2, 2)),
            'blue' => hexdec(substr($hexColor, 4, 2))
        ];
    }

    /**
    * Set font size based on image width and height.
    *
    * @param int $width
    * @param int $height
    * @return int
    */
    public function setFontSize(int $width, int $height): int
    {
        return $width > $height ? $height / 10 : $width / 10;
    }

}