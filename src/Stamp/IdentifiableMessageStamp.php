<?php declare(strict_types=1);

namespace Averor\Messenger\Stamp;

use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Stamp\StampInterface;

class IdentifiableMessageStamp implements StampInterface
{
    protected string $messageId;

    public function __construct(?string $messageId = null)
    {
        $this->messageId = $messageId ?: (string) Uuid::uuid4();
    }

    public function messageId() : string
    {
        return $this->messageId;
    }
}
