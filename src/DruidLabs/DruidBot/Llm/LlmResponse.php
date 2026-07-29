<?php

namespace DruidLabs\DruidBot\Llm;

/**
 * Class LlmResponse
 *
 * Represents a response from an LLM.
 */
readonly class LlmResponse {
    /**
     * LlmResponse constructor.
     *
     * @param string|null $text The response text, if successful.
     * @param LlmError|null $error The error, if the request failed.
     */
    public function __construct(
        private ?string $text = null,
        private ?LlmError $error = null
    ) {}

    /**
     * Returns the response text.
     *
     * @return string|null The response text.
     */
    public function text(): ?string {
        return $this->text;
    }

    /**
     * Returns the error, if any.
     *
     * @return LlmError|null The error.
     */
    public function error(): ?LlmError {
        return $this->error;
    }

    /**
     * Checks if the request was successful.
     *
     * @return bool True if successful, false otherwise.
     */
    public function isSuccess(): bool {
        return $this->error === null;
    }
}
