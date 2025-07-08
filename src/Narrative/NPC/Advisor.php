<?php

namespace OpenDominion\Narrative\NPC;

use OpenDominion\Models\Dominion;

abstract class Advisor
{
    protected string $name;
    protected string $tone;
    protected array $traits;
    protected array $inclinations;

    public function __construct(string $name, string $tone, array $traits = [], array $inclinations = [])
    {
        $this->name = $name;
        $this->tone = $tone;
        $this->traits = $traits;
        $this->inclinations = $inclinations;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTone(): string
    {
        return $this->tone;
    }

    public function getTraits(): array
    {
        return $this->traits;
    }

    public function getInclinations(): array
    {
        return $this->inclinations;
    }

    public function personality(): array
    {
        return [
            'tone' => $this->tone,
            'traits' => $this->traits,
            'inclinations' => $this->inclinations,
        ];
    }

    /**
     * Convert an order into game actions.
     * This default implementation is a stub meant to be overridden.
     */
    public function executeOrder(Dominion $dominion, string $order): string
    {
        return 'Orden recibida: ' . $order;
    }
}
