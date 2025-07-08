<?php

namespace OpenDominion\Narrative\NPC;

use OpenDominion\Models\Dominion;
use OpenDominion\Services\Dominion\Actions\Military\TrainActionService;

class MilitaryAdvisor extends Advisor
{
    protected TrainActionService $trainActionService;

    public function __construct(TrainActionService $trainActionService)
    {
        parent::__construct('General', 'severo', ['estratega', 'disciplinado'], ['expansivo']);
        $this->trainActionService = $trainActionService;
    }

    public function executeOrder(Dominion $dominion, string $order): string
    {
        // Simplified example: if order contains 'entrenar', train one unit
        if (stripos($order, 'entrenar') !== false) {
            $this->trainActionService->train($dominion, ['unit1' => 1]);
            return 'Tropas entrenadas.';
        }
        return parent::executeOrder($dominion, $order);
    }
}
