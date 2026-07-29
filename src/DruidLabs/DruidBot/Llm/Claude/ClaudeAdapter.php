<?php

namespace DruidLabs\DruidBot\Llm\Claude;

use DruidLabs\DruidBot\Llm\LlmAdapter;
use DruidLabs\DruidBot\Llm\LlmRequest;
use DruidLabs\DruidBot\Llm\LlmResponse;
use DruidLabs\DruidBot\Secrets;
use DruidLabs\DruidBot\NotSecrets;

/**
 * Class ClaudeAdapter
 *
 * Adapter for the Anthropic Claude API.
 */
class ClaudeAdapter implements LlmAdapter
{

    /**
     * @var string|null The Anthropic API key.
     */
    private ?string $apiKey;

    /**
     * ClaudeAdapter constructor.
     */
    public function __construct()
    {
        $this->apiKey = Secrets::getAnthropicApiKey();
    }

    /**
     * Sends a request to the Claude API.
     *
     * @param LlmRequest $request The request to send.
     * @return LlmResponse The response from the Claude API.
     * @throws \InvalidArgumentException If the request is not an instance of ClaudeRequest.
     */
    public function ask(LlmRequest $request): LlmResponse
    {
        if (!$request instanceof ClaudeRequest) {
            throw new \InvalidArgumentException("Invalid LLM request type");
        }

        if (!$this->apiKey) {
            return new LlmResponse(null, new ClaudeError("ANTHROPIC_API_KEY is not set"));
        }

        $url = NotSecrets::CLAUDE_API_URL;

        $payload = [
            'model' => $request->modelId(),
            'max_tokens' => 2048,
            'messages' => [
                ['role' => 'user', 'content' => $request->prompt()]
            ]
        ];

        if (!empty($request->attachments())) {
            $content = [['type' => 'text', 'text' => $request->prompt()]];

            foreach ($request->attachments() as $attachment) {
                $content[] = [
                    'type' => $attachment->getType(),
                    'source' => [
                        'type' => 'base64',
                        'media_type' => $attachment->getMimeType(),
                        'data' => $attachment->getBase64Data()
                    ]
                ];
            }
            $payload['messages'][0]['content'] = $content;
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'x-api-key: ' . $this->apiKey,
            'anthropic-version: 2023-06-01'
        ]);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($result === false) {
            return new LlmResponse(null, new ClaudeError("Curl error: " . $error));
        }

        if ($httpCode >= 400) {
            return new LlmResponse(null, ClaudeError::fromJson($result));
        }

        $data = json_decode($result, true);
        $text = $data['content'][0]['text'] ?? 'No response text'; //This is equivalen to `content->getTextBlock()->text`

        return new LlmResponse($text);
    }
}
