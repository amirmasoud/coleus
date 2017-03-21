<?php
/**
 * Helper global functions.
 */

if (! function_exists('activeRoute')) {
    /**
     * Return active word to add to the class when we are on a route. used for
     * highlighting current menus.
     * @param  array $on
     * @return string
     */
    function activeRoute($on)
    {
        return str_contains(Request::url(), $on)
                ? 'active'
                : '';
    }
}
