<?php

/**
 * Danish (Denmark) language pack
 * @package modules: slideshow
 * @subpackage i18n
 */

i18n::include_locale_file('modules: teasers', 'en_US');

global $lang;

if(array_key_exists('da_DK', $lang) && is_array($lang['da_DK'])) {
	$lang['da_DK'] = array_merge($lang['en_US'], $lang['da_DK']);
} else {
	$lang['da_DK'] = $lang['en_US'];
}
$lang['da_DK']['Teasers']['INHERIT_PARENT_TEASERS'] = 'Vis teasers fra modersektion';
$lang['da_DK']['Teasers']['TEASER_TITLE'] = 'Titel';
$lang['da_DK']['Teasers']['TEASER_CONTENT'] = 'Indhold';
$lang['da_DK']['Teasers']['THUMBNAIL'] = 'Billede';