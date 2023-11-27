<?php
$target = '/home/menaplatforms/public_html/backend.menaplatforms.com/source-code/storage/app/public';
$shortcut = '/home/menaplatforms/public_html/backend.menaplatforms.com/storage';
echo symlink($target, $shortcut);
?>