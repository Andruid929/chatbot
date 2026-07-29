<?php

namespace DruidLabs\DruidBot\Llm;

/**
 * Interface LlmError
 *
 * Defines the contract for an error returned by an LLM adapter.
 */
interface LlmError {
    /**
     * Returns the error message.
     *
     * @return string The error message.
     */
    public function message(): string;
}
