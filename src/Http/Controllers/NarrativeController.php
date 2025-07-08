<?php

namespace OpenDominion\Http\Controllers;

use Illuminate\Http\Request;
use OpenDominion\Narrative\NarrativeStoreService;
use OpenDominion\Services\GameStateService;
use OpenDominion\Services\AI\OpenAIChatService;

class NarrativeController extends AbstractDominionController
{
    protected GameStateService $gameStateService;
    protected NarrativeStoreService $storeService;
    protected OpenAIChatService $aiService;

    public function __construct(GameStateService $gameStateService, NarrativeStoreService $storeService, OpenAIChatService $aiService)
    {
        $this->gameStateService = $gameStateService;
        $this->storeService = $storeService;
        $this->aiService = $aiService;
    }

    public function getChat()
    {
        return view('pages.narrative.chat');
    }

    public function getMessages()
    {
        $dominion = $this->getSelectedDominion();
        return response()->json($this->storeService->getMessages($dominion));
    }

    public function getState()
    {
        $dominion = $this->getSelectedDominion();
        return response()->json($this->gameStateService->getState($dominion));
    }

    public function postMessage(Request $request)
    {
        $dominion = $this->getSelectedDominion();
        $text = $request->input('message');
        $this->storeService->addMessage($dominion, [
            'role' => 'jugador',
            'content' => $text,
            'time' => now()->toDateTimeString(),
        ]);

        $state = $this->gameStateService->getState($dominion);
        $messages = array_merge(
            [
                ['role' => 'system', 'content' => 'Eres un grupo de asesores medievales que ayudan al jugador. Responde en español.'],
            ],
            $this->storeService->getMessages($dominion),
            [
                ['role' => 'user', 'content' => $text . "\n\nEstado:" . json_encode($state)],
            ]
        );
        $answer = $this->aiService->chat($messages);
        $this->storeService->addMessage($dominion, [
            'role' => 'ia',
            'content' => $answer['content'] ?? '',
            'time' => now()->toDateTimeString(),
        ]);

        return response()->json($this->storeService->getMessages($dominion));
    }
}
