<?php

namespace Tests\Unit;

use Storage;
use Tests\TestCase;
use ReflectionClass;
use App\Services\Output;
use App\Services\CSVOutput;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CSVOutputTest extends TestCase
{
    public function testOnlyTakesCollection()
    {
        try {
            $csv = new CSVOutput('');
        } catch (\TypeError $e) {
            $this->assertContains('must be an instance of ' . Collection::class, $e->getMessage());
        }
    }
    public function testInstanceOfOutput()
    {
        $rc = new ReflectionClass(CSVOutput::class);

        $this->assertTrue($rc->isSubclassOf(Output::class));
    }

    public function testSave()
    {
        $csv = new CSVOutput(collect([
            ['r1one', 'r1two', 'r1three'],
            ['r2one', 'r2two', 'r2three'],
        ]));
        $path = $csv->getShortStoragePath();

        Storage::fake('local');
        Storage::assertMissing($path);
        $csv->save();
        Storage::assertExists($path);
    }
}
