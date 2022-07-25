<?php

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;


class Cuevana extends Util
{
    public $config;

    public $data_movies = [
        'success' => false,
        'data' => [],
        'message' => '',
    ];

    public $data_movies_pag = [
        'success' => false,
        'data' => [],
        'message' => '',
        'information' => [
            'page' => 0,
            'total_pages' => 0,
            'in_page' => 0
        ]
    ];

    public $data_series = [
        'success' => false,
        'data' => [],
        'message' => ''
    ];

    public $data_series_pag = [
        'success' => false,
        'data' => [],
        'message' => '',
        'information' => [
            'page' => 0,
            'total_pages' => 0,
            'in_page' => 0
        ]
    ];


    function __construct()
    {
        $cuevana_scraper = realpath(__DIR__ . '/../');
        require($cuevana_scraper . DIRECTORY_SEPARATOR  . 'config/config.php');

        if (!is_array($_config)) return 'configuration file missing';

        $this->client_cuevana = new Client(
            [
                'base_uri' => $_config['base_url'],
                'cookies' => true,
                'timeout' => 10
            ]
        );

        $this->config = $_config;
    }

    public function getMovies(int $type = 0)
    {
        if (empty($this->config['path']['movies'][$type]) && $type > 0) {
            $data_movies['success'] = false;
            $data_movies['data'] = [];
            $data_movies['message'] = 'the requested type is not in the list';
            $data_movies['available_types'] = $this->config['path']['movies'];
            return $data_movies;
        }

        $response =  $this->client_cuevana->request('GET', $this->config['path']['movies'][$type], [
            'headers' => $this->headers
        ]);

        if ($response->getStatusCode() != 200) return [];

        $contents = $response->getBody()->getContents();
        $crawler = new Crawler($contents);

        $query_filter = $this->config['querySelector']['movies']['getMovies'];

        $filter = (empty($type)) ? $query_filter['path_direct'] : $query_filter['path_pages'];
        $data = $crawler->filter($filter);

        $this->data_movies['data'] = $data->each(function ($node) {

            $querySelector = $this->config['querySelector']['movies']['getMovies'];

            $tmp_array = [];
            $tmp_array['id'] = str_replace($this->config['base_url'], '', $node->filter($querySelector['id'])->attr('href'));
            $tmp_array['title'] = $node->filter($querySelector['title'])->text();
            $tmp_array['url'] = $node->filter($querySelector['url'])->attr('href');
            $tmp_array['poster'] = $node->filter($querySelector['poster'])->attr('data-src');
            $tmp_array['year'] = $node->filter($querySelector['year'])->text();
            $tmp_array['sypnosis'] = $node->filter($querySelector['sypnosis'])->text();
            $tmp_array['rating'] = $node->filter($querySelector['rating'])->text();
            $tmp_array['duration'] = $node->filter($querySelector['duration'])->text();
            $tmp_array['director'] = $node->filter($querySelector['director'])->text();
            $tmp_array['genres'] = $this->textToArray($node->filter($querySelector['genres'])->text(), ', ', true, 'Género: ');
            $tmp_array['cast'] = $this->textToArray($node->filter($querySelector['cast'])->text(), ', ', true, 'Actores: ');

            return  $tmp_array;
        });

        $this->data_movies['success'] = true;
        $this->data_movies['message'] = "Information obtained from: {$this->config['path']['movies'][$type]}";

        return $this->data_movies;
    }

