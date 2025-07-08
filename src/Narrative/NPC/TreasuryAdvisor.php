<?php

namespace OpenDominion\Narrative\NPC;

use OpenDominion\Models\Dominion;

class TreasuryAdvisor extends Advisor
{
    public function __construct()
    {
        parent::__construct('Tesorero', 'formal', ['avaro', 'calculador'], ['ahorro']);
    }

    public function executeOrder(Dominion $dominion, string $order): string
    {
        // Placeholder behavior
        return 'He registrado su orden sobre las finanzas: ' . $order;
    }
}
