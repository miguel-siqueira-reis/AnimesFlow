<?php

if ($_SERVER['SERVER_NAME'] !== 'localhost') return;

use MatthiasMullie\Minify;

/*
 * functions rrmdir and generete
 */

function rrmdir($src) {
  $dir = opendir($src);
  while(false !== ( $file = readdir($dir)) ) {
    if (( $file != '.' ) && ( $file != '..' )) {
      $full = $src . '/' . $file;
      if ( is_dir($full) ) {
        rrmdir($full);
      }
      else {
        unlink($full);
      }
    }
  }
  closedir($dir);
  rmdir($src);
}

function generete($pathRsources, $pathPublic, $scandir, $minify) {
  foreach ($scandir as $dir) {
    if (is_dir($pathRsources . $dir) && ($dir !== '.' && $dir !== '..')) {
      $oldDir = $pathRsources . $dir . '/';
      $newDir = $pathPublic . $dir . '/';
      mkdir($newDir);
      $newScandir = scandir($oldDir);
      generete($oldDir, $newDir, $newScandir, $minify);
    }
    $oldFile = $pathRsources.$dir;
    if (is_file($oldFile) && (pathinfo($oldFile)["extension"] == 'js' or pathinfo($oldFile)["extension"] == 'css')) {
      $minify->add($oldFile);
      $minify->minify($pathPublic.$dir);
    }
  }
}

/*
 * css generete minify
*/


$pathFolderResourcesCss = dirname(__DIR__, 1).'/resources/assets/css/';
$pathFolderPublicCss =  dirname(__DIR__, 1).'/public/assets/css/';

rrmdir($pathFolderPublicCss);
mkdir($pathFolderPublicCss);

$cssDir = scandir($pathFolderResourcesCss);

generete($pathFolderResourcesCss, $pathFolderPublicCss, $cssDir, new Minify\CSS());

/*
 * js generete minify
*/

$pathFolderResourcesJs = dirname(__DIR__, 1).'/resources/assets/js/';
$pathFolderPublicJs =  dirname(__DIR__, 1).'/public/assets/js/';

rrmdir($pathFolderPublicJs);
mkdir($pathFolderPublicJs);

$cssDir = scandir($pathFolderResourcesJs);

generete($pathFolderResourcesCss, $pathFolderPublicCss, $cssDir, new Minify\Js());