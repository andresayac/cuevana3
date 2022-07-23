<?php


$_config = [
    'base_url' => 'https://cuevana3.me/',
    'path' => [
        'movies' => [
            'cuev_mov_lastest' => '',
            'cuev_mov_release' => 'estrenos',
            'cuev_mov_more_views' => 'peliculas-mas-vistas',
            'cuev_mov_most_valued' => 'peliculas-mas-valoradas',
            'cuev_mov_latin' => 'peliculas-latino',
            'cuev_mov_spanish' => 'peliculas-espanol',
            'cuev_mov_subtitled' => 'peliculas-subtituladas'
        ],
        'series' => [
            'cuev_ser_latest' => '#tabserie-1',
            'cuev_ser_release' => '#tabserie-2',
            'cuev_ser_ranking' => '#tabserie-3',
            'cuev_ser_more_views' => '#tabserie-4',
            'cuev_ser_lastest_episodes' => '#aa-wp > div > div.TpRwCont.cont > main > section:nth-child(1)'
        ]
    ],
    'querySelector' => [
        'movies' => [
            'getMovies' => [
                'id' => 'div.TPost.C > a',
                'title' => 'div.TPost.C > a > h2',
                'url' => 'div.TPost.C > a',
                'poster' => 'div.TPost.C > a > div > figure > img',
                'year' => 'div.TPost.C > a > div > span.Year',
                'sypnosis' => 'div.TPMvCn > div.Description > p:nth-child(2)',
                'rating' => 'div.TPMvCn > p.Info > span.Vote',
                'duration' => 'div.TPMvCn > p.Info > span.Time',
                'director' => 'div.TPMvCn > div.Description > p.Director',
                'genres' => 'div.TPMvCn > div.Description > p.Genre',
                'cast' => 'div.TPMvCn > div.Description > p.Actors'
            ]
        ]
    ]

];
