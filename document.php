<?php
// ParcSivom ©HPSdevs@gmail.com 
// Fichier de lecture de documents 
$url  = PARSE_URL($_SERVER['REQUEST_URI']);
$id  = (int) $url['query'];
if ($id) {
  require_once("./controllers/ctrl-document.php");
  $document = CallFilenameDoc($id) ?? null;
  if ($document) {
    $file = "Documents/" . $document['filename'];
    $mine   = mime_content_type($file);
    switch ($mine) {
      case 'application/pdf':
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . $file . '"');
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');
        @readfile($file);
        break;
      default:
        header("Content-type: " . $mine);
        readfile($file);
        break;
    }
  }
}
