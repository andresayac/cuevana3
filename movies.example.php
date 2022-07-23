<?php

# Dependencies
require 'vendor/autoload.php';

# Config
require 'config/config.php';


# Movies Class
require 'inc/movies.class.php';

$cuevana_movies = new Movies($_config);


// cuev_mov_lastest
// cuev_mov_release
// cuev_mov_more_views
// cuev_mov_most_valued
// cuev_mov_latin
// cuev_mov_spanish
// cuev_mov_subtitled

//echo json_encode($cuevana_movies->getMovies($_config['path']['movies']['cuev_mov_lastest']), JSON_PRETTY_PRINT);



// id movie 57910
// echo json_encode($cuevana_movies->getMovieDetail('57910'), JSON_PRETTY_PRINT);


