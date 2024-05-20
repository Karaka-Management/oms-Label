<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\ItemManagement
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use phpOMS\Uri\UriFactory;

/** @var \phpOMS\Views\View $this */
/** @var \Modules\ItemManagement\Models\Item[] $items */
$items = $this->data['items'] ?? [];

echo $this->data['nav']->render(); ?>

<div class="row">
    <div class="col-xs-12">
        <section class="portlet">
            <div class="portlet-head"><?= $this->getHtml('Items', 'ItemManagement', 'Backend'); ?><i class="g-icon download btn end-xs">download</i></div>
            <div class="slider">
            <table id="iItemList" class="default sticky">
                <thead>
                <tr>
                    <td>
                    <td><?= $this->getHtml('Number', 'ItemManagement', 'Backend'); ?>
                        <label for="iItemList-sort-1">
                            <input type="radio" name="iItemList-sort" id="iItemList-sort-1">
                            <i class="sort-asc g-icon">expand_less</i>
                        </label>
                        <label for="iItemList-sort-2">
                            <input type="radio" name="iItemList-sort" id="iItemList-sort-2">
                            <i class="sort-desc g-icon">expand_more</i>
                        </label>
                        <label>
                            <i class="filter g-icon">filter_alt</i>
                        </label>
                    <td><?= $this->getHtml('Name', 'ItemManagement', 'Backend'); ?>
                        <label for="iItemList-sort-3">
                            <input type="radio" name="iItemList-sort" id="iItemList-sort-3">
                            <i class="sort-asc g-icon">expand_less</i>
                        </label>
                        <label for="iItemList-sort-4">
                            <input type="radio" name="iItemList-sort" id="iItemList-sort-4">
                            <i class="sort-desc g-icon">expand_more</i>
                        </label>
                        <label>
                            <i class="filter g-icon">filter_alt</i>
                        </label>
                    <td class="wf-100"><?= $this->getHtml('Name', 'ItemManagement', 'Backend'); ?>
                        <label for="iItemList-sort-5">
                            <input type="radio" name="iItemList-sort" id="iItemList-sort-5">
                            <i class="sort-asc g-icon">expand_less</i>
                        </label>
                        <label for="iItemList-sort-6">
                            <input type="radio" name="iItemList-sort" id="iItemList-sort-6">
                            <i class="sort-desc g-icon">expand_more</i>
                        </label>
                        <label>
                            <i class="filter g-icon">filter_alt</i>
                        </label>
                <tbody>
                <?php $count = 0; foreach ($items as $key => $value) : ++$count;
                $url         = UriFactory::build('{/base}/warehouse/labeling/item?id=' . $value->id);
                $image       = $value->getFileByTagName('profile_image');
                ?>
                <tr data-href="<?= $url; ?>">
                    <td><a href="<?= $url; ?>"><img alt="<?= $this->getHtml('IMG_alt_item'); ?>" width="30" loading="lazy" class="item-image"
                            src="<?= $image->id === 0
                                ? 'Web/Backend/img/logo_grey.png'
                                : UriFactory::build($image->getPath()); ?>"></a>
                    <td><a href="<?= $url; ?>"><?= $this->printHtml($value->number); ?></a>
                    <td><a href="<?= $url; ?>"><?= $this->printHtml($value->getL11n('name1')->content); ?></a>
                    <td><a href="<?= $url; ?>"><?= $this->printHtml($value->getL11n('name2')->content); ?></a>
                <?php endforeach; ?>
                <?php if ($count === 0) : ?>
                    <tr><td colspan="9" class="empty"><?= $this->getHtml('Empty', '0', '0'); ?>
                <?php endif; ?>
            </table>
            </div>
        </section>
    </div>
</div>
