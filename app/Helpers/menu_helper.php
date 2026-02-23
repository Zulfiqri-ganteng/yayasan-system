<?php

/**
 * Menu active helper
 * - Support string / array
 * - Support index (int) atau path (string)
 * - PHP 8 safe
 */
function menu_active($segment, $index = 2): string
{
    $uri = service('uri');

    // Jika index berupa string → cek path langsung
    if (is_string($index)) {
        $currentPath = trim($uri->getPath(), '/');

        if (is_array($segment)) {
            foreach ($segment as $seg) {
                if (str_contains($currentPath, trim($seg, '/'))) {
                    return 'active';
                }
            }
            return '';
        }

        return str_contains($currentPath, trim($segment, '/')) ? 'active' : '';
    }

    // Jika index berupa integer → cek segment
    $segments = $uri->getSegments();
    $current  = $segments[$index - 1] ?? '';

    if (is_array($segment)) {
        return in_array($current, $segment, true) ? 'active' : '';
    }

    return $current === $segment ? 'active' : '';
}
