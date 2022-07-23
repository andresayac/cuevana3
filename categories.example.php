<?php

# Dependencies
require 'vendor/autoload.php';

# Config
require 'config/config.php';

# Categories Class
require 'inc/categories.class.php';

$cuevana_categories = new Categories($_config);

echo json_encode($cuevana_categories->getCategories(), JSON_PRETTY_PRINT);

