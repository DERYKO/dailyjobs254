<?php

namespace App\Console\Commands;

use App\Forecast;
use App\Job;
use Carbon\Carbon;
use Illuminate\Console\Command;

class WeatherForecast extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:forecast';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        Job::get()->each(function ($job){
            $forecast=$this->getWeatherForeCast($job->latitude,$job->longitude);
            foreach ($forecast->validTimeUtc as $key => $datas) {
                $data = Forecast::firstOrNew([
                        'time' => Carbon::createFromTimestampMs($datas * 1000),
                        'job_id' => $job->id
                ]);
                $data->icon_code=$forecast->iconCode[$key];
                $data->prediction=$forecast->wxPhraseLong[$key];
                $data->save();
            }
        });

    }
    public function getWeatherForeCast($latitude, $longitude)
    {
        $client = new \GuzzleHttp\Client(['auth' => ['AgriBORA', 'riatKedo_13']]);
        $response = $client->request('GET', 'https://api.weather.com/v3/wx/forecast/hourly/15day?geocode=' . $latitude . ',' . $longitude . '&format=json&units=e&language=en-US&apiKey=f717bca68bbe4e6597bca68bbe1e657a');
        return json_decode($response->getBody()->getContents());
    }
}
