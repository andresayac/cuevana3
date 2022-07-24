<?php

# Dependencies
require 'vendor/autoload.php';

# Movies Class
require 'inc/util.class.php';
require 'inc/cuevana.class.php';


$cuevana_movies = new Cuevana();

echo json_encode($cuevana_movies->getGenre()); // 1042 // for-all-mankind // 58602/feng-bao // episodio/interrogation-1x10

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


