<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Student;
use App\Models\DownloadLog;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExportControllerTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    /**
     * DOWNLOAD LOG
     */

    public function testExportDownloadLogSuccess()
    {
        Storage::fake('local');
        $model = factory(DownloadLog::class)->create();
        $response = $this->get('/downloads/1');

        $response->assertStatus(200);

        // Not sure the best way to check for file
        $this->assertTrue($response->baseResponse instanceof BinaryFileResponse);
        $this->assertContains('attachment; filename="', $response->headers->get('content-disposition'));
    }

    public function testExportDownloadLogBadData(): void
    {
        Storage::fake('local');
        $response = $this->get('/downloads/0');

        $response->assertStatus(302);
    }

    /**
     * STUDENTS
     */

    public function testExportStudentsNoData(): void
    {
        Storage::fake('local');
        $response = $this->post('/export');

        $response->assertStatus(302);
    }

    public function testExportStudentsBadData(): void
    {
        Storage::fake('local');
        $response = $this->post('/export', [
            'studentId' => 0
        ]);

        $response->assertStatus(302);
    }

    /**
     * composer.lock with version 5.4.11?
     * Nice one.
     */
    public function testExportStudentsSuccess(): void
    {
        Storage::fake('local');
        $model = factory(Student::class)->create();
        $response = $this->post('/export', [
            'studentId' => [$model->id],
        ]);


        $response->assertStatus(200);
        // Not sure the best way to check for file
        $this->assertTrue($response->baseResponse instanceof BinaryFileResponse);
        $this->assertContains('attachment; filename="', $response->headers->get('content-disposition'));

        $filename = explode('"', $response->headers->get('content-disposition'));
        $filename = str_replace('-', '/', $filename[1]);

        Storage::assertExists($filename);
    }
}
