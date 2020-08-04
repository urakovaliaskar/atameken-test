<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class RefreshCurrency extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:currency';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh database with new currency rates';

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
     * @return void
     */
    public function handle()
    {
        try {
            $response = Http::get('https://nationalbank.kz/rss/rates_all.xml?switch=russian');
            $json = json_encode(simplexml_load_string($response));
            $array = json_decode($json,true);

            array_map(function($item) {
                $data = [
                    'name'=>$item['title'],
                    'rate'=>$item['description'],
                    'date'=>Carbon::createFromFormat('d.m.Y',$item['pubDate'])
                ];
                DB::table('currencies')
                    ->updateOrInsert(
                        ['name' => $data['name'], 'date' => $data['date']->format('Y-m-d')],
                        ['rate' => $data['rate']]
                    );
            }, $array['channel']['item']);
            $this->info('Database was refreshed!');
        } catch (\Throwable $e) {
            $this->warn('Database was not refreshed!');
            $this->warn($e);
        }
    }
}
