<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(): Response
    {
        header('refresh: 60'); // autoupdating data
        $baseUrl = 'https://whitebit.com'; //domain without last slash. Do not use https://whitebit.com/

        $requestMarkets = '/api/v4/public/markets'; //put here request path. For obtaining trading balance use: /api/v4/trade-account/balance

        $completeUrlMarkets = $baseUrl . $requestMarkets;

        $connect = curl_init($completeUrlMarkets);
        curl_setopt($connect, CURLOPT_RETURNTRANSFER, true);

        $apiMarketsResponse = curl_exec($connect);
        curl_close($connect);

//receiving data
        $jsonArrayMarketsResponse = json_decode($apiMarketsResponse);

        $requestTicker = '/api/v4/public/ticker'; //put here request path. For obtaining trading balance use: /api/v4/trade-account/balance

        $completeUrlTicker = $baseUrl . $requestTicker;

        $connect = curl_init($completeUrlTicker);
        curl_setopt($connect, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($connect, CURLOPT_TIMEOUT , 10);

        $apiTickerResponse = curl_exec($connect);
        curl_close($connect);

//receiving data
        $jsonArrayTickerResponse = json_decode($apiTickerResponse);

        $data = [];
        $index = 0;
        foreach ($jsonArrayMarketsResponse as $market){
            $item = $market;
            $item->last_price = $jsonArrayTickerResponse->{$market->name}->last_price;
            $item->change = $jsonArrayTickerResponse->{$market->name}->change;
            array_push($data, $item);
        }
        return $this->render('main/index.html.twig', [
            'data' => $data,
        ]);
    }
}
