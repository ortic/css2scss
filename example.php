<?php

include __DIR__ . '/vendor/autoload.php';

$cssContent = <<<EOF
a[href^="javascript:"]:after {
    border: 0;
}
EOF;

$css2scssParser = new \Ortic\Css2Scss\Css2Scss($cssContent);
echo $css2scssParser->getScss();