    public function getMoviesPag(int $page = 1)
    {
        $response =  $this->client_cuevana->request('GET', 'peliculas/page/' . $page, [
            'headers' => $this->headers
        ]);

        if ($response->getStatusCode() != 200) return [];

        $contents = $response->getBody()->getContents();
        $crawler = new Crawler($contents);

        $query_filter = $this->config['querySelector']['movies']['getMovies'];

        $filter = $query_filter['path_pages'];
        $data = $crawler->filter($filter);

        $this->data_movies_pag['data'] = $data->each(function ($node) {

            $querySelector = $this->config['querySelector']['movies']['getMovies'];

            $tmp_array = [];
            $tmp_array['id'] = str_replace($this->config['base_url'], '', $node->filter($querySelector['id'])->attr('href'));
            $tmp_array['title'] = $node->filter($querySelector['title'])->text();
            $tmp_array['url'] = $node->filter($querySelector['url'])->attr('href');
            $tmp_array['poster'] = $node->filter($querySelector['poster'])->attr('data-src');
            $tmp_array['year'] = $node->filter($querySelector['year'])->text();
            $tmp_array['sypnosis'] = $node->filter($querySelector['sypnosis'])->text();
            $tmp_array['rating'] = $node->filter($querySelector['rating'])->text();
            $tmp_array['duration'] = $node->filter($querySelector['duration'])->text();
            $tmp_array['director'] = $node->filter($querySelector['director'])->text();
            $tmp_array['genres'] = $this->textToArray($node->filter($querySelector['genres'])->text(), ', ', true, 'Género: ');
            $tmp_array['cast'] = $this->textToArray($node->filter($querySelector['cast'])->text(), ', ', true, 'Actores: ');
            $this->data_movies_pag['information']['in_page'] += 1;

            return $tmp_array;
        });

        $pages = $crawler->filter('.nav-links');
        $pages->each(function ($node) {
            $this->data_movies_pag['information']['page'] = (int) $node->filter('.current')->text();
            $this->data_movies_pag['information']['total_pages'] = (int) array_reverse(explode(' ', str_replace('...', '', $node->text())))[0];
        });

        $this->data_movies_pag['success'] = true;
        $this->data_movies_pag['message'] = "information obtained for the page: {$page}";

        return $this->data_movies_pag;
    }

    public function getSeries($type)
    {
        if (empty($this->config['path']['series'][$type])) {
            $this->data_series['success'] = false;
            $this->data_series['data'] = [];
            $this->data_series['message'] = 'the requested type is not in the list';
            $this->data_series['available_types'] = $this->config['path']['series'];
            return $this->data_series;
        }

        $response =  $this->client_cuevana->request('GET', 'serie', [
            'headers' => $this->headers
        ]);

        if ($response->getStatusCode() != 200) return [];

        $contents = $response->getBody()->getContents();
        $crawler = new Crawler($contents);

        $data = $crawler->filter($this->config['path']['series'][$type] . ' > ul > li');
        $this->data_series['data'] = $data->each(function ($node) {
            $querySelector = $this->config['querySelector']['series']['getSeries'];

            $tmp_array = [];
            $tmp_array['id'] = str_replace($this->config['base_url'], '', $node->filter($querySelector['id'])->attr('href'));
            $tmp_array['slug'] = $this->getSlugSerie($node->filter($querySelector['id'])->attr('href'));
            $tmp_array['title'] = $node->filter($querySelector['title'])->text();
            $tmp_array['url'] = $node->filter($querySelector['url'])->attr('href');
            $tmp_array['poster'] = $node->filter($querySelector['poster'])->attr('data-src');
            $tmp_array['year'] = $node->filter($querySelector['year'])->text();
            $tmp_array['sypnosis'] = $node->filter($querySelector['sypnosis'])->text();
            $tmp_array['rating'] = $node->filter($querySelector['rating'])->text();
            $tmp_array['director'] = $this->textToArray($node->filter($querySelector['director'])->text(), ', ', true, 'Director: ');
            $tmp_array['genres'] = $this->textToArray($node->filter($querySelector['genres'])->text(), ', ', true, 'Género: ');
            $tmp_array['cast'] = $this->textToArray($node->filter($querySelector['cast'])->text(), ', ', true, 'Actores: ');

            return $tmp_array;
        });

        $this->data_series['success'] = true;
        $this->data_series['message'] = "Information obtained from: {$this->config['path']['series'][$type]}";

        return $this->data_series;
    }

