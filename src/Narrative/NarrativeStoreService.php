<?php

namespace OpenDominion\Narrative;

use Illuminate\Filesystem\Filesystem;
use OpenDominion\Models\Dominion;

class NarrativeStoreService
{
    protected Filesystem $files;

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    protected function getPath(Dominion $dominion): string
    {
        return storage_path('app/narratives/dominion_' . $dominion->id . '.json');
    }

    public function getMessages(Dominion $dominion): array
    {
        $path = $this->getPath($dominion);
        if (!$this->files->exists($path)) {
            return [];
        }
        return json_decode($this->files->get($path), true) ?: [];
    }

    public function addMessage(Dominion $dominion, array $message): void
    {
        $messages = $this->getMessages($dominion);
        $messages[] = $message;
        $this->files->ensureDirectoryExists(dirname($this->getPath($dominion)));
        $this->files->put($this->getPath($dominion), json_encode($messages));
    }
}
