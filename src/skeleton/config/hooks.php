<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$hook['pre_controller'][] = array(
        'class'    => 'Gettext',
        'function' => 'initialize',
        'filename' => 'Gettext.php',
        'filepath' => 'hooks/gettext',
);
