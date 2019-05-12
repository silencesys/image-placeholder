<?php

class ImageAttributes 
{
    /** @param string */
    protected $uri;
    /** @param string */
    protected $get;
    /** @param int */
    public $width;
    /** @param int */
    public $height;
    /** @param array */
    public $style;

    /**
    * Construct ImageAttributes class.
    */
    public function __construct() {
        $uri = explode('?', $_SERVER['REQUEST_URI'], 2);

        $this->uri = substr($uri[0], 1);
        $this->get = isset($uri[1]) ? explode('&', $uri[1]) : null;

        $this->width  = $this->imageSize()['width'];
        $this->height = $this->imageSize()['height'];
        $this->styles = $this->imageAttributes();
    }

    /**
    * Get width and height of an image.
    *
    * @return array
    */
    public function imageSize(): array
    {
        if (strpos($this->uri, '-') > -1) {
            $attributes = explode('-', $this->uri);
        } elseif (strpos($this->uri, 'x')) {
            $attributes = explode('x', $this->uri);
        } else {
            $attributes = (int) $this->uri;
        }

        if (empty($attributes[0])) {
            die("Something went wrong, are you sure that you specified size of the image?");
        }
        
        return [
            'width' => $attributes[0],
            'height' => isset($attributes[1]) ? $attributes[1] : $attributes[0]
        ];
    } 

    /**
    * Get image attributes.
    *
    * @return array
    */
    public function imageAttributes(): array
    {
        $attributes = [];

        if (is_array($this->get)) {    
            foreach ($this->get as $attribute) {
                $explode = explode('=', $attribute);
                $attributes[$explode[0]] = $explode[1];
            }
        } 
    
        return $attributes;
    }

}