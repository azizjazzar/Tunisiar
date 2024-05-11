<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IAController extends Controller
{
    public function GemeniWithText(Request $request)
    {
        try {
            $text = $request->input('text');

            $requestBody = [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $text],
                        ],
                    ],
                ],
                'generationConfig' => [
                    'temperature' => 1,
                    'topK' => 0,
                    'topP' => 0.95,
                    'maxOutputTokens' => 8192,
                    'stopSequences' => [],
                ],
                'safetySettings' => [
                    [
                        'category' => 'HARM_CATEGORY_HARASSMENT',
                        'threshold' => 'BLOCK_MEDIUM_AND_ABOVE',
                    ],
                    [
                        'category' => 'HARM_CATEGORY_HATE_SPEECH',
                        'threshold' => 'BLOCK_MEDIUM_AND_ABOVE',
                    ],
                    [
                        'category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT',
                        'threshold' => 'BLOCK_MEDIUM_AND_ABOVE',
                    ],
                    [
                        'category' => 'HARM_CATEGORY_DANGEROUS_CONTENT',
                        'threshold' => 'BLOCK_MEDIUM_AND_ABOVE',
                    ],
                ],
            ];

            $response = Http::post('https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-pro-latest:generateContent?key=' . env('GEMINIKEY'), $requestBody);

            // Extract the text from the response
            $generatedText = $response->json()['candidates'][0]['content']['parts'][0]['text'];

            // Trim the response text
            $generatedText = trim($generatedText);

            // Return the generated text as JSON response
            return response()->json(['answer' => $generatedText]);
        } catch (\Exception $error) {
            // Log the error
            \Log::error("Error during request to Google Gemini: " . $error->getMessage());
            
            // Return an error response
            return response()->json(['message' => "An error occurred during the request to Google Gemini"], 500);
        }
    }
}
