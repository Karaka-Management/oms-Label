<?php

use Modules\Labeling\Models\Label;
use Modules\Labeling\Models\Text;
use Modules\Labeling\Models\Shape;
use Modules\Labeling\Models\Image;
use phpOMS\Utils\Barcode\Datamatrix;
use phpOMS\Utils\Barcode\QR;

$margin = 50;

$l = new Label();

// top
$text = new Text();
$text->text = $item->getL11n('name1')->content;
$text->size = 80;
$text->x = $margin;
$text->y = 80 + $margin;
$l->elements[] = $text;

// sub
$text = new Text();
$text->text = $item->getL11n('name2')->content;
$text->size = 50;
$text->x = $margin;
$text->y = 170 + $margin;
$l->elements[] = $text;

$line = new Shape();
$line->type = 1;
$line->borderThickness = 5;
$line->x = $margin;
$line->y = 200 + $margin;
$line->x2 = (int) ((37.8 * $l->width) - $margin);
$line->y2 = $line->y;
$l->elements[] = $line;

// facts
// REF
$image = new Image();
$image->src = '/Modules/Labeling/Theme/icons/iso/2493.png';
$image->x = $margin - 15;
$image->y = 250 + $margin - 50;
$image->x2 = $image->x + 150;
$image->y2 = 75 + $image->y;
$l->elements[] = $image;

$text = new Text();
$text->text = '0123-4567-8910';
$text->size = 40;
$text->x = 150 + $margin;
$text->y = 290 + $margin;
$l->elements[] = $text;

// LOT
$image = new Image();
$image->src = '/Modules/Labeling/Theme/icons/iso/2492.png';
$image->x = $margin - 15;
$image->y = 350 + $margin - 50;
$image->x2 = $image->x + 150;
$image->y2 = 75 + $image->y;
$l->elements[] = $image;

$text = new Text();
$text->text = '0123-4567-8910';
$text->size = 40;
$text->x = 150 + $margin;
$text->y = 390 + $margin;
$l->elements[] = $text;

// SN
$image = new Image();
$image->src = '/Modules/Labeling/Theme/icons/iso/2498.png';
$image->x = $margin - 15;
$image->y = 450 + $margin - 50;
$image->x2 = $image->x + 150;
$image->y2 = 75 + $image->y;
$l->elements[] = $image;

$text = new Text();
$text->text = '0123-4567-8910';
$text->size = 40;
$text->x = 150 + $margin;
$text->y = 490 + $margin;
$l->elements[] = $text;

// manufactured
$image = new Image();
$image->src = '/Modules/Labeling/Theme/icons/iso/2497.png';
$image->x = $margin - 15;
$image->y = 560 + $margin - 50;
$image->x2 = $image->x + 150;
$image->y2 = 75 + $image->y;
$l->elements[] = $image;

$text = new Text();
$text->text = 'YYYY-MM-DD';
$text->size = 40;
$text->x = 150 + $margin;
$text->y = 610 + $margin;
$l->elements[] = $text;

$text = new Text();
$text->text = 'DE';
$text->size = 20;
$text->x = $margin + 40;
$text->y = 625 + $margin;
$l->elements[] = $text;

// use by date
$image = new Image();
$image->src = '/Modules/Labeling/Theme/icons/iso/2607.png';
$image->x = $margin + 500;
$image->y = 540 + $margin;
$image->x2 = $image->x + 100;
$image->y2 = 75 + $image->y;
$l->elements[] = $image;

$text = new Text();
$text->text = 'YYYY-MM-DD';
$text->size = 40;
$text->x = 600 + $margin;
$text->y = 610 + $margin;
$l->elements[] = $text;

// QR
$qr = new Datamatrix('https://jingga.app', 200, 200);

$image = new Image();
$image->resource = $qr->get();
$image->x = 1000 + $margin;
$image->y = 280 + $margin - 50;
$image->x2 = $image->x + 200;
$image->y2 = 75 + $image->y;
$l->elements[] = $image;

$text = new Text();
$text->text = "(01)00000000000000\n(11)000000\n(17)000000\n(10)A000B0\n(21)0000";
$text->size = 40;
$text->x = 1230 + $margin;
$text->y = 280 + $margin;
$l->elements[] = $text;

// Footer

// line
$line = new Shape();
$line->type = 1;
$line->borderThickness = 5;
$line->x = $margin;
$line->y = 660 + $margin;
$line->x2 = (int) ((37.8 * $l->width) - $margin);
$line->y2 = $line->y;
$l->elements[] = $line;

// manufacturer
$image = new Image();
$image->src = '/Modules/Labeling/Theme/icons/iso/3082.png';
$image->x = $margin - 15;
$image->y = 660 + $margin;
$image->x2 = $image->x + 150;
$image->y2 = 75 + $image->y;
$l->elements[] = $image;

// address
$text = new Text();
$text->text = 'Jingga e. K.';
$text->size = 30;
$text->x = 150 + $margin;
$text->y = 710 + $margin;
$l->elements[] = $text;

$text = new Text();
$text->text = 'Kirchstr. 33';
$text->size = 30;
$text->x = 150 + $margin;
$text->y = 760 + $margin;
$l->elements[] = $text;

$text = new Text();
$text->text = '61191 Rosbach';
$text->size = 30;
$text->x = 150 + $margin;
$text->y = 810 + $margin;
$l->elements[] = $text;

$text = new Text();
$text->text = 'Germany';
$text->size = 30;
$text->x = 150 + $margin;
$text->y = 860 + $margin;
$l->elements[] = $text;

// contact
$text = new Text();
$text->text = 'www.jingga.app';
$text->size = 30;
$text->x = 600 + $margin;
$text->y = 710 + $margin;
$l->elements[] = $text;

$text = new Text();
$text->text = 'info@jingga.app';
$text->size = 30;
$text->x = 600 + $margin;
$text->y = 760 + $margin;
$l->elements[] = $text;

$text = new Text();
$text->text = '+49 0123 456789';
$text->size = 30;
$text->x = 600 + $margin;
$text->y = 810 + $margin;
$l->elements[] = $text;

// ce
$image = new Image();
$image->src = '/Modules/Labeling/Theme/icons/iso/ce_mark.png';
$image->x = 1400 + $margin;
$image->y = 680 + $margin;
$image->x2 = $image->x + 200;
$image->y2 = 200 + $image->y;
$l->elements[] = $image;

$text = new Text();
$text->text = '0123';
$text->size = 45;
$text->x = 1430 + $margin;
$text->y = 850 + $margin;
$l->elements[] = $text;

// qr
$qr = new QR('https://jingga.app', 200, 200);

$image = new Image();
$image->resource = $qr->get();
$image->x = 1620 + $margin;
$image->y = 680 + $margin;
$image->x2 = $image->x + 180;
$image->y2 = 180 + $image->y;
$l->elements[] = $image;

return $l;