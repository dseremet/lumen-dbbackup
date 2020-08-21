<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Spatie\DbDumper\Databases\MySql;

class DbBackupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creating DB backup';

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
        $dateFormat = Carbon::now()->format('d-m-Y-H-i-');
        $databaseName = config('database.connections.mysql.database');
        $userName = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $folder = Carbon::now()->format('F-Y') ;

        if(!Storage::exists($folder)) {
            Storage::makeDirectory($folder, 0775, true); //creates directory

        }

//        try {
            MySql::create()
                ->setDbName($databaseName)
                ->setUserName($userName)
                ->setPassword($password)
                ->dumpToFile('storage/app/'.$folder.'/'.$dateFormat . 'db_dump.sql');
//        } catch (\Exception $exception) {
//
//        }

    }
}
