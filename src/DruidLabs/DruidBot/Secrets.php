<?php

namespace DruidLabs\DruidBot;

/**
 * Class Secrets
 *
 * Provides access to secret API keys stored in environment variables.
 */
class Secrets {
    /**
     * @var string The environment variable name for the Gemini API key.
     */
    private const GEMINI_API_KEY = 'GEMINI_API_KEY';

    /**
     * @var string The environment variable name for the Anthropic API key.
     */
    private const ANTHROPIC_API_KEY = 'ANTHROPIC_API_KEY';

    /**
     * Returns the Gemini API key from environment variables.
     *
     * @return string|null The Gemini API key, or null if not set.
     */
    public static function getGeminiApiKey(): ?string {
        return getenv(self::GEMINI_API_KEY) ?: null;
    }

    /**
     * Returns the Anthropic API key from environment variables.
     *
     * @return string|null The Anthropic API key, or null if not set.
     */
    public static function getAnthropicApiKey(): ?string {
        return getenv(self::ANTHROPIC_API_KEY) ?: null;
    }

    /**
     * Secrets constructor.
     * Private to prevent instantiation.
     */
    private function __construct() {}
}
