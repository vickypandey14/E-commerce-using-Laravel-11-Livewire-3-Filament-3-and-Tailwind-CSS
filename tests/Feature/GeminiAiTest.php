<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Services\Ai\GeminiService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GeminiAiTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Setting::set('gemini_api_key', 'test_key');
        Setting::set('gemini_active_model', 'gemini-1.5-flash');
    }

    /** @test */
    public function gemini_service_lists_content_generation_models()
    {
        Http::fake([
            'https://generativelanguage.googleapis.com/v1beta/models?key=test_key' => Http::response([
                'models' => [
                    [
                        'name' => 'models/gemini-1.5-flash',
                        'displayName' => 'Gemini 1.5 Flash',
                        'description' => 'Fast and lightweight model',
                        'supportedGenerationMethods' => ['generateContent']
                    ],
                    [
                        'name' => 'models/embedding-001',
                        'displayName' => 'Embeddings model',
                        'supportedGenerationMethods' => ['embedContent']
                    ]
                ]
            ], 200)
        ]);

        $service = app(GeminiService::class);
        $models = $service->listModels();

        $this->assertCount(1, $models);
        $this->assertEquals('gemini-1.5-flash', $models[0]['name']);
        $this->assertEquals('Gemini 1.5 Flash', $models[0]['displayName']);
    }

    /** @test */
    public function gemini_service_generates_product_description_correctly()
    {
        Http::fake([
            'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=test_key' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                ['text' => '<p>Enticing product description</p>']
                            ]
                        ]
                    ]
                ]
            ], 200)
        ]);

        $service = app(GeminiService::class);
        $description = $service->generateProductDescription('Smart TV Pro', 'Televisions', 'Sony');

        $this->assertNotNull($description);
        $this->assertEquals('<p>Enticing product description</p>', $description);
    }

    /** @test */
    public function gemini_service_suggests_category_name()
    {
        Http::fake([
            'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=test_key' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                ['text' => 'Smartwatches']
                            ]
                        ]
                    ]
                ]
            ], 200)
        ]);

        $service = app(GeminiService::class);
        $category = $service->suggestCategory('Sport Watch Max', 'Smart watch for athletes');

        $this->assertEquals('Smartwatches', $category);
    }
}
