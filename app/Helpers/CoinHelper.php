<?php
/**
 * Created by PhpStorm.
 * User: ilyestascou
 * Date: 03.08.18
 * Time: 10:44
 */

namespace App\Helpers;

use GuzzleHttp\Client;

class CoinHelper
{

    private static $api_url = 'https://api.coinmarketcap.com/v2/';
    private static $endpoint = "ticker/?limit=50";

    private $coinArray = array();


    function requestToCoin ()
    {
        // Eventuell auf ASync umstellen?
        $client = new Client();
        $request = $client->request('GET', self::$api_url . self::$endpoint);


        $items = json_decode($request->getBody());


        foreach($items->data AS $coin)
        {
            $tmpCoin = new Coin();

            $tmpCoin->id = $coin->id;
            $tmpCoin->name = $coin->name;
            $tmpCoin->symbol = $coin->symbol;
            $tmpCoin->rank = $coin->rank;
            $tmpCoin->price = $coin->quotes->USD->price;
            $tmpCoin->vol24h = $coin->quotes->USD->volume_24h;
            $tmpCoin->marketcap = $coin->quotes->USD->market_cap;
            $tmpCoin->change1h = $coin->quotes->USD->percent_change_1h;
            $tmpCoin->change24h = $coin->quotes->USD->percent_change_24h;
            $tmpCoin->change7d = $coin->quotes->USD->percent_change_7d;

            $this->coinArray[] = $tmpCoin;
        }
    }

    function coinToList ()
    {
        $this->requestToCoin();

        return $this->coinArray;
    }
}
