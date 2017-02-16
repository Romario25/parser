<?php
namespace App\Services;

use App\Proxy;
use Curl\Curl;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

class ParserServices
{

    /**
     * Получение ввиде строки страницы
     * @param string $url
     * @return string
     */
    public function getHtmlString($url)
    {
        $curl = new Curl();
        $curl->get($url);

        return $curl->response;
    }

    /**
     * Парсинг страницы
     * @param string $html
     * @return int
     */
    public function parserHtml($html)
    {
        $arrParams = ['ip', 'port', 'location', 'speed', 'type'];

        $crawler = new Crawler($html);
        $crawler = $crawler->filter('table.proxy__t tr');
        $count = 0;
        foreach ($crawler as $content) {
            try {
                $crawler = new Crawler($content);
                $arr = [];
                foreach ($crawler->filter('td') as $i => $node) {
                    if ($i == 5) {
                        break;
                    }

                    $arr[$arrParams[$i]] = $node->nodeValue;
                }

                if (count($arr) > 0) {
                    $this->saveProxy($arr);
                }
                $count++;
            } catch (\Exception $e) {
                Log::error('parser_proxy', [
                   'code' => $e->getCode(),
                    'message' => $e->getMessage()
                ]);
                continue;
            }

        }
        
        return $count;
    }

    /**
     * Сохранение данных прокси
     * @param array $arr массив свойств
     */
    private function saveProxy($arr)
    {
        $proxy = Proxy::where('ip', $arr['ip'])->first();
        if ($proxy == null) {
            $proxy = new Proxy();
        }
        $proxy->ip = $arr['ip'];
        $proxy->port = $arr['port'];
        $proxy->location = $arr['location'];
        $proxy->speed = $arr['speed'];
        $proxy->type = $arr['type'];
        $proxy->sites = '';
        $proxy->save();
    }
}
