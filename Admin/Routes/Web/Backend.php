<?php declare(strict_types=1);

use Modules\Labeling\Controller\BackendController;
use Modules\Labeling\Models\PermissionState;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^/warehouse/labeling/item/list(\?.*$|$)' => [
        [
            'dest'       => '\Modules\Labeling\Controller\BackendController:viewItemList',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionState::LABEL,
            ],
        ],
    ],
    '^/warehouse/labeling/item(\?.*$|$)' => [
        [
            'dest'       => '\Modules\Labeling\Controller\BackendController:viewItem',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionState::LABEL,
            ],
        ],
    ],
    '^/warehouse/labeling/layout(\?.*$|$)' => [
        [
            'dest'       => '\Modules\Labeling\Controller\BackendController:viewLayout',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionState::LABEL,
            ],
        ],
    ],
    '^/warehouse/labeling/layout/list(\?.*$|$)' => [
        [
            'dest'       => '\Modules\Labeling\Controller\BackendController:viewItemLabelList',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionState::LABEL,
            ],
        ],
    ],
];
