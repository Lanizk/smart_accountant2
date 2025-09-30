<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MpesaService;

class RegisterMpesaUrls extends Command
{
    protected $signature = 'mpesa:register-urls';
    protected $description = 'Register M-Pesa C2B Validation & Confirmation URLs';

    public function handle(MpesaService $mpesa)
    {
        $this->info('Registering URLs with M-Pesa...');

        $response = $mpesa->registerUrls();

        $this->info('Response: ' . json_encode($response));
    }
}
