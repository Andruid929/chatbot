<?php

namespace DruidLabs\DruidBot\Llm\Claude;

use DruidLabs\DruidBot\Llm\LlmError;

/**
 * Class ClaudeError
 *
 * Represents an error from the Claude API.
 */
class ClaudeError implements LlmError {
    /**
     * @var string The type of the error.
     */
    private string $type;
    
    /**
     * @var array|null The detailed error information.
     */
    private ?array $errorDetail;

    /**
     * ClaudeError constructor.
     *
     * @param string $messageOrType The error message or error type.
     * @param array|null $errorDetail The detailed error information.
     */
    public function __construct(string $messageOrType, ?array $errorDetail = null) {
        if ($errorDetail === null) {
            $this->type = 'error';
            $this->errorDetail = ['type' => 'unknown_error', 'message' => $messageOrType];

        } else {
            $this->type = $messageOrType;
            $this->errorDetail = $errorDetail;
        }
    }

    /**
     * Creates a ClaudeError instance from a JSON response.
     *
     * @param string $json The JSON response from the API.
     * @return self The ClaudeError instance.
     */
    public static function fromJson(string $json): self {
        $data = json_decode($json, true);
        
        return new self($data['type'] ?? 'error', $data['error'] ?? null);
    }

    /**
     * Returns the error message.
     *
     * @return string The error message.
     */
    public function message(): string {
        return $this->errorDetail['message'] ?? 'Unknown Claude error';
    }
}
