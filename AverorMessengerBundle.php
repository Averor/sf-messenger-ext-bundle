<?php declare(strict_types=1);

namespace Averor\Messenger;

use Averor\Messenger\DependencyInjection\BundleExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AverorMessengerBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new BundleExtension();
    }
}
