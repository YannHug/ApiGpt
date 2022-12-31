<?php

namespace App\Service;

use Orhanerday\OpenAi\OpenAi;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class OpenAiService
{
    public function __construct(private ParameterBagInterface $params)
    {

    }

    public function getPrompt(string $prompt): string
    {
        $openAiKey = $this->params->get('OPENAI_API_KEY');
        $open_ai = new OpenAi($openAiKey);
        $complete = $open_ai->completion([
            'model' => 'text-davinci-003',
            'prompt' => $prompt,
            'max_tokens' => 3500,
            'temperature' => 0.9,
            'frequency_penalty' => 0.5,
            'presence_penalty' => 0,
        ]);

        $json = json_decode($complete, true);

        return $json['choices'][0]['text'] ?? 'Une erreur est survenue';
    }
}