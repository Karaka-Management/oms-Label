<?php

/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\Labeling
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Labeling\Controller;

use Modules\Labeling\Models\LabelLayout;
use Modules\Labeling\Models\LabelLayoutL11nMapper;
use Modules\Labeling\Models\LabelLayoutMapper;
use phpOMS\Localization\BaseStringL11n;
use phpOMS\Localization\ISO639x1Enum;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;

/**
 * Labeling class.
 *
 * @package Modules\Labeling
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
final class ApiController extends Controller
{
    /**
     * Api method to create layout article
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiLabelLayoutCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateLabelLayoutCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $layout = $this->createLabelLayoutFromRequest($request);
        $this->createModel($request->header->account, $layout, LabelLayoutMapper::class, 'layout', $request->getOrigin());

        $old = clone $layout;
        $new = $this->uploadLayoutTemplate($layout, $request);
        $this->updateModel($request->header->account, $old, $new, LabelLayoutMapper::class, 'layout', $request->getOrigin());

        $this->createStandardCreateResponse($request, $response, $new);
    }

    /**
     * Validate layout create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateLabelLayoutCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['title'] = !$request->hasData('title'))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * Update the layout template
     *
     * @param LabelLayout     $layout  Label layout
     * @param RequestAbstract $request Request
     *
     * @return LabelLayout
     *
     * @since 1.0.0
     */
    private function uploadLayoutTemplate(LabelLayout $layout, RequestAbstract $request) : LabelLayout
    {
        $path = '/Modules/Labeling/Templates/' . $layout->id;

        $layout->template = $this->app->moduleManager->get('Media', 'Api')->uploadFiles(
            names: [],
            fileNames: [],
            files: $request->files,
            account: $request->header->account,
            basePath: __DIR__ . '/../../../Modules/Media/Files' . $path,
            virtualPath: $path
        );

        return $layout;
    }

    /**
     * Method to create LabelLayout from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return LabelLayout
     *
     * @since 1.0.0
     */
    private function createLabelLayoutFromRequest(RequestAbstract $request) : LabelLayout
    {
        $labelLayout = new LabelLayout();
        $labelLayout->setL11n(
            $request->getDataString('title') ?? '',
            ISO639x1Enum::tryFromValue($request->getDataString('language')) ?? ISO639x1Enum::_EN
        );

        return $labelLayout;
    }

    /**
     * Api method to create LabelLayout l11n
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiLabelLayoutL11nCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateLabelLayoutL11nCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $labelLayoutL11n = $this->createLabelLayoutL11nFromRequest($request);
        $this->createModel($request->header->account, $labelLayoutL11n, LabelLayoutL11nMapper::class, 'label_layout_l11n', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $labelLayoutL11n);
    }

    /**
     * Method to create LabelLayout l11n from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return BaseStringL11n
     *
     * @since 1.0.0
     */
    private function createLabelLayoutL11nFromRequest(RequestAbstract $request) : BaseStringL11n
    {
        $labelLayoutL11n           = new BaseStringL11n();
        $labelLayoutL11n->ref      = $request->getDataInt('layout') ?? 0;
        $labelLayoutL11n->language = ISO639x1Enum::tryFromValue($request->getDataString('language')) ?? $request->header->l11n->language;
        $labelLayoutL11n->content  = $request->getDataString('title') ?? '';

        return $labelLayoutL11n;
    }

    /**
     * Validate LabelLayout l11n create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateLabelLayoutL11nCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['title'] = !$request->hasData('title'))
            || ($val['layout'] = !$request->hasData('layout'))
        ) {
            return $val;
        }

        return [];
    }
}
