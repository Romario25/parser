<?php

namespace App\Console\Commands;

use App\Services\ParserServices;
use Illuminate\Console\Command;

class ParserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parser:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Парсинг прокси';

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
    public function handle(ParserServices $parserServices)
    {
        $count = 0;
        while (true) {
            $url = 'https://hidemy.name/en/proxy-list/?type=s&start='.$count.'#list';
            $html = $parserServices->getHtmlString($url);

            if ($parserServices->parserHtml($html) < 64) {
                break;
            }
                
            $count = $count + 64;
            echo $count."<br />";
        }
    }
}
