<?php

namespace wpFchTheme;

require __DIR__."/vendor/autoload.php";
require __DIR__."/src/navwalker/wp-bootstrap-navwalker.php";
require __DIR__."/src/navwalker/class-wp-bootstrap-navwalker.php";

$index = new Index();
$index->show();