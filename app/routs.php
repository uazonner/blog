<?php
return array(
    '/'                  => ['Main::index'],
    'test/(\d+)'         => ['Test::show'],
    'test/(\d+)/edit'    => ['Test::edit']
);