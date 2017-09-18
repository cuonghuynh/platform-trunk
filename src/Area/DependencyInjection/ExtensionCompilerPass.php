<?php declare(strict_types=1);

namespace Shopware\Area\DependencyInjection;

use Shopware\Framework\DependencyInjection\TagReplaceTrait;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class ExtensionCompilerPass implements CompilerPassInterface
{
    use TagReplaceTrait;

    public function process(ContainerBuilder $container): void
    {
        $this->replaceArgumentWithTaggedServices($container, 'shopware.area.factory', 'shopware.area.extension', 1);

        $services = $container->findTaggedServiceIds('shopware.area.extension');
        /** @var Definition $service */
        foreach ($services as $service) {
            if ($service->hasTag('kernel.event_subscriber')) {
                continue;
            }
            $service->addTag('kernel.event_subscriber');
        }
    }
}
