<?php

namespace DruidLabs\DruidBot\Llm\Gemini;

/**
 * Class GeminiResponse
 *
 * Represents a response from the Gemini API.
 */
class GeminiResponse {
    /**
     * @var string The response ID.
     */
    public string $id;
    
    /**
     * @var string The status of the response.
     */
    public string $status;
    
    /**
     * @var array Token usage information.
     */
    public array $usage;
    
    /**
     * @var array The steps taken to generate the response.
     */
    public array $steps;
    
    /**
     * @var string The model name.
     */
    public string $model;
    
    /**
     * @var string The object type.
     */
    public string $object;

    /**
     * Creates a GeminiResponse instance from a JSON response.
     *
     * @param string $json The JSON response from the API.
     * @return self The GeminiResponse instance.
     */
    public static function fromJson(string $json): self {
        $data = json_decode($json, true);
        $instance = new self();
        $instance->id = $data['id'] ?? '';
        $instance->status = $data['status'] ?? '';
        $instance->usage = $data['usage'] ?? [];
        $instance->steps = $data['steps'] ?? [];
        $instance->model = $data['model'] ?? '';
        $instance->object = $data['object'] ?? '';
        return $instance;
    }

    /**
     * Extracts the output text from the response steps.
     *
     * @return string|null The output text, or null if not found.
     */
    public function getOutputText(): ?string {
        foreach ($this->steps as $step) {
            if (($step['type'] ?? '') === 'model_output') {
                $contents = $step['content'] ?? [];
                foreach ($contents as $content) {
                    if (($content['type'] ?? '') === 'text') {
                        return $content['text'] ?? null;
                    }
                }
            }
        }
        return null;
    }
}
