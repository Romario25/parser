<?php

namespace App\Console\Commands;

use App\Proxy;
use GuzzleHttp\Client;
use function GuzzleHttp\Promise\all;
use function GuzzleHttp\Promise\settle;
use Illuminate\Console\Command;
use Mockery\CountValidator\Exception;

class TestProxyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proxy:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test proxy';

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
        
        $arr = ['https://google.com', 'https://youtube.com', 'http://pravda.com.ua'];

        $proxies = Proxy::where('on', 1)->get();

        foreach ($proxies as $k => $proxy) {
            $arrResult = [];
            echo "proxy ip : ".$proxy->ip."\n";

            $promises = [];
            $client = new Client();
            foreach ($arr as $item) {
                $promises[$item] = $client->requestAsync('GET', $item, [
                    'proxy' => 'http://'.$proxy->ip.':'.$proxy->port
                ]);
            }

            $results = settle($promises)->wait();

            foreach ($results as $site => $result) {
                if ($result['state'] == 'fulfilled') {
                    $arrResult[] = $site;
                }
            }
            if (count($arrResult) > 0) {
                $proxy->sites = serialize($arrResult);
                if (count($arrResult) == count($arr)) {
                    $proxy->status = 1;
                }
                $proxy->save();
            }

        }
    }
}
