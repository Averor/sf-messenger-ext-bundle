<?php declare(strict_types=1);

namespace Averor\Messenger\Stamp;

use Symfony\Component\Messenger\Stamp\StampInterface;

class CausationStamp implements StampInterface
{
    protected string $commandId;

    public function __construct(string $commandId)
    {
        $this->commandId = $commandId;
    }

    public function commandId() : string
    {
        return $this->commandId;
    }
}
