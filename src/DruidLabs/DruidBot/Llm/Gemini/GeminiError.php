<?php

namespace DruidLabs\DruidBot\Llm\Gemini;

use DruidLabs\DruidBot\Llm\LlmError;

/**
 * Class GeminiError
 *
 * Represents an error from the Gemini API.
 */
class GeminiError implements LlmError {
    /**
     * @var string The error message.
     */
    private string $message;

    /**
     * GeminiError constructor.
     *
     * @param string $message The error message.
     */
    public function __construct(string $message) {
        $this->message = $message;
    }

    /**
     * Returns the error message.
     *
     * @return string The error message.
     */
    public function message(): string {
        return $this->message;
    }
}
