<?php

namespace Tests\Unit;

use Tests\TestCase;
use ReflectionClass;
use App\Models\Student;
use App\Services\CSVOutput;
use App\Services\StudentCSVOutput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StudentCSVOutputTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function testInstanceOfCSVOutput()
    {
        $rc = new ReflectionClass(StudentCSVOutput::class);

        $this->assertTrue($rc->isSubclassOf(CSVOutput::class));
    }

    public function testOnlyTakesCollectionOfStudentModel()
    {
        $models = collect([
            new class extends Model {
            }
        ]);
        try {
            $csv = new StudentCSVOutput($models);
        } catch (\TypeError $e) {
            $this->assertContains('must be an instance of ' . Student::class, $e->getMessage());
        }
    }
}
