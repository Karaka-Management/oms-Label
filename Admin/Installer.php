<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Modules\Labeling\Admin
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\Labeling\Admin;

use phpOMS\Application\ApplicationAbstract;
use phpOMS\Config\SettingsInterface;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\Http\HttpResponse;
use phpOMS\Module\InstallerAbstract;
use phpOMS\Module\ModuleInfo;
use phpOMS\Uri\HttpUri;

/**
 * Installer class.
 *
 * @package Modules\Labeling\Admin
 * @license OMS License 2.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
final class Installer extends InstallerAbstract
{
    /**
     * Path of the file
     *
     * @var string
     * @since 1.0.0
     */
    public const PATH = __DIR__;

    /**
     * {@inheritdoc}
     */
    public static function install(ApplicationAbstract $app, ModuleInfo $info, SettingsInterface $cfgHandler) : void
    {
        parent::install($app, $info, $cfgHandler);

        /* Label layouts */
        $fileContent = \file_get_contents(__DIR__ . '/Install/layouts.json');
        if ($fileContent === false) {
            return;
        }

        /** @var array $layouts */
        $layouts = \json_decode($fileContent, true);
        if ($layouts === false) {
            return;
        }

        self::createLabelLayouts($app, $layouts);
    }

    /**
     * Install default bill types
     *
     * @param ApplicationAbstract $app     Application
     * @param array               $layouts Default layouts
     *
     * @return array
     *
     * @since 1.0.0
     */
    private static function createLabelLayouts(ApplicationAbstract $app, array $layouts) : array
    {
        $layoutModels = [];

        /** @var \Modules\Labeling\Controller\ApiController $module */
        $module = $app->moduleManager->getModuleInstance('Labeling');

        $tempPath = __DIR__ . '/../../../temp/';

        foreach ($layouts as $layout) {
            $response = new HttpResponse();
            $request  = new HttpRequest(new HttpUri(''));

            $request->header->account = 1;
            $request->setData('title', \reset($layout['l11n']));
            $request->setData('template', $layout);

            foreach ($layout['files'] as $file) {
                $filePath = __DIR__ . '/../../..' . $file;

                \copy($filePath, $tempPath . \basename($file));

                $request->addFile([
                    'size'     => \filesize($tempPath . \basename($file)),
                    'name'     => \basename($file),
                    'tmp_name' => $tempPath . \basename($file),
                    'error'    => \UPLOAD_ERR_OK,
                ]);
            }

            $module->apiLabelLayoutCreate($request, $response);

            $responseData = $response->get('');
            if (!\is_array($responseData)) {
                continue;
            }

            $layoutModel = \is_array($responseData['response'])
                ? $responseData['response']
                : $responseData['response']->toArray();

            $layoutModels[] = $layoutModel;

            $isFirst = true;
            foreach ($layout['l11n'] as $language => $l11n) {
                if ($isFirst) {
                    $isFirst = false;
                    continue;
                }

                $response = new HttpResponse();
                $request  = new HttpRequest(new HttpUri(''));

                $request->header->account = 1;
                $request->setData('title', $l11n);
                $request->setData('language', $language);
                $request->setData('type', $layoutModel['id']);

                $module->apiLabelLayoutL11nCreate($request, $response);
            }
        }

        return $layoutModels;
    }
}
