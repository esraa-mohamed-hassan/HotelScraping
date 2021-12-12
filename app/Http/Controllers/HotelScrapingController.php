<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Response;

class HotelScrapingController extends Controller
{
    public function scraping(){
        $urls = ['http://www.mocky.io/v2/5e400f423300005500b04d0c',
                 'http://www.mocky.io/v2/5e4010ad3300004200b04d15'];

        $data = [];         
        foreach($urls as $url){
            $response = Http::get($url);
            if($response->status() == 200){
                foreach($response->json() as $res){
                    array_push($data, $res);
                }
            }
        } 

        foreach ($data as $key => $row)
        {
            switch($row['Rate']){
                case '*':
                    $rate[$key] = 1;
                    break;
                case '**':
                    $rate[$key] = 2;
                    break;
                case '***':
                    $rate[$key] = 3;
                    break;
                case '****':
                    $rate[$key] = 4;
                    break;
                case '*****':
                    $rate[$key] = 5;
                    break;
                default:
                    $rate[$key] = $row['Rate'];
            }
        }  
        array_multisort($rate, SORT_DESC, $data);

        return Response::json([
            'status' => '200',
            'message' => 'Success',
            'data' => $data
        ], 200);        
    }
}
