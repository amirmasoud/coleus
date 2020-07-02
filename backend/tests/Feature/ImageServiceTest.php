<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Services\ImageService;
use Tests\TestCase;

class ImageServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testImagePublicUrl()
    {
        $image = new ImageService();

        // ImgProxy uses MinIO not Laravel storage/framework/testing/ directory.
        $path = Storage::put('test', UploadedFile::fake()->image('test.jpeg', 1024, 1024));
        Storage::assertExists($path);

        $url = $image->publicUrl('public/' . $path, 512, 512);
        $this->assertFalse(filter_var($url, FILTER_VALIDATE_URL) === false);

        // failed to open stream: Connection refused
        // $this->get($url)
        //     ->assertOk()
        //     ->assertHeader('content-type', 'image/jpeg');

        Storage::deleteDirectory('test');
    }
}