    public function getSeriesPag(int $page = 1)
    {
        $response =  $this->client_cuevana->request('POST', 'wp-admin/admin-ajax.php', [
            'form_params' => [
                'action' => 'cuevana_ajax_pagination',
                'query_vars' => '',
                'page' => $page
            ]
        ]);

        if ($response->getStatusCode() != 200) return [];

        $contents = $response->getBody()->getContents();
        $crawler = new Crawler($contents);

        $data = $crawler->filter('ul.MovieList > li');

        $this->data_series_pag['data'] = $data->each(function ($node) {

            $querySelector = $this->config['querySelector']['series']['getSeries'];

            $tmp_array = [];
            $tmp_array['id'] = str_replace($this->config['base_url'], '', $node->filter('a')->attr('href'));
            $tmp_array['slug'] = $this->getSlugSerie($node->filter('a')->attr('href'));
            $tmp_array['title'] = $node->filter('article.TPost.C > a > h2')->text();
            $tmp_array['url'] = $node->filter('a')->attr('href');
            $tmp_array['poster'] = $node->filter('img')->attr('src');
            $tmp_array['year'] = $node->filter('.Year')->text();
            $tmp_array['sypnosis'] = $node->filter($querySelector['sypnosis'])->text();
            $tmp_array['rating'] = $node->filter($querySelector['rating'])->text();
            $tmp_array['director'] = $this->textToArray($node->filter($querySelector['director'])->text(), ', ', true, 'Director: ');
            $tmp_array['genres'] = $this->textToArray($node->filter($querySelector['genres'])->text(), ', ', true, 'Género: ');
            $tmp_array['cast'] = $this->textToArray($node->filter($querySelector['cast'])->text(), ', ', true, 'Actores: ');

            $this->data_series_pag['information']['in_page'] += 1;
            return $tmp_array;
        });

        $pages = $crawler->filter('.nav-links');
        $pages->each(function ($node) {
            $this->data_series_pag['information']['page'] = (int) $node->filter('.current')->text();
            $this->data_series_pag['information']['total_pages'] = (int) array_reverse(explode(' ', str_replace('...', '', $node->text())))[0];
        });

        $this->data_series_pag['success'] = true;
        $this->data_series_pag['message'] = "Information obtained for the page: {$page}";

        return $this->data_series_pag;
    }

    public function getGenre()
    {
        $response =  $this->client_cuevana->request('GET', 'category/action-adventure', [
            'headers' => $this->headers
        ]);

        if ($response->getStatusCode() != 200) return [];

        $contents = $response->getBody()->getContents();
        $crawler = new Crawler($contents);

        $categories = [];

        $data = $crawler->filter('.category-list > div');

        $categories = $data->each(function ($node) {
            $array_tmp = [];
            $array_tmp['id'] = str_replace($this->config['base_url'], '', str_replace('ww3', 'ww1',   $node->filter('.item > a')->attr('href')));
            $array_tmp['count'] = $node->filter('.nmcn > span')->text(); // count
            $array_tmp['img'] = $node->filter('.item > a > figure > img')->attr('src'); // img
            $array_tmp['name'] = $node->filter('.item > a > figure > figcaption')->text(); // name
            $array_tmp['slug'] = str_replace($this->config['base_url'] . 'category/', '', str_replace('ww3', 'ww1',   $node->filter('.item > a')->attr('href')));
            $array_tmp['url'] = $node->filter('.item > a')->attr('href'); // url

            return $array_tmp;
        });

        return $categories;
    }

