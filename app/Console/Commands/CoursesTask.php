<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;


class CoursesTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ciclos:task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envio de comunicaciones y ajuste de base de datos para ciclos';

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
     * @return int
     */
    public function handle()
    {
        
        $texto = date("Y-m-d H:i:s")." Hola mundo";
        Storage::append("archivo.txt",$texto);
    }
}
