<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Modules\Labeling
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\Labeling\Controller;

use Modules\ItemManagement\Models\ItemMapper;
use Modules\Labeling\Models\LabelLayoutMapper;
use phpOMS\Contract\RenderableInterface;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Views\View;

/**
 * Budgeting controller class.
 *
 * @package Modules\Labeling
 * @license OMS License 2.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
final class BackendController extends Controller
{
    /**
     * Routing end-point for application behaviour.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewItemLabelList(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);
        $view->setTemplate('/Modules/Labeling/Theme/Backend/layout-list');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1005701001, $request, $response);

        /** @var \Modules\Labeling\Models\LabelLayout[] $layouts */
        $layouts = LabelLayoutMapper::getAll()
            ->with('l11n')
            ->with('template')
            ->with('template/sources')
            ->where('l11n/language', $response->header->l11n->language)
            ->execute();

        $view->data['layouts'] = $layouts;

        return $view;
    }

    /**
     * Routing end-point for application behaviour.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewItemList(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);
        $view->setTemplate('/Modules/Labeling/Theme/Backend/item-list');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1005701001, $request, $response);

        /** @var \Modules\ItemManagement\Models\Item[] $items */
        $items = ItemMapper::getAll()
            ->with('l11n')
            ->with('l11n/type')
            ->with('files')
            ->with('files/types')
            ->where('l11n/language', $response->header->l11n->language)
            ->where('l11n/type/title', ['name1', 'name2', 'name3'], 'IN')
            ->where('files/types/name', 'item_profile_image')
            ->limit(50)
            ->execute();

        $view->data['items'] = $items;

        return $view;
    }

    /**
     * Routing end-point for application behaviour.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewItem(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);
        $view->setTemplate('/Modules/Labeling/Theme/Backend/layout-item');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1005701001, $request, $response);

        $item = ItemMapper::get()
            ->with('l11n')
            ->with('l11n/type')
            ->where('id', (int) $request->getData('id'))
            ->where('l11n/language', $response->header->l11n->language)
            ->where('l11n/type/title', ['name1', 'name2', 'name3'], 'IN')
            ->execute();

        $view->data['item'] = $item;

        /** @var \Modules\Labeling\Models\LabelLayout[] $layout */
        $layout = LabelLayoutMapper::get()
            ->with('l11n')
            ->with('template')
            ->with('template/sources')
            ->where('l11n/language', $response->header->l11n->language)
            ->where('id', (int) $request->getData('id'))
            ->execute();

        $view->data['layout'] = $layout;

        return $view;
    }
}
