<?php

declare(strict_types=1);

namespace InSquare\OpendxpDeeplBundle;

use InSquare\OpendxpDeeplBundle\DependencyInjection\InSquareOpendxpDeeplExtension;
use OpenDxp\Extension\Bundle\AbstractOpenDxpBundle;
use OpenDxp\Extension\Bundle\OpenDxpBundleAdminClassicInterface;
use OpenDxp\Extension\Bundle\Traits\BundleAdminClassicTrait;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

final class InSquareOpendxpDeeplBundle extends AbstractOpenDxpBundle implements OpenDxpBundleAdminClassicInterface
{
    use BundleAdminClassicTrait;

    public function getJsPaths(): array
    {
        return [
            '/bundles/insquareopendxpdeepl/js/util/progress.js',
            '/bundles/insquareopendxpdeepl/js/object/translate.js',
            '/bundles/insquareopendxpdeepl/js/document/translate.js',
            '/bundles/insquareopendxpdeepl/js/opendxp/startup.js',
        ];
    }

    public function getEditmodeJsPaths(): array
    {
        return [
            '/bundles/insquareopendxpdeepl/js/util/progress.js',
            '/bundles/insquareopendxpdeepl/js/document/translate.js',
            '/bundles/insquareopendxpdeepl/js/document/areablock.js',
            '/bundles/insquareopendxpdeepl/js/document/block.js',
        ];
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        if ($this->extension === null) {
            $this->extension = new InSquareOpendxpDeeplExtension();
        }

        return $this->extension;
    }
}
