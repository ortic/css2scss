[![Build Status](https://api.travis-ci.org/ortic/css2scss.svg?branch=master)](https://travis-ci.org/ortic/css2scss)
[![Code Rating](https://img.shields.io/scrutinizer/g/ortic/css2scss.svg?style=flat)](https://scrutinizer-ci.com/g/ortic/css2scss/)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/ortic/css2scss.svg?style=flat)](https://scrutinizer-ci.com/g/ortic/css2scss/)

css2less
========

this library aims to convert CSS files into SCSS files.

Currently used by http://www.css2scss.net/

example
=======

The code below takes a few CSS instructions and prints them in a more SCSS like form:

```php
$cssContent = 'body p { font-family: arial; }';
$css2lessParser = new \Ortic\Css2Scss\Css2Scss($cssContent);
echo $css2lessParser->getScss();
```

output:

```
body {
        p {
                font-family: arial;
        }
}
```