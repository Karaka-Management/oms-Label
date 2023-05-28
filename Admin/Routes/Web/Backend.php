<?php declare(strict_types=1);

use Modules\Labeling\Controller\BackendController;
use Modules\Labeling\Models\PermissionState;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^.*/controlling/budget/dashboard.*$' => [
        [
            'dest'       => '\Modules\Labeling\Controller\BackendController:viewBudgetingDashboard',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionState::LABEL,
            ],
        ],
    ],
];
