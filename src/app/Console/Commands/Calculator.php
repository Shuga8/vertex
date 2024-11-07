<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Calculator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'binary:calculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculates isolation trades';

    /**
     * Execute the console command.
     */
    public function handle() {}
}
