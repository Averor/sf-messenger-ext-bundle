<?php declare(strict_types=1);

namespace Averor\Messenger\Logger;

use Symfony\Component\Messenger\Envelope;

interface CommandLogger
{
    public function log(Envelope $envelope): void;
}
