# Chatbot

A chatbot built with core php with support for multiple LLMs.

## Features
- Adapter pattern for LLM integration.
- Gemini API support using native `curl` (no SDK).
- Claude API support using native `curl`. (Currently no SDK)
- File attachment support.
- PSR-4 compliant structure.

## Requirements
- PHP 8.4.1 or higher. (For the Anthropic SDK)
- Composer.

## Setup
1. Install dependencies:
   ```bash
   composer install
   ```
2. Set your API keys as environment variables:
   ```bash
   export GEMINI_API_KEY=your_key
   export ANTHROPIC_API_KEY=your_key
   ```

## Usage
Run the main script:
```bash
php Main.php
```

## Project Structure
- `src/DruidLabs/DruidBot/Llm/`: Core LLM interfaces and base classes.
- `src/DruidLabs/DruidBot/Llm/Gemini/`: Gemini-specific implementation.
- `src/DruidLabs/DruidBot/Llm/Claude/`: Claude-specific implementation.
- `src/DruidLabs/DruidBot/Models/`: Model definitions.
- `src/DruidLabs/DruidBot/Utils/`: Utility classes (e.g., `Attachment`).
- `src/DruidLabs/DruidBot/Secrets.php`: Secret management.
- `src/DruidLabs/DruidBot/NotSecrets.php`: Global constants and endpoints.
