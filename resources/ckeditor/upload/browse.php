<?php

echo scanDirectoryImages("imgs");

/**
 * Recursively search through directory for images and display them
 * 
 * @param  array  $exts
 * @param  string $directory
 * @return string
 */
function scanDirectoryImages($directory, array $exts = array('jpeg', 'jpg', 'gif', 'png'))
{
    if (substr($directory, -1) == '/') {
        $directory = substr($directory, 0, -1);
    }
    $html = '';
    if (
        is_readable($directory)
        && (file_exists($directory) || is_dir($directory))
    ) {
        $directoryList = opendir($directory);
        while($file = readdir($directoryList)) {
            if ($file != '.' && $file != '..') {
                $path = $directory . '/' . $file;
                if (is_readable($path)) {
                    if (is_dir($path)) {
                        return scanDirectoryImages($path, $exts);
                    }
                    if (
                        is_file($path)
                        && in_array(end(explode('.', end(explode('/', $path)))), $exts)
                    ) {
                        $html .= '<a href="' . $path . '"><img src="' . $path
                            . '" style="max-height:100px;max-width:100px" onclick="closeWindow();" /></a>';
                    }
                }
            }
        }
        closedir($directoryList);
    }
    return $html;
}
?>