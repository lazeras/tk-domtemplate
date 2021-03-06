<?php
// Start the output buffer
ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>PHP Dom Template (PDT) Library</title>
  <link rel="stylesheet" type="text/css" href="stylesheet.css" />
</head>

<body>

  <div id="content">
    <h1 var="pageTitle">Default Text</h1>
    <h3 class="contentHeader" var="pageTitle">Default Text</h3>
    <div class="contentMain">
      <p var="content01"></p>
      <p var="content02"></p>
      <p>&#160;</p>
      <p choice="notShown">This text should stay hidden</p>
      <p>&#160;</p>
      <ul choice="list">
        <li repeat="listRow"><a href="#" var="listUrl">Default Link</a></li>
      </ul>
      <p>&#160;</p>
      <p>This is a static paragraph</p>
    </div>
  </div>



</body>
</html>
<?php
// include the Template lib
include_once dirname(dirname(dirname(__FILE__))) . '/lib/Dom/Template.php';

// Create a template from the html in the buffer
$buff = ob_get_clean();
$template = Dom_Template::load($buff);

// Set the pageTitle tag  --> <h1 var="pageTitle">Default Text</h1>
$template->insertText('pageTitle', 'Dynamic Page Title');

// Add some dynamic page content  --> <p var="content01"></p>
$content = sprintf('<b>Dynamic Text</b> Phasellus metus lorem, ornare non; aliquam convallis, luctus sed, sem.
Cras vel urna nec magna euismod sollicitudin. Morbi vehicula. Nunc consequat.
In hac habitasse platea dictumst.');
$template->appendText('content01', $content);
$template->appendHtml('content02', $content);

// Add some list data --> <ul choice="list">...
$listData = array('http://www.tropotek.com/' => 'Tropotek Home Page', 'http://www.phpdruid.com/' => 'PHPDruid Home Page', 'http://www.domtemplate.com' => 'Php Dom Template');
if (count($listData) > 0) {
    $template->setChoice('list');
}
foreach ($listData as $url => $value) {
    $repeat = $template->getRepeat('listRow');
    $repeat->insertText('listUrl', $value);
    $repeat->setAttr('listUrl', 'href', $url);
    $repeat->setAttr('listUrl', 'title', $value);
    $repeat->setAttr('listUrl', 'onclick', 'window.open(this.href);return false;');
    $repeat->append();
}


echo $template->toString();

?>