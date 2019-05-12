<?php

class Image 
{
    /** @param string */
    protected $text;
    /** @param int */
    protected $fontSize;


    /** 
     * Construct Image class
     * 
     * @param int $fontSize
     * @param string $text
    */
    public function __construct(int $fontSize = null) 
    {
        $this->fontSize = $fontSize;
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
        int $width, 
        int $height, 
        string $bgcolor = '#fafafa', 
        string $color = '#cdcdcd'
    ) {
        $image = imagecreatetruecolor($width, $height);

        $backgroundColor = $this->hexToRgb($bgcolor);
        $backgroundColor = imagecolorallocate(
            $image, 
            $backgroundColor['red'], 
            $backgroundColor['green'],
            $backgroundColor['blue']
        );

        $textColor = $this->hexToRgb($color);
        $textColor = imagecolorallocate(
            $image, 
            $textColor['red'], 
            $textColor['green'],
            $textColor['blue']
        );

        $fontSize = isset($this->fontSize) ? $this->fontSize : $this->setFontSize($width, $height);
        $text     = "$width x $height";

        imagefill($image, 0, 0, $backgroundColor);
        imagettftext(
            $image,
            $fontSize,
            0,
            ($width / 2) - ($fontSize * 2.75),
            ($height / 2) + ($fontSize * 0.3),
            $textColor, './Roboto.ttf', $text
        ); 
        
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