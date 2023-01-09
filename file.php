<?php

$path = "storage";

if (isset($_GET['path'])) {
  $path = $_GET['path'];
}

$contents = scandir($path);

echo "<h1>Contents of $path</h1>\n";

if ($path !== "/") {
  $parent_path = dirname($path);
  echo "<p><a href='?path=$parent_path'>Up</a></p>\n";
}

foreach ($contents as $item) {
  if ($item !== "." && $item !== "..") {
    $item_path = "$path/$item";
    if (is_dir($item_path)) {
      echo "<p><a href='?path=$item_path'>$item/</a></p>\n";
    } else {
      echo "<p><a href='?path=$item_path'>$item</a></p>\n";
    }
  }
}