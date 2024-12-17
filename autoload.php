<?php
spl_autoload_register(function ($name_clase) {
  $file = __DIR__ . '/controllers/' . $name_clase . '.php';
  if (file_exists($file)) {
    require_once $file;
  }
});
