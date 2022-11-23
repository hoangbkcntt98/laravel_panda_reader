<?php

namespace App\Service;

use Google\Client;
use Google\Service\Sheets;

class GoogleSheetService{

    public function getClient()
    {
        $client = new Client();
        $client->setScopes(Sheets::SPREADSHEETS);
    }
}