# Custom image placeholder

_Readme will be update over time, or just ask in issues if you need some help._

This is simple tool for image placeholder that can run on your own server.

## Requirements
+ PHP => 7.1
+ GD library

## Installation
_I'll update this section later_
Clone this repository on your server, create vhost and visit it in browser.

## How it works?
Open the web url in the browser with width and height after the slash in the domain name. Server will return you image with specified size. There are other features like background color, text color and text that you can set as get parameters.

So requests should be:
+ `img.example.com/300` - this will generate image with default colours and size 300x300px
+ `img.example.com/300x250` - width will be 300px and height 250px
+ `img.example.com/300?color=fcfcfc` - background color will be `#fcfcfc`
+ `img.example.com/300?text-color=fcfcfc` - text color will be `#fcfcfc`
+ `img.example.com/300?text=Hello` - instead of image size, there will be "hello" on the picture.

## There is also live application that you can try!
If you don't like to host your own application, you can try mine. Just visit `img.silencesys.com`.
