<?php

namespace OpenDominion\Services;

use OpenDominion\Models\Dominion;
use OpenDominion\Mappers\Dominion\InfoMapper;
use OpenDominion\Services\GameEventService;
use OpenDominion\Calculators\Dominion\ProductionCalculator;

class GameStateService
{
    protected InfoMapper $infoMapper;
    protected GameEventService $gameEventService;
    protected ProductionCalculator $productionCalculator;

    public function __construct(InfoMapper $infoMapper, GameEventService $gameEventService, ProductionCalculator $productionCalculator)
    {
        $this->infoMapper = $infoMapper;
        $this->gameEventService = $gameEventService;
        $this->productionCalculator = $productionCalculator;
    }

    /**
     * Returns the current game state for a dominion.
     */
    public function getState(Dominion $dominion): array
    {
        $status = $this->infoMapper->mapStatus($dominion, false);

        $production = [
            'platinum' => $this->productionCalculator->getPlatinumProduction($dominion),
            'food' => $this->productionCalculator->getFoodNetChange($dominion),
            'lumber' => $this->productionCalculator->getLumberNetChange($dominion),
            'mana' => $this->productionCalculator->getManaNetChange($dominion),
            'ore' => $this->productionCalculator->getOreProduction($dominion),
            'gems' => $this->productionCalculator->getGemProduction($dominion),
            'tech' => $this->productionCalculator->getTechProduction($dominion),
            'boats' => $this->productionCalculator->getBoatProduction($dominion),
        ];

        return [
            'status' => $status,
            'military' => $this->infoMapper->mapMilitary($dominion, false),
            'buildings' => $this->infoMapper->mapBuildings($dominion),
            'land' => $this->infoMapper->mapLand($dominion),
            'events' => $this->gameEventService->getLatestInvasionEventsForDominion($dominion, 5),
            'production_per_hour' => $production,
        ];
    }

    public function getStateJson(Dominion $dominion): string
    {
        return json_encode($this->getState($dominion));
    }
}
