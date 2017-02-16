<?php

namespace App\Http\Controllers;

use App\Proxy;
use App\Services\ParserServices;
use GuzzleHttp\Client;
use function GuzzleHttp\Promise\all;
use Symfony\Component\DomCrawler\Crawler;

class TestController extends Controller
{
    //
    
    public function index(ParserServices $parserServices){

        echo "test";

        
        $count = 0;
        while(true){
            $url = 'https://hidemy.name/en/proxy-list/?type=s&start='.$count.'#list';
            $html = $parserServices->getHtmlString($url);

            if($parserServices->parserHtml($html) < 64)break;
            $count = $count + 64;
            echo $count."<br />";
        }

    }

    public function testProxy(){
        echo 'proxy';

        $arr = ['https://google.com', 'https://youtube.com', 'http://pravda.com.ua'];

        $proxies = Proxy::all();

        foreach ($proxies as $k => $proxy){
            $promises = [];
            $client = new Client();
            foreach($arr as  $item){
                $promises[] =$client->requestAsync('GET', $item, ['proxy' => 'http://'.$proxy->ip.':'.$proxy->port]);
            }

            all($promises)->then(function (array $responses) {
                foreach ($responses as $response) {
                    $profile = json_decode($response->getBody(), true);
                    // Do something with the profile.
                    dump($profile);
                }
            }, function (\Exception $e) {
                echo $e->getMessage() . "\n";
                echo $e->getRequest()->getMethod();
            })->wait();





//            foreach($arr as  $item){
//                $client = new Client(['base_uri' => $item]);
//                $response = $client->request('GET', '/', ['proxy' => 'http://'.$proxy->ip.':'.$proxy->port]);
//
//                dump($response);
//
//            }
            if($k == 3) break;
        }
    }
}
