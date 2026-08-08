<?php

if (! function_exists('admin_flash')) {
    function admin_flash(string $message, string $type = 'success')
    {
        if ($type === 'success') {
            $content = '<div style="font-family: primary-font, tahoma; font-weight:bold; font-size:1.3em; color:#10b981; margin-bottom:0.3em;">عملیات موفق</div>'.
                '<div style="font-family: primary-font, tahoma;">'.$message.'</div>';
        } elseif ($type === 'error') {
            $content = '<div style="font-family: primary-font, tahoma; font-weight:bold; color:red; font-size:1.3em; margin-bottom:0.3em;">عملیات ناموفق</div>'.
                '<div style="font-family: primary-font, tahoma;">'.$message.'</div>';
        } else {
            $content = '<div style="font-family: primary-font, tahoma;">'.$message.'</div>';
        }

        flash()
            ->option('position', 'bottom-left')
            ->option('timeout', 5000)
            ->option('rtl', true)
            ->option('html', true)
            ->$type($content);
    }
}
