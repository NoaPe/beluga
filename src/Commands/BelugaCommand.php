<?php

namespace NoaPe\Beluga\Commands;

use Illuminate\Console\Command;

class BelugaCommand extends Command
{
    public $signature = 'beluga';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
