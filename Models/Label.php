<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Modules\Labeling\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\Labeling\Models;

class Label
{
    public int $width = 50;

    public int $height = 25;

    public int $fillColor = -1;

    public string $unit = 'cm';

    public array $elements = [];

    public function render()
    {
        $im = \imagecreatetruecolor((int) (37.8 * $this->width), (int) (37.8 * $this->height));
        $bg = \imagecolorallocatealpha($im, 255, 255, 255, 0);
        \imagefill($im, 0, 0, $bg);

        /*
        $black = \imagecolorallocate($im, 0, 0, 0);
        \imagecolortransparent($im, $black);
        \imagealphablending($im, false);
        \imagesavealpha($im, true);
        */

        foreach ($this->elements as $element) {
            $color = 0;

            if ($element instanceof Shape) {
                if ($element->type === 1) {
                    // Line
                    if ($element->borderThickness === 1) {
                        \imageline($im, $element->x, $element->y, $element->x2, $element->y2, $color);
                    } else {
                        \imagefilledrectangle(
                            $im,
                            $element->x, $element->y,
                            $element->x2 + $element->borderThickness - 1, $element->y2 + $element->borderThickness - 1,
                            $color
                        );
                    }
                } elseif ($element->type === 2) {
                    // Rectangle
                    \imagefilledrectangle(
                        $im,
                        $element->x, $element->y,
                        $element->x2 + $element->borderThickness, $element->y2 + $element->borderThickness,
                        $color
                    );

                    if ($element->fillColor === -1) {
                        \imagefilledrectangle(
                            $im,
                            $element->x + $element->borderThickness, $element->y + $element->borderThickness,
                            $element->x2, $element->y2,
                            $bg
                        );
                    }
                } elseif ($element->type === 3) {

                } elseif ($element->type === 4) {

                }
            } elseif ($element instanceof Text) {
                \imagettftext($im, $element->size, 0, $element->x, $element->y, $color, $element->font, $element->text);
            } elseif ($element instanceof Image) {
                $in = $element->resource === null ? \imagecreatefrompng(__DIR__ . '/../../..' . $element->src) : $element->resource;

                $srcW = \imagesx($in);
                $srcH = \imagesy($in);

                // should resize
                // @todo: impl. skewing
                if ($element->ratio !== 0.0 || $element->x2 !== 0 || $element->y2 !== 0) {
                    $ratio = $element->ratio;
                    if ($ratio === 0.0) {
                        $ratio = ($element->x2 - $element->x) / $srcW;
                    }

                    $newW = (int) ($srcW * $ratio);
                    $newH = (int) ($srcH * $ratio);

                    $newIn = \imagecreatetruecolor($newW, $newH);
                    \imagecolortransparent($newIn, \imagecolorallocatealpha($newIn, 0, 0, 0, 127));
                    \imagealphablending($newIn, false);
                    \imagesavealpha($newIn, true);

                    \imagecopyresampled(
                        $newIn, $in,
                        0, 0,
                        0, 0,
                        $newW, $newH,
                        $srcW, $srcH
                    );

                    $srcW = $newW;
                    $srcH = $newH;

                    \imagedestroy($in);

                    $in = $newIn;
                }


                $cut = \imagecreatetruecolor($srcW, $srcH);

                \imagecopy($cut, $im, 0, 0, $element->x, $element->y, $srcW, $srcH);
                \imagecopy($cut, $in, 0, 0, 0, 0, $srcW, $srcH);
                \imagecopymerge(
                    $im, $cut,
                    $element->x, $element->y,
                    0, 0,
                    $srcW, $srcH,
                    100
                );

                \imagedestroy($in);
                \imagedestroy($cut);
            } else {

            }
        }

        return $im;
    }
}