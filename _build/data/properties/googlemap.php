<?php
/**
 * Google Maps TV
 *
 * Copyright 2010 by Shaun McCormick <shaun@collabpad.com>
 *
 * Google Maps TV is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * Google Maps TV is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Google Maps TV; if not, write to the Free Software Foundation, Inc., 59
 * Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package googlemapstv
 */
/**
 * Renders the properties form
 *
 * @package googlemapstv
 */
$modx->lexicon->load('googlemapstv:default');

/* fetch only the gmtv lexicon */
$lang = $modx->lexicon->fetch();
$glang = array();
foreach ($lang as $k => $v) {
    if (strpos($k,'gmtv') !== false) {
        $glang[str_replace('gmtv.','',$k)] = $v;
    }
}
$modx->smarty->assign('lang',$glang);

/* fix rc1 bug with settings */
$settings = array();
if (!empty($scriptProperties['tv'])) {
    $tv = $modx->getObject('modTemplateVar',$scriptProperties['tv']);
    if ($tv != null) {
        $params = $tv->get('display_params');
        $ps = explode('&',$params);
        foreach ($ps as $p) {
            $param = explode('=',$p);
            if ($p[0] != '') {
                $v = $param[1];
                if ($v == 'Yes') $v = 1;
                if ($v == 'No') $v = 0;
                $settings[$param[0]] = $v;
            }
        }
    }
    $modx->smarty->assign('tv',$scriptProperties['tv']);
}
$modx->smarty->assign('params',$settings);

return $modx->smarty->fetch('element/tv/renders/properties/googlemap.tpl');