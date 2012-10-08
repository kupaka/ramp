<?php
//grab latest zend 1 framework (TODO: find way to ensure the link is the most recent version)
//function from http://damonparker.org/blog/2005/09/29/download-a-remote-file-using-php/
$zend_url = 'http://packages.zendframework.com/releases/ZendFramework-1.12.0/ZendFramework-1.12.0.zip';
$zend_zip = fopen('zend.zip', 'a+b');
echo "Downloading Zend Framework at $zend_url \n";
fwrite($zend_zip, file_get_contents($zend_url));
fclose($zend_zip);
echo "Finished downloading Zend. Extracting.\n"
?>
