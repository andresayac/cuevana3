<?php


class Util
{
    public $client_cuevana, $headers = [];

    public function requestCuevana($request, string $method = 'GET')
    {
        $request = new \GuzzleHttp\Psr7\Request($method, $request);
        try {
            $promise = $this->client_cuevana->sendAsync($request)->then(function ($response) {
                return $response;
            });
            return $promise->wait();
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function getIdMovie($url)
    {
        $string = preg_split('/\//', $url);
        return is_numeric((int) $string[3]) ? (int) $string[3] : 0;
    }

    public function getSlugSerie($url)
    {
        $string = preg_split('/\//', $url);
        return isset($string[4]) ? $string[4] : '';
    }

    public function getDataNode($crawler, $filter, $method = 'text', $params = '')
    {
        try {

            if ($method === 'attr') return $crawler->filter($filter)->$method($params);

            return $crawler->filter($filter)->$method();
        } catch (\Exception $e) {
            return '';
        }
    }

    public function textToArray($string, $delimiter = ',', $replace = false, $replace_search = '', $replace_to = '')
    {
        if ($replace) $string = str_replace($replace_search, $replace_to, $string);

        return explode($delimiter, $string);
    }
}