    public function getDetail($id_slug)
    {
        $response =  $this->client_cuevana->request('GET', (string) $id_slug, [
            'headers' => $this->headers
        ]);

        if ($response->getStatusCode() != 200) return [];

        $contents = $response->getBody()->getContents();
        $crawler = new Crawler($contents);

        $querySelector = $this->config['querySelector']['movies']['getMovieDetail'];

        $data_tmp_detail = [];
        $data_tmp_detail['id'] = $id_slug;
        $data_tmp_detail['poster'] = str_replace('w185_and_h278', 'w600_and_h900', $crawler->filter($querySelector['poster'])->attr('data-src'));
        $data_tmp_detail['background'] = $crawler->filter($querySelector['background'])->attr('data-src');
        $data_tmp_detail['title'] = $crawler->filter($querySelector['title'])->text();
        $data_tmp_detail['original_title'] = $crawler->filter($querySelector['original_title'])->text();
        $data_tmp_detail['sypnosis'] = $crawler->filter($querySelector['sypnosis'])->text();
        $data_tmp_detail['year'] = $crawler->filter($querySelector['year'])->text();
        $data_tmp_detail['duration'] = $crawler->filter($querySelector['duration'])->text();
        $data_tmp_detail['rating'] = $crawler->filter($querySelector['rating'])->text();
        $data_tmp_detail['director'] = $crawler->filter($querySelector['director'])->text();
        $data_tmp_detail['genres'] = $this->textToArray($crawler->filter($querySelector['genres'])->text(), ', ', true, 'Género: ');
        $data_tmp_detail['cast'] = $this->textToArray($crawler->filter($querySelector['cast'])->text(), ', ', true, 'Actores: ');

        $check_type = $this->getDataNode($crawler, '.cv3-dots > span', 'attr', 'title');
        if (!empty($check_type)) {
            $data_tmp_detail['type'] =  (($crawler->filter('.cv3-dots > span')->attr('title'))) ? 'Serie' : 'Movie';
            $data_tmp_detail['status'] = $crawler->filter('.cv3-dots > span')->attr('title');

            $data = $crawler->filter('#select-season > option');

            $data_tmp_detail['season'] = $data->each(function ($node) {
                $data_tmp = [
                    'id' => $node->filter('option')->attr('value'),
                    'name' => $node->filter('option')->text(),
                    'data' => []
                ];

                return $data_tmp;
            });

            foreach ($data_tmp_detail['season'] as $key => $value) {
                $querySelector = "#season-{$value['id']} > li";

                $data_tmp_detail['season'][$key]['data'] = $crawler->filter($querySelector)->each(function ($node) {
                    $data_tmp = [
                        'slug' => $this->getSlugSerie($node->filter('a')->attr('href')),
                        'title' => $node->filter('.Title')->text(),
                        'url' => $node->filter('a')->attr('href'),
                        'poster' => $node->filter('article.TPost.C > a > div > figure > img')->attr('data-src'),
                        'date' => $node->filter('article.TPost.C > a > p')->text()
                    ];
                    return $data_tmp;
                });
            }
        }

        return $data_tmp_detail;
    }

    public function getByGenre(string $genre = 'sci-fi-fantasy', string $page = '1')
    {
        $response = $this->requestCuevana("category/{$genre}/page/{$page}");

        if (!$response) return [
            'success' => false,
            'data' => [],
            'message' => 'It is possible that the category does not exist or contains an invalid page number.'
        ];

        $contents = $response->getBody()->getContents();
        $crawler = new Crawler($contents);

        $data = $crawler->filter('ul.MovieList > li');

        $data_genre = [
            'success' => false,
            'data' => [],
            'message' => '',

        ];

        $data_genre['data'] = $data->each(function ($node, $index) {

            $tmp_array = [];
            $tmp_array['id'] = str_replace($this->config['base_url'], '', $this->getDataNode($node, 'a', 'attr', 'href'));
            $tmp_array['slug'] = $this->getSlugSerie($this->getDataNode($node, 'a', 'attr', 'href'));
            $tmp_array['title'] = $this->getDataNode($node, '.Title');
            $tmp_array['url'] = $this->getDataNode($node, 'a', 'attr', 'href');
            $tmp_array['poster'] = $this->getDataNode($node, '.Image > figure > img', 'attr', 'data-src');
            $tmp_array['year'] = $this->getDataNode($node, 'p.Info > span.Date');
            $tmp_array['sypnosis'] = $this->getDataNode($node, 'div.Description > p:nth-child(2)');
            $tmp_array['rating'] = $this->getDataNode($node, 'span.Vote');
            $tmp_array['director'] = $this->textToArray($this->getDataNode($node, 'p.AAIco-videocam'), ', ', true, 'Director: ');
            $tmp_array['genres'] = $this->textToArray($this->getDataNode($node, 'div.TPMvCn > div.Description > p.Genre'), ', ', true, 'Género: ');
            $tmp_array['cast'] = $this->textToArray($this->getDataNode($node, 'div.TPMvCn > div.Description > p.Actors'), ', ', true, 'Actores: ');

            return $tmp_array;
        });

        $pages = $crawler->filter('.nav-links');
        $tmp_data_information = $pages->each(function ($node) {
            $tmp_array['page'] = (int) $node->filter('.current')->text();
            $tmp_array['total_pages'] = (int) array_reverse(explode(' ', str_replace('...', '', $node->text())))[0];
            return $tmp_array;
        });

        $data_genre['information'] = $tmp_data_information[0] ?? ['page' => $page, 'total_pages' => $page];
        $data_genre['information']['in_page']  = $crawler->filter('ul.MovieList > li.xxx')->count();
        $data_genre['message']  = "Data for the category: {$genre}";

        return $data_genre;
    }

