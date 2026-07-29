<?php

namespace DruidLabs\DruidBot;

/**
 * Class NotSecrets
 *
 * Contains non-secret configuration values like API URLs.
 */
class NotSecrets {
    /**
     * @var string The API URL for Google Gemini.
     */
    public const GEMINI_API_URL = 'https://generativelanguage.googleapis.com/v1beta/interactions';

    /**
     * @var string The API URL for Anthropic Claude.
     */
    public const CLAUDE_API_URL = 'https://api.anthropic.com/v1/messages';

    /**
     * NotSecrets constructor.
     * Private to prevent instantiation.
     */
    private function __construct() {}
}
