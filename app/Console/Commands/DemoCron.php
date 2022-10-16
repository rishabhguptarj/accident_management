<?php
   
namespace App\Console\Commands;
   
use Illuminate\Console\Command;
use App\Imports\csvImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\CsvModel;
use App\Models\CsvFile;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

   
class DemoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    
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
        $csvfile = "http://127.0.0.1:8000/public/uploads/empty.csv";
        Excel::import(new csvImport, $csvfile);
        \Log::info("Cron is working fine!");

    }
}