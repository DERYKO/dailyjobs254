<?php
/**
 * Created by PhpStorm.
 * User: DERRICK NGATIA
 * Date: 4/16/2019
 * Time: 11:10 AM
 */

class Forecast
{
    public function getWeatherForeCast($latitude, $longitude)
    {
        $client = new \GuzzleHttp\Client(['auth' => ['AgriBORA', 'riatKedo_13']]);
        $response = $client->request('GET', 'https://api.weather.com/v3/wx/forecast/hourly/15day?geocode=' . $latitude . ',' . $longitude . '&format=json&units=e&language=en-US&apiKey=f717bca68bbe4e6597bca68bbe1e657a');
        return json_decode($response->getBody()->getContents());
    }

}