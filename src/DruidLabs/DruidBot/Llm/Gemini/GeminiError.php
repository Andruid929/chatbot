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
    private string $status;

    private int $code;

    /**
     * GeminiError constructor.
     *
     * @param array $errorDetail The error object.
     */
    public function __construct(array $errorDetail) {
        $this->message = $errorDetail["message"];
        $this->status = $errorDetail["status"] ?? "Failed";
        $this->code = $errorDetail["code"] ?? 0;
    }

    /**
     * Returns the error message.
     *
     * @return string The error message.
     */
    public function message(): string {
        return $this->message;
    }

    public static function fromJson(string $json): GeminiError {
        $data = json_decode($json, true);

        return new self($data[0]['error']);
    }
}
