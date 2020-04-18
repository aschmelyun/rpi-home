<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Datapoint;

class ImportTemperatures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'temperatures:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parses the temperatures.csv file export from the previous database, imports array with new db layout';

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
        $filename = storage_path('app/temperatures.csv');
        if(is_file($filename)) {
            $this->info('It is a valid file');
        }
        $handle = fopen($filename,'r');
        $first = true;
        while ( ($data = fgetcsv($handle) ) !== FALSE ) {
            if($first) {
                $first = false;
                continue;
            }

            $tempF = ($data[0] * 1.8) + 32;
            $datapoint = Datapoint::create([
                'name' => 'temperature',
                'value' => number_format((float)$tempF, 1, '.', ''),
                'cast' => 'float',
                'created_at' => $data[2],
                'updated_at' => $data[3]
            ]);

            $this->line('Datapoint #' . $datapoint->id . ' created successfully.');

            $datapoint = Datapoint::create([
                'name' => 'humidity',
                'value' => $data[1],
                'cast' => 'float',
                'created_at' => $data[2],
                'updated_at' => $data[3]
            ]);

            $this->line('Datapoint #' . $datapoint->id . ' created successfully.');
        }

        return;
    }
}
