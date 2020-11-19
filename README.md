# Swordbros Slider For Aimeos Extensions
[![License](https://poser.pugx.org/swordbros/omnipay-sberbank/license)](//packagist.org/packages/swordbros/omnipay-sberbank)
# Introduction

This package supports PHP 7.1 and higher 
You can easily add different view sliders to your website using this plugin
# Download

## Composer 

```
Add this line your web site composser.json 
    "require": {
        ...
        "swordbros/sw-slider": "^1.0"
    },
```

## Solving problems with minimal stability

Add to your composer.json

```
    "scripts": {
        "post-update-cmd": [
            ...
            "@php artisan migrate --path=ext/sw-slider/lib/custom/setup/slider"
        ]
    }


```
# Show Slider on your web site
Add your template blade file this code. Setup include demo slider data.
```
  <?php  echo \Aimeos\Shop\Facades\Shop::get('swordbros/slider')->getBody() ?>
```
# If you want to get only data for your template file
```
 $slider_data = \Aimeos\Shop\Facades\Shop::get('swordbros/slider')->addData($this);
```
## Standart Slider
![Slider Standard](https://tulparstudyo.net/images/slider-standart.png)
## Cover Flow Slider
![Slider Cover Flow](https://tulparstudyo.net/images/slider-cover-flow.png)
## Slider Admin Panel
![Slider Cover Flow](https://tulparstudyo.net/images/slider-admin-panel.png)
