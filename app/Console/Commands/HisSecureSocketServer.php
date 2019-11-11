<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use React\EventLoop\Factory;
use React\Socket\SecureServer;
use React\Socket\Server;
use App\Http\Controllers\Websocket\WebSocketController;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Websocket\HisSocketController;

class HisSecureSocketServer extends Command
{
        /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hisecuresocketserver:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Real Time Hospital Activities Run Here';

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
        try{

            $loop   = Factory::create();
            $webSock = new SecureServer(
                new Server('127.0.0.1:8086', $loop),
                $loop,
                array(
                    'local_cert'        => 'etc/ssl/certs/apache-selfsigned.crt', // path to your cert
                    'local_pk'          => 'etc/ssl/private/apache-selfsigned.key', // path to your server private key
                    'allow_self_signed' => TRUE, // Allow self signed certs (should be false in production)
                    'verify_peer' => FALSE
                )
            );
            // Ratchet magic
            $webServer = new IoServer( new HttpServer( new WsServer( new HisSocketController() ) ), $webSock );
            $loop->run();

        }catch(\Exception $e){
            echo "Err";
            Log::info($e);
        }
    }
}
