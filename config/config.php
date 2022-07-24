<?php


$_config = [
    'base_url' => 'https://ww1.cuevana3.me/',
    'path' => [
        'movies' => [
            '',
            'estrenos',
            'peliculas-mas-vistas',
            'peliculas-mas-valoradas',
            'peliculas-latino',
            'peliculas-espanol',
            'peliculas-subtituladas'
        ],
        'series' => [
            '#tabserie-1',
            '#tabserie-2',
            '#tabserie-3',
            '#tabserie-4',
        ]
    ],
    'querySelector' => [
        'movies' => [
            'getMovies' => [
                'path_direct' => '#tab-1 > ul > li',
                'path_pages' => '#aa-wp > div > div > main > section > ul > li ',
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
            ],
            'getMovieDetail' => [
                'poster' => '#top-single > div.backdrop > article > div.Image > figure > img',
                'background' => '#top-single > div.backdrop > div > figure > img',
                'title' => '#top-single > div.backdrop > article > header > h1',
                'original_title' => '#top-single > div.backdrop > article > header > h2',
                'year' => '#top-single > div.backdrop > article > footer > p > span:nth-child(2)',
                'sypnosis' => '#top-single > div.backdrop > article > div.Description > p',
                'rating' => 'div.post-ratings > strong:nth-child(7)',
                'duration' => '#top-single > div.backdrop > article > footer > p > span:nth-child(1)',
                'director' => '#MvTb-Info > ul > li:nth-child(1) > span',
                'genres' => '#MvTb-Info > ul > li:nth-child(2) > a ',
                'cast' => '#MvTb-Info > ul > li.AAIco-adjust.loadactor > a'
            ],
            'getLink' => [
                'queryStreaming' => '#top-single > div.video.cont > div.TPlayerCn.BgA > div > div > div'
            ]
        ],
        'series' => [
            'getSeries' => [
                'id' => 'div.TPost.C > a',
                'url' => 'div.TPost.C > a',
                'title' => 'div.TPost.C > a > h2',
                'poster' => 'div.TPost.C > a > div > figure > img',
                'year' => 'div.TPost.C > a > div > span.Year',
                'sypnosis' => 'div.TPMvCn > div.Description > p:nth-child(2)',
                'rating' => 'div.TPMvCn > p.Info > span.Vote',
                'director' => 'div.TPMvCn > div.Description > p.Director',
                'genres' => 'div.TPMvCn > div.Description > p.Genre',
                'cast' => 'div.TPMvCn > div.Description > p.Actors'
            ],

        ],
        'episode' => [
            'getLink' => [
                'queryStreaming' => '.embed_div > div'
            ]
        ],
        'categories' => [
            'getCategories' => [
                'count' => '.nmcn > span',
                'image' => '.item > a > figure > img',
                'name' => '.item > a > figure > figcaption',
                'url' => '.item > a',
            ]
        ]
    ]

];
