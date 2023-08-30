<?php declare(strict_types=1);

$layout   = $this->data['layout'];
$template = \reset($layout->template->sources);

$item = $this->data['item'];

$label = include_once $template->getAbsolutePath();

if (isset($this->data['path'])) {
    \imagepng($label->render(), $this->data['path']);
} else {
    \imagepng($label->render());
}
