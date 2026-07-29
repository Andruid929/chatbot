<?php

namespace DruidLabs\DruidBot\Llm;

/**
 * Interface LlmAdapter
 *
 * Defines the contract for an LLM adapter that can process requests and return responses.
 */
interface LlmAdapter {
    /**
     * Sends a request to the LLM and returns the response.
     *
     * @param LlmRequest $request The request to send.
     * @return LlmResponse The response from the LLM.
     */
    public function ask(LlmRequest $request): LlmResponse;
}
