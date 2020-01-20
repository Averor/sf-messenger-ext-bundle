<?php declare(strict_types=1);

namespace Averor\Messenger;

use Symfony\Component\Messenger\Envelope;

interface MessageLogger
{
    public function log(Envelope $envelope): void;
}
