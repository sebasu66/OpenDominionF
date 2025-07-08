<?php

namespace OpenDominion\Narrative\NPC;

use OpenDominion\Models\Dominion;
use OpenDominion\Services\Dominion\Actions\ConstructActionService;

class BuilderAdvisor extends Advisor
{
    protected ConstructActionService $constructActionService;

    public function __construct(ConstructActionService $constructActionService)
    {
        parent::__construct('Maestro Constructor', 'entusiasta', ['creativo'], ['expansion']);
        $this->constructActionService = $constructActionService;
    }

    public function executeOrder(Dominion $dominion, string $order): string
    {
        if (stripos($order, 'construir') !== false) {
            $this->constructActionService->construct($dominion, ['building_home' => 1]);
            return 'Se ha iniciado la construcción.';
        }
        return parent::executeOrder($dominion, $order);
    }
}
