<?php

require_once __DIR__ . '/vendor/autoload.php';

use DruidLabs\DruidBot\Llm\Claude\ClaudeAdapter;
use DruidLabs\DruidBot\Llm\Claude\ClaudeRequest;
use DruidLabs\DruidBot\Llm\Gemini\GeminiAdapter;
use DruidLabs\DruidBot\Llm\Gemini\GeminiRequest;
use DruidLabs\DruidBot\Models\GeminiModel;
use DruidLabs\DruidBot\Models\ClaudeModel;
use DruidLabs\DruidBot\Utils\FileReader;

function main() {
    echo "Type the LLM to use (Claude/Gemini): ";
    $llm = trim(fgets(STDIN));

    if (!in_array(strtolower($llm), ['gemini', 'claude'])) {
        fwrite(STDERR, "Invalid or unsupported LLM selected\n");

        exit(1);
    }

    echo "Ask a question: ";
    $prompt = trim(fgets(STDIN));

    $adapter = null;
    $request = null;

    switch (strtolower($llm)) {
        case 'gemini':
            $adapter = new GeminiAdapter();

            $request = new GeminiRequest(
                GeminiModel::GEMINI_3_6_FLASH,
                $prompt,
                []
            );
            break;

        case 'claude':
            $adapter = new ClaudeAdapter();

            $request = new ClaudeRequest(
                ClaudeModel::CLAUDE_HAIKU_4_5,
                $prompt,
                []
            );
            break;
    }

    // Uncomment the line below and set an absolute path to an image file to add an attachment to send to the model
    // $request->addAttachment(FileReader::readFile('/home/andrew/Pictures/Screenshots/Terminal shot.png'));

    if ($adapter && $request) {
        $response = $adapter->ask($request);

        if ($response->isSuccess()) {
            echo $response->text() . PHP_EOL;
            
        } else {
            fwrite(STDERR, $response->error()->message() . PHP_EOL);
        }
    }
}

main();
