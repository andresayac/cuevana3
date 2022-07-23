<?php

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DomCrawler\Test\Constraint\CrawlerSelectorExists;

class Movies
{

    public $client_cuevana = null;
    public $headers = [];
    public $data_movies = [];
    public $config = [];

    function __construct(array $_config)
    {
        $this->client_cuevana = new Client(
            [
                'base_uri' => $_config['base_url'],
                'cookies' => true,
                'timeout' => 10
            ]
        );

        $this->config = $_config;
    }

    public function getMovies($page)
    {
        $response =  $this->client_cuevana->request('GET', $page, [
            'headers' => $this->headers
        ]);

        if ($response->getStatusCode() != 200) return [];

        $contents = $response->getBody()->getContents();
        $crawler = new Crawler($contents);

        $filter = (empty($page)) ? '#tab-1 > ul > li' : '#aa-wp > div > div > main > section > ul > li ';
        $data = $crawler->filter($filter);

        $data_movies = [];

        $data->each(function ($node) {

            $querySelector = $this->config['querySelector']['movies']['getMovies'];

            $tmp_array = [];
            $tmp_array['id'] = $this->getIdMovie($node->filter($querySelector['id'])->attr('href'));
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

            array_push($data_movies, $tmp_array);
        });

        return $data_movies;
    }

    public function getMovieDetail($id)
    {
        $response =  $this->client_cuevana->request('GET', $id, [
            'headers' => $this->headers
        ]);

        if ($response->getStatusCode() != 200) return [];

        $contents = $response->getBody()->getContents();
        $crawler = new Crawler($contents);

        $data_movie = [];

        $data_movie['poster'] = str_replace('w185_and_h278', 'w600_and_h900', $crawler->filter('#top-single > div.backdrop > article > div.Image > figure > img')->attr('data-src'));
        $data_movie['background'] = $crawler->filter('#top-single > div.backdrop > article > div.Image > figure > img')->attr('data-src');
        $data_movie['title'] = $crawler->filter('#top-single > div.backdrop > article > header > h1')->text();
        $data_movie['original_title'] = $crawler->filter('#top-single > div.backdrop > article > header > h2')->text();
        $data_movie['sypnosis'] = $crawler->filter('#top-single > div.backdrop > article > div.Description > p')->text();
        $data_movie['year'] = $crawler->filter('#top-single > div.backdrop > article > footer > p > span:nth-child(2)')->text();
        $data_movie['duration'] = $crawler->filter('#top-single > div.backdrop > article > footer > p > span:nth-child(1)')->text();
        $data_movie['rating'] = $crawler->filter('div.post-ratings > strong:nth-child(7)')->text();
        $data_movie['director'] = $crawler->filter('#MvTb-Info > ul > li:nth-child(1) > span')->text();
        $data_movie['genres'] = $crawler->filter('#MvTb-Info > ul > li:nth-child(2) > a')->text();
        $data_movie['cast'] = $crawler->filter('#MvTb-Info > ul > li.AAIco-adjust.loadactor > a')->text();
        $data_movie['link_streaming'] = $this->getLinkStreamingMovies($crawler);


        return $data_movie;
    }


    public function getLinkStreamingMovies($crawler)
    {
        $elements_id_cuevana = [
            'OptL' => 'Latino',
            'OptS' => 'Subtitulado',
            'OptE' => 'Castellano',
            'OptY' => 'Youtube'
        ];


        $id_languajes_dispo = $crawler->filter('#top-single > div.video.cont > div.TPlayerCn.BgA > div > div > div')->extract(['id']);

        foreach ($id_languajes_dispo as  $value) {
            $id_tmp = preg_replace('/[0-9]+/', '', $value);
            if (in_array($id_tmp, ['mdl-help'])) continue;
            $array_id_sort[$elements_id_cuevana[$id_tmp]][] = $value;
        }

        $array_data_url_id = [];

        foreach ($array_id_sort as $key => $value) {
            $array_data_url_id[$key] = [];
            foreach ($value as  $option_id) {
                $url_data =  $crawler->filter("#{$option_id}")->children('iframe')->attr('data-src');
                $array_data_url_id[$key][$option_id] = (isset($url_data)) ? $url_data : '';
            }
        }

        return $array_data_url_id;
    }

    public function textToArray($string, $delimiter = ',', $replace = false, $replace_search = '', $replace_to = '')
    {
        if ($replace) $string = str_replace($replace_search, $replace_to, $string);

        return explode($delimiter, $string);
    }

    public function getIdMovie($url)
    {

        $string = preg_split('/\//', $url);
        return is_numeric((int) $string[3]) ? (int) $string[3] : 0;
    }

    public function getDataNode($crawler, $filter)
    {
        try {
            return $crawler->filter($filter)->text();
        } catch (\Exception $e) {
            return '';
        }
    }
}
