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

use phpOMS\Uri\UriFactory;

/** @var \phpOMS\Views\View $this */
/** @var \Modules\Labeling\Models\LabelLayout[] $layouts */
$layouts = $this->data['layouts'] ?? [];

echo $this->data['nav']->render(); ?>

<div class="row">
    <div class="col-xs-12">
        <section class="portlet">
            <div class="portlet-head"><?= $this->getHtml('Layouts'); ?><i class="g-icon download btn end-xs">download</i></div>
            <div class="slider">
            <table id="iLayoutList" class="default sticky">
                <thead>
                <tr>
                    <td>
                    <td><?= $this->getHtml('ID', '0', '0'); ?>
                        <label for="iLayoutList-sort-1">
                            <input type="radio" name="iLayoutList-sort" id="iLayoutList-sort-1">
                            <i class="sort-asc g-icon">expand_less</i>
                        </label>
                        <label for="iLayoutList-sort-2">
                            <input type="radio" name="iLayoutList-sort" id="iLayoutList-sort-2">
                            <i class="sort-desc g-icon">expand_more</i>
                        </label>
                        <label>
                            <i class="filter g-icon">filter_alt</i>
                        </label>
                    <td class="wf-100"><?= $this->getHtml('Name'); ?>
                        <label for="iLayoutList-sort-1">
                            <input type="radio" name="iLayoutList-sort" id="iLayoutList-sort-1">
                            <i class="sort-asc g-icon">expand_less</i>
                        </label>
                        <label for="iLayoutList-sort-2">
                            <input type="radio" name="iLayoutList-sort" id="iLayoutList-sort-2">
                            <i class="sort-desc g-icon">expand_more</i>
                        </label>
                        <label>
                            <i class="filter g-icon">filter_alt</i>
                        </label>
                <tbody>
                <?php $count = 0; foreach ($layouts as $key => $value) : ++$count;
                    $url     = UriFactory::build('{/base}/warehouse/labeling/layout?id=' . $value->id);
                ?>
                <tr data-href="<?= $url; ?>">
                    <td>
                    <td><a href="<?= $url; ?>"><?= $value->id; ?></a>
                    <td><a href="<?= $url; ?>"><?= $this->printHtml($value->l11n); ?></a>
                <?php endforeach; ?>
                <?php if ($count === 0) : ?>
                    <tr><td colspan="9" class="empty"><?= $this->getHtml('Empty', '0', '0'); ?>
                <?php endif; ?>
            </table>
            </div>
        </section>
    </div>
</div>
