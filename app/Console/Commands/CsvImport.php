<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Http\Controllers\CsvUpload;
class CsvImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports all csv data into database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $csv = new CsvUpload();
        $csv->csvCron();
    }
}
