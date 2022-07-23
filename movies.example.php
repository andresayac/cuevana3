<?php

# Dependencies
require 'vendor/autoload.php';

# Config
require 'config/config.php';


# Movies Class
require 'inc/movies.class.php';

$cuevana_movies = new Movies($_config);

// Latest movies added
$cuev_mov_lastest = $cuevana_movies->getMovies($_config['path']['movies']['cuev_mov_lastest']);
echo json_encode($cuev_mov_lastest, JSON_PRETTY_PRINT);

// Premiere movies
$cuev_mov_release = $cuevana_movies->getMovies($_config['path']['movies']['cuev_mov_release']);
echo json_encode($cuev_mov_release, JSON_PRETTY_PRINT);

// Most viewed movies
$cuev_mov_more_views = $cuevana_movies->getMovies($_config['path']['movies']['cuev_mov_more_views']);
echo json_encode($cuev_mov_more_views, JSON_PRETTY_PRINT);


// Top rated movies
$cuev_mov_most_valued = $cuevana_movies->getMovies($_config['path']['movies']['cuev_mov_most_valued']);
echo json_encode($cuev_mov_most_valued, JSON_PRETTY_PRINT);


// Latin dub movies
$cuev_mov_latin = $cuevana_movies->getMovies($_config['path']['movies']['cuev_mov_latin']);
echo json_encode($cuev_mov_latin, JSON_PRETTY_PRINT);


// Spanish dub movies
$cuev_mov_spanish = $cuevana_movies->getMovies($_config['path']['movies']['cuev_mov_spanish']);
echo json_encode($cuev_mov_spanish, JSON_PRETTY_PRINT);


// Subtitled movies
$cuev_mov_subtitled = $cuevana_movies->getMovies($_config['path']['movies']['cuev_mov_subtitled']);
echo json_encode($cuev_mov_subtitled, JSON_PRETTY_PRINT);
