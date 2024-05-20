<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\StockTaking
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use Modules\ItemManagement\Models\NullItem;

echo $this->data['nav']->render();

$layout = $this->data['layout'];

// Required by label
$item = new NullItem();
$unit = null;

$media    = $layout->template;
$template = \reset($media->sources);

$layout = include_once $template->getAbsolutePath();

\ob_start();
\imagepng($layout->render());
$imageData = \ob_get_clean();

$imageBase64 = \base64_encode($imageData);
// Get the image MIME type
$imageType = 'image/png'; // Assuming JPEG format in this example

// Generate the data URI for the inline image
$inlineImage = 'data:' . $imageType . ';base64,' . $imageBase64;
?>

<div class="portlet-body">
    <img height="100%" width="100%" src="Web/Backend/img/under_construction.svg">
</div>