<?php

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class Categories
{
    public $config;
    public $headers = [];
    public $categories = [];

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

    public function getCategories()
    {
        $response =  $this->client_cuevana->request('GET', 'category/action-adventure', [
            'headers' => $this->headers
        ]);

        if ($response->getStatusCode() != 200) return [];

        $contents = $response->getBody()->getContents();
        $crawler = new Crawler($contents);

        $data = $crawler->filter('.category-list > div');
        $data->each(function ($node) {
            $array_tmp = [];
            $array_tmp['count'] = $node->filter('.nmcn > span')->text(); // count
            $array_tmp['img'] = $node->filter('.item > a > figure > img')->attr('src'); // img
            $array_tmp['name'] = $node->filter('.item > a > figure > figcaption')->text(); // name
            $array_tmp['slug'] = str_replace($this->config['base_url'] . 'category/', '',   $node->filter('.item > a')->attr('href')); // url
            $array_tmp['url'] = $node->filter('.item > a')->attr('href'); // url
            
            array_push($this->categories, $array_tmp);
        });

        return $this->categories;
    }
}
