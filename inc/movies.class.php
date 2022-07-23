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

        if ($response->getStatusCode() != 200) return false;

        $contents = $response->getBody()->getContents();
        $crawler = new Crawler($contents);

        $data = $crawler->filter("#aa-wp > div > div > main > section > ul > li");


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

            array_push($this->data_movies, $tmp_array);
        });

        return $this->data_movies;
    }

    public function getMovieDetail($page)
    {
        $response =  $this->client_cuevana->request('GET', $page, [
            'headers' => $this->headers
        ]);

        if ($response->getStatusCode() != 200) return false;

        $contents = $response->getBody()->getContents();
        $crawler = new Crawler($contents);
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
