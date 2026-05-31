<?php

namespace App\Services\Ai;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    private const BASE_URL = 'https://generativelanguage.googleapis.com/v1beta';

    /**
     * Retrieve the API key from database settings or env.
     */
    public function getApiKey(): ?string
    {
        return Setting::get('gemini_api_key') ?: config('services.gemini.key');
    }

    /**
     * Retrieve the active model name.
     */
    public function getActiveModel(): string
    {
        return Setting::get('gemini_active_model', 'gemini-1.5-flash');
    }

    /**
     * Fetch all available content-generation models from Gemini API.
     */
    public function listModels(): array
    {
        $apiKey = $this->getApiKey();
        if (!$apiKey) {
            return [];
        }

        try {
            $response = Http::get(self::BASE_URL . '/models', [
                'key' => $apiKey
            ]);

            if ($response->failed()) {
                Log::error('Gemini API listModels failed: ' . $response->body());
                return [];
            }

            $models = $response->json()['models'] ?? [];
            
            // Filter only models that support content generation
            $filtered = [];
            foreach ($models as $model) {
                $supportedMethods = $model['supportedGenerationMethods'] ?? [];
                if (in_array('generateContent', $supportedMethods)) {
                    // Extract baseline model name (e.g. models/gemini-1.5-flash -> gemini-1.5-flash)
                    $name = str_replace('models/', '', $model['name']);
                    $filtered[] = [
                        'name' => $name,
                        'displayName' => $model['displayName'] ?? $name,
                        'description' => $model['description'] ?? '',
                    ];
                }
            }

            return $filtered;
        } catch (\Exception $e) {
            Log::error('Gemini API listModels exception: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Generate content via Gemini generateContent API.
     */
    public function generateContent(string $prompt, ?string $systemInstruction = null): ?string
    {
        $apiKey = $this->getApiKey();
        if (!$apiKey) {
            Log::warning('Gemini API key is not configured.');
            return null;
        }

        $model = $this->getActiveModel();
        $url = self::BASE_URL . "/models/{$model}:generateContent?key={$apiKey}";

        try {
            $payload = [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ];

            if ($systemInstruction) {
                $payload['systemInstruction'] = [
                    'parts' => [
                        ['text' => $systemInstruction]
                    ]
                ];
            }

            $response = Http::post($url, $payload);

            if ($response->failed()) {
                Log::error("Gemini generateContent failed for model {$model}: " . $response->body());
                return null;
            }

            $data = $response->json();
            return $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
        } catch (\Exception $e) {
            Log::error("Gemini generateContent exception: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Dynamic Helper: Generate a high-converting product description.
     */
    public function generateProductDescription(string $name, string $category, ?string $brand = null): ?string
    {
        $prompt = "Create a premium, professional, and SEO-optimized e-commerce product description for a product named '{$name}' in the category '{$category}'" . ($brand ? " by brand '{$brand}'" : "") . ". Present key features in a bulleted list and keep the tone modern, enticing, and professional. Write the output in clean HTML formatting (use paragraphs and lists, do not include markdown blocks or ```html wrap). Limit description to 150-200 words.";
        
        return $this->generateContent($prompt, "You are a professional copywriter specialized in premium tech and consumer electronics e-commerce listings.");
    }

    /**
     * Dynamic Helper: Suggest product category based on product title/description.
     */
    public function suggestCategory(string $productName, string $description): ?string
    {
        $prompt = "Based on the product name '{$productName}' and its description: '{$description}', return ONLY the name of the most matching e-commerce category. Choose one of: 'Smartphones', 'Laptops & Computers', 'Audio & Headphones', 'Smartwatches', 'Televisions'. Do not write any other explanation or punctuation, return only the exact category name.";
        
        return $this->generateContent($prompt, "You are a database classification engine. Output strictly one matching category name.");
    }

    /**
     * Dynamic Helper: Generate SEO tags (Meta Title & Meta Description).
     */
    public function generateSeoTags(string $name, string $description): array
    {
        $prompt = "Generate a JSON string with two keys 'meta_title' and 'meta_description' for the e-commerce product '{$name}'. The 'meta_title' must be under 60 characters and include the product name. The 'meta_description' must be under 160 characters and be highly engaging. Output ONLY valid JSON: {\"meta_title\": \"...\", \"meta_description\": \"...\"}. Do not wrap it in markdown block code syntax.";
        
        $output = $this->generateContent($prompt, "You are an SEO expert specialized in retail search listings. Output strictly raw JSON.");
        
        if ($output) {
            try {
                // Strip markdown code block wrappers if generated
                $cleaned = preg_replace('/```(?:json)?|```/', '', $output);
                $decoded = json_decode(trim($cleaned), true);
                if (isset($decoded['meta_title']) && isset($decoded['meta_description'])) {
                    return $decoded;
                }
            } catch (\Exception $e) {
                Log::error('Failed to parse SEO JSON response: ' . $output);
            }
        }

        return [
            'meta_title' => substr($name . ' | Shop Premium Tech', 0, 60),
            'meta_description' => substr(strip_tags($description), 0, 155),
        ];
    }
}
