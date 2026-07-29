<?php

namespace DruidLabs\DruidBot\Llm\Gemini;

use DruidLabs\DruidBot\Llm\LlmAdapter;
use DruidLabs\DruidBot\Llm\LlmRequest;
use DruidLabs\DruidBot\Llm\LlmResponse;
use DruidLabs\DruidBot\Secrets;
use DruidLabs\DruidBot\NotSecrets;
use DruidLabs\DruidBot\Utils\Attachment;

/**
 * Class GeminiAdapter
 *
 * Adapter for the Google Gemini API.
 */
class GeminiAdapter implements LlmAdapter
{
    /**
     * @var string|null The Gemini API key.
     */
    private ?string $apiKey;

    /**
     * GeminiAdapter constructor.
     */
    public function __construct()
    {
        $this->apiKey = Secrets::getGeminiApiKey();
    }

    /**
     * Sends a request to the Gemini API.
     *
     * @param LlmRequest $request The request to send.
     * @return LlmResponse The response from the Gemini API.
     * @throws \InvalidArgumentException If the request is not an instance of GeminiRequest.
     */
    public function ask(LlmRequest $request): LlmResponse
    {
        if (!$request instanceof GeminiRequest) {
            throw new \InvalidArgumentException("Invalid LLM request type");
        }

        if (!$this->apiKey) {
            return new LlmResponse(null, new GeminiError("GEMINI_API_KEY is not set"));
        }

        $url = NotSecrets::GEMINI_API_URL . '?key=' . $this->apiKey;

        $input = [['text' => $request->prompt(), 'type' => 'text']];

        foreach ($request->attachments() as $attachment) {
            if ($attachment instanceof Attachment) {
                $input[] = [
                    'mime_type' => $attachment->getMimeType(),
                    'data' => $attachment->getBase64Data(),
                    'type' => 'image'
                ];
            }
        }

        $payload = [
            'model' => $request->modelId(),
            'input' => $input
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Api-Revision: 2026-05-20'
        ]);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($result === false) {
            return new LlmResponse(null, new GeminiError("Curl error: " . $error));
        }

        if ($httpCode >= 400) {
            return new LlmResponse(null, new GeminiError("API error (HTTP $httpCode): " . $result));
        }

        try {
            $geminiResponse = GeminiResponse::fromJson($result);

            $text = $geminiResponse->getOutputText();

            return new LlmResponse($text);
            
        } catch (\Exception $e) {
            return new LlmResponse(null, new GeminiError("Mapping error: " . $e->getMessage()));
        }
    }
}
