<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\Storage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CreateCsvFileCommand extends Command
{
    const TOTAL_RECORD = 2306000;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CreateCsvFile';

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
     * @return int
     */
    public function handle()
    {
        Log::info("CreateCsvFileCommand START");
        $serialNumbers = [];
            $fistNumber = '123456789';
            $number = '0123456789';
            for($number4th = 0; $number4th <= 9; $number4th++){
                for($number8th = 0; $number8th <= 9; $number8th++){
                    $listNumbers=[];
                    while (count($listNumbers)< self::TOTAL_RECORD/100) {
                        $serialNumber = $fistNumber[mt_rand(0, strlen($fistNumber) - 1)];
                        $serialNumber .= $number[mt_rand(0, strlen($number) - 1)];
                        $serialNumber .= $number[mt_rand(0, strlen($number) - 1)];
                        $serialNumber .= $number4th;
                        $serialNumber .= $number[mt_rand(0, strlen($number) - 1)];
                        $serialNumber .= $number[mt_rand(0, strlen($number) - 1)];
                        $serialNumber .= $number[mt_rand(0, strlen($number) - 1)];
                        $serialNumber .= $number8th;
                        $serialNumber .= $number[mt_rand(0, strlen($number) - 1)];
                        $serialNumber .= $number[mt_rand(0, strlen($number) - 1)];
                        $serialNumber .= $number[mt_rand(0, strlen($number) - 1)];
                        $serialNumber .= $number[mt_rand(0, strlen($number) - 1)];
                        //validate
                        $isError = false;
                        foreach ($listNumbers as $value){
                            if((substr($serialNumber,0,10) ==substr($value,0,10))
                                ||(substr($serialNumber,1,10) ==substr($value,1,10))
                                ||(substr($serialNumber,2,10) ==substr($value,2,10))){
                                    $isError = true;
                                    Log::error($serialNumber);
                                    break;
                                }
                        }
                        if($isError==false){
                            array_push($listNumbers, $serialNumber);
                            array_push($serialNumbers, $serialNumber);
                        }
                    }
                    Log::info("processed record= ".count($serialNumbers));
                }
            }
        $data = array_slice($serialNumbers, 0, count($serialNumbers) / 2);
        Storage::disk('local')->put('1twng0001.txt', implode(PHP_EOL,$data).PHP_EOL);
        $data = array_slice($serialNumbers, count($serialNumbers) / 2);
        Storage::disk('local')->put('1twng0002.txt', implode(PHP_EOL,$data).PHP_EOL);
        Log::info("CreateCsvFileCommand END");
    }

}
