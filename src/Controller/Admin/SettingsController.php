<?php

declare(strict_types=1);

namespace InSquare\OpendxpDeeplBundle\Controller\Admin;

use InSquare\OpendxpDeeplBundle\Service\DeeplSettings;
use OpenDxp\Bundle\AdminBundle\Controller\AdminAbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class SettingsController extends AdminAbstractController
{
    #[Route('/settings', name: 'insquare_opendxp_deepl_settings', methods: ['GET'])]
    public function settingsAction(DeeplSettings $settings): JsonResponse
    {
        $this->checkPermission('settings');

        return $this->adminJson([
            'configured' => $settings->isConfigured(),
            'accountType' => $settings->getAccountType(),
        ]);
    }
}