    public function getSearch()
    {
        echo "HI";
    }

    public function getLinks(string $slug)
    {
        $response =  $this->client_cuevana->request('GET', $slug, [
            'headers' => $this->headers
        ]);

        if ($response->getStatusCode() != 200) return [];

        $contents = $response->getBody()->getContents();
        $crawler = new Crawler($contents);

        $elements_id_cuevana = [
            'OptL' => 'Latino',
            'OptS' => 'Subtitulado',
            'OptE' => 'Castellano',
            'OptY' => 'Youtube'
        ];

        $array_id_sort = [];

        $filterQuery = $this->config['querySelector']['movies']['getLink']['queryStreaming'];

        $check_type = explode('/', $slug);
        if ($check_type[0] === 'episodio') $filterQuery = $this->config['querySelector']['episode']['getLink']['queryStreaming'];

        $id_languajes_dispo = $crawler->filter($filterQuery)->extract(['id']);

        foreach ($id_languajes_dispo as  $value) {
            $id_tmp = preg_replace('/[0-9]+/', '', $value);
            if (in_array($id_tmp, ['mdl-help'])) continue;
            $array_id_sort[$elements_id_cuevana[$id_tmp]][] = $value;
        }

        $array_data_url_id = [];
        $array_data_url_id['id'] = $slug;

        foreach ($array_id_sort as $key => $value) {
            $array_data_url_id[$key] = [];
            foreach ($value as  $option_id) {
                $url_data =  $crawler->filter("#{$option_id}")->children('iframe')->attr('data-src');
                $array_data_url_id[$key][$option_id] = (isset($url_data)) ? $url_data : '';
            }
        }

        return $array_data_url_id;
    }

    public function getDownload($slug = '')
    {
        $response = $this->requestCuevana($slug);

        if (!$response) return [
            'success' => false,
            'data' => [],
            'message' => 'It is possible that the category does not exist or contains an invalid page number.'
        ];

        $contents = $response->getBody()->getContents();
        
        # ensure move html close tag to the end of file
        $contents = str_replace('</html>', '', $contents);
        $contents .= '</html>';
        
        $crawler = new Crawler($contents);
        $data = $crawler->filter('#mdl-downloads > div.mdl-cn > div.mdl-bd > div > table > tbody > tr');
        $data_download = [];
        $data_download = $data->each(function ($node) {
            $tmp_array = [];
            $tmp_array['server'] = $this->getDataNode($node, 'td:nth-child(1)');
            $tmp_array['language'] =  $this->getDataNode($node, 'td:nth-child(2)');
            $tmp_array['quality'] =  $this->getDataNode($node, 'td:nth-child(3)');
            $tmp_array['link'] =  $this->getDataNode($node, 'td:nth-child(4) > a', 'attr', 'href');

            return  $tmp_array;
        });

        return $data_download;
    }
}
