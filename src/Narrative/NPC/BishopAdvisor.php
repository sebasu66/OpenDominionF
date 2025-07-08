<?php

namespace OpenDominion\Narrative\NPC;

use OpenDominion\Models\Dominion;

class BishopAdvisor extends Advisor
{
    public function __construct()
    {
        parent::__construct('Obispo', 'solemne', ['piadoso'], ['proteccion']);
    }

    public function executeOrder(Dominion $dominion, string $order): string
    {
        return 'He tomado nota de su orden espiritual: ' . $order;
    }
}
