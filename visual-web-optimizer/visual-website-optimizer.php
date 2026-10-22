<?php
/**
 *
 * Plugin Name: Wingify
 * Plugin URI: https://wingify.com/
 * Description: Wingify (formerly VWO & AB Tasty) is the all-in-one platform that helps you conduct visitor research, build an optimization roadmap, and run continuous experimentation. Simply enable the plugin and start running tests on your WordPress website without doing any other code changes. Visit <a href="https://wingify.com/">Wingify</a> for more details.
 * Author: Wingify
 * Version: 4.17
 * visual-website-optimizer.php
 * Author URI: https://wingify.com/
 *
 * @package Wingify
 * @author Wingify
 * @version 4.17
 **/

/**
 * Generate Common Code
 *
 * @param integer $vwo_clicks integer. Defaults to 10.
 */
function get_vwo_clhf_script_common_code( $vwo_clicks = 10 ) {
    ob_start();
    // @codingStandardsIgnoreStart
    ?>
    <!-- Start Wingify Common Smartcode -->
    <script <?php echo vwo_clhf_ignore_js_attr(); ?> type='text/javascript'>
        var _vwo_clicks = <?php echo esc_html( $vwo_clicks ); ?>;
    </script>
    <!-- End Wingify Common Smartcode -->
    <?php
    // @codingStandardsIgnoreEnd
    $script_code = ob_get_clean();
    return $script_code;
}

/**
 * Get ignore js field setting
 *
 * @return bool boolean
 */
function get_vwo_clhf_ignore_js() {
    $ignore_js = get_option( 'ignore_js' );
    $ignore_js = ( '1' === $ignore_js ) ? true : false;
    return $ignore_js;
}

/**
 * Get ignore js script attribute value
 *
 * @return string Returns script attribute value
 */
function vwo_clhf_ignore_js_attr() {
    $ignore_js = get_vwo_clhf_ignore_js();
    $js_attr   = '';
    if ( function_exists( 'get_vwo_clhf_ignore_js' ) && $ignore_js ) {
        $js_attr = 'data-cfasync="false" nowprocket';
    }
    // Always exclude Wingify scripts from Jetpack Boost deferral
    if ( ! empty( $js_attr ) ) {
        $js_attr .= ' data-jetpack-boost="ignore"';
    } else {
        $js_attr = 'data-jetpack-boost="ignore"';
    }
    return $js_attr;
}

/**
 * Synchronous SmartCode 3.0.
 *
 * @param int $vwo_id Account ID.
 * @return string
 */
function vwo_clhf_script_sync_code_v3( $vwo_id = 0 ) {
    $base = vwo_clhf_smartcode_base_url();
    $src  = esc_url( $base . '/tag/' . $vwo_id . '.js' );
    ob_start();
    // @codingStandardsIgnoreStart
    ?>
    <?php if ( vwo_clhf_is_wingify_account() ) : ?>
        <!-- Start Wingify SmartCode -->
        <script src="<?php echo $src; ?>" <?php echo vwo_clhf_ignore_js_attr(); ?>></script>
        <!-- End Wingify SmartCode -->
    <?php else : ?>
        <!-- Start VWO Synchronous SmartCode 3.0-->
        <script src="<?php echo $src; ?>" <?php echo vwo_clhf_ignore_js_attr(); ?>></script>
        <!-- End VWO Synchronous SmartCode 3.0 -->
    <?php endif; ?>
    <?php
    // @codingStandardsIgnoreEnd
    return ob_get_clean();
}

/**
 * Asynchronous SmartCode 3.0.
 *
 * @param int $vwo_id Account ID.
 * @param int $settings_tolerance Settings timeout.
 * @return string
 */
function vwo_clhf_script_async_code_v3( $vwo_id, $settings_tolerance ) {
    $base = esc_url( vwo_clhf_smartcode_base_url() );
    ob_start();
    // @codingStandardsIgnoreStart
    ?>
    <?php if ( vwo_clhf_is_wingify_account() ) : ?>
        <!-- Start Wingify Async V3.0 SmartCode -->
        <link rel="preconnect" href="<?php echo $base; ?>"/>
        <script type="text/javascript" <?php echo vwo_clhf_ignore_js_attr(); ?>>
        window._wingify_code || (function() {
            var account_id = <?php echo esc_html( $vwo_id ); ?>,
                version = 3.0,
                settings_tolerance = <?php echo esc_html( $settings_tolerance ); ?>,
                hide_element = 'body',
                hide_element_style =
                'opacity:0 !important;filter:alpha(opacity=0) !important;background:none !important;transition:none !important';
            /* DO NOT EDIT BELOW THIS LINE */
            var n=window,i=document;if(-1<i.URL.indexOf('__wingify_disable__')||n._wingify_code)return;var t=!1,r=i.currentScript,e={sT:settings_tolerance,hES:hide_element_style,hE:hide_element};try{e=Object.assign(e,JSON.parse(localStorage.getItem('_wingify_'+account_id+'_config')))}catch(e){}var code={script:r,nonce:r.nonce,settings_tolerance:function(){return e.sT},hide_element:function(){return performance.getEntriesByName('first-contentful-paint')[0]?'':e.hE},hide_element_style:function(){return'{'+e.hES+'}'},getVersion:function(){return version},finish:function(){var e;!t&&(t=!0,e=i.getElementById('_vis_opt_path_hides'))&&e.parentNode.removeChild(e)},finished:function(){return t},addScript:function(e){var t=i.createElement('script');t.src=e,r.nonce&&t.setAttribute('nonce',r.nonce),t.fetchPriority='high',i.head.appendChild(t)},init:function(){n._settings_timer=setTimeout(function(){code.finish()},this.settings_tolerance());var e,t=this.hide_element();t&&((e=i.createElement('style')).id='_vis_opt_path_hides',r.nonce&&e.setAttribute('nonce',r.nonce),e.textContent=t+this.hide_element_style(),i.head.appendChild(e)),this.addScript('<?php echo $base; ?>/tag/'+account_id+'.js')}};n._wingify_code=code;code.init();})();
        </script>
        <!-- End Wingify Async SmartCode -->
    <?php else : ?>
        <!-- Start VWO Async V3.0 SmartCode -->
        <link rel="preconnect" href="<?php echo $base; ?>"/>
        <script type="text/javascript" id="vwoCode" <?php echo vwo_clhf_ignore_js_attr(); ?>>
        window._vwo_code || (function() {
            var account_id = <?php echo esc_html( $vwo_id ); ?>,
                version = 3.0,
                settings_tolerance = <?php echo esc_html( $settings_tolerance ); ?>,
                hide_element = 'body',
                hide_element_style =
                'opacity:0 !important;filter:alpha(opacity=0) !important;background:none !important;transition:none !important';
            /* DO NOT EDIT BELOW THIS LINE */
            var n=window,i=document;if(-1<i.URL.indexOf('__vwo_disable__')||n._vwo_code)return;var t=!1,r=i.currentScript,e={sT:settings_tolerance,hES:hide_element_style,hE:hide_element};try{e=Object.assign(e,JSON.parse(localStorage.getItem('_vwo_'+account_id+'_config')))}catch(e){}var code={script:r,nonce:r.nonce,settings_tolerance:function(){return e.sT},hide_element:function(){return performance.getEntriesByName('first-contentful-paint')[0]?'':e.hE},hide_element_style:function(){return'{'+e.hES+'}'},getVersion:function(){return version},finish:function(){var e;!t&&(t=!0,e=i.getElementById('_vis_opt_path_hides'))&&e.parentNode.removeChild(e)},finished:function(){return t},addScript:function(e){var t=i.createElement('script');t.src=e,r.nonce&&t.setAttribute('nonce',r.nonce),t.fetchPriority='high',i.head.appendChild(t)},init:function(){n._vwo_settings_timer=setTimeout(function(){code.finish()},this.settings_tolerance());var e,t=this.hide_element();t&&((e=i.createElement('style')).id='_vis_opt_path_hides',r.nonce&&e.setAttribute('nonce',r.nonce),e.textContent=t+this.hide_element_style(),i.head.appendChild(e)),this.addScript('<?php echo $base; ?>/tag/'+account_id+'.js')}};n._vwo_code=code;code.init();})();
        </script>
        <!-- End VWO Async SmartCode -->
    <?php endif; ?>
    <?php
    // @codingStandardsIgnoreEnd
    return ob_get_clean();
}

/**
 * Generate Synchronous Code
 *
 * @param int $vwo_id integer. Defaults to 0.
 * @return string string for sync script.
 */
function get_vwo_clhf_script_sync_code( $vwo_id = 0 ) {
    if ( vwo_clhf_is_smartcode_v3() ) {
        return vwo_clhf_script_sync_code_v3( $vwo_id );
    }
    ob_start();
    // @codingStandardsIgnoreStart
    ?>
    <?php if ( vwo_clhf_is_wingify_account() ) : ?>
        <!-- Start Wingify SmartCode -->
        <script src="https://edge.wingify.net/lib/<?php echo esc_html( $vwo_id ); ?>.js" referrerpolicy="no-referrer-when-downgrade" <?php echo vwo_clhf_ignore_js_attr(); ?>></script>
        <!-- End Wingify SmartCode -->
    <?php else : ?>
        <!-- Start Wingify Smartcode -->
        <script referrerPolicy="no-referrer-when-downgrade" <?php echo vwo_clhf_ignore_js_attr(); ?> src="https://dev.visualwebsiteoptimizer.com/lib/<?php echo esc_html( $vwo_id ); ?>.js"></script>
        <!-- End Wingify Smartcode -->
    <?php endif; ?>
    <?php
    // @codingStandardsIgnoreEnd
    $sync_script = ob_get_clean();
    return $sync_script;
}

/**
 * Generate Asynchronous Code
 *
 * @param int    $vwo_id integer.
 * @param int    $settings_tolerance integer.
 * @param int    $library_tolerance integer.
 * @param bool   $use_existing_jquery boolean.
 * @return string String for async script.
 */
function get_vwo_clhf_script_async_code( $vwo_id, $settings_tolerance, $library_tolerance, $use_existing_jquery ) {
    if ( vwo_clhf_is_smartcode_v3() ) {
        return vwo_clhf_script_async_code_v3( $vwo_id, $settings_tolerance );
    }
    ob_start();
    // @codingStandardsIgnoreStart
    ?>
    <?php if ( vwo_clhf_is_wingify_account() ) : ?>
        <!-- Start Wingify Async SmartCode -->
        <link rel="preconnect" href="https://edge.wingify.net"/>
        <script type='text/javascript' id="wingifyCode" <?php echo vwo_clhf_ignore_js_attr(); ?>>
        window._wingify_code ||
        (function () {
        var w=window,
        d=document;
        var account_id=<?php echo esc_html( $vwo_id ); ?>,
        version=2.2,
        settings_tolerance=<?php echo esc_html( $settings_tolerance ); ?>,
        hide_element='body',
        hide_element_style = 'opacity:0 !important;filter:alpha(opacity=0) !important;background:none !important';
        /* DO NOT EDIT BELOW THIS LINE */
        var f=0, v;
        if(f=!1,v=d.currentScript,cc={},-1<d.URL.indexOf('__wingify_disable__')||w._wingify_code)return;try{var e=JSON.parse(localStorage.getItem('_wingify_'+account_id+'_config'));cc=e&&'object'==typeof e?e:{}}catch(e){}function r(t){try{return decodeURIComponent(t)}catch(e){return t}}var s=function(){var e={combination:[],combinationChoose:[],split:[],exclude:[],uuid:null,consent:null,optOut:null},t=d.cookie||'';if(!t)return e;for(var n,i,o=/(?:^|;\s*)(?:(_vis_opt_exp_(\d+)_combi=([^;]*))|(_vis_opt_exp_(\d+)_combi_choose=([^;]*))|(_vis_opt_exp_(\d+)_split=([^:;]*))|(_vis_opt_exp_(\d+)_exclude=[^;]*)|(_vis_opt_out=([^;]*))|(_wingify_global_opt_out=[^;]*)|(_wingify_uuid=([^;]*))|(_wingify_consent=([^;]*)))/g;null!==(n=o.exec(t));)try{n[1]?e.combination.push({id:n[2],value:r(n[3])}):n[4]?e.combinationChoose.push({id:n[5],value:r(n[6])}):n[7]?e.split.push({id:n[8],value:r(n[9])}):n[10]?e.exclude.push({id:n[11]}):n[12]?e.optOut=r(n[13]):n[14]?e.optOut=!0:n[15]?e.uuid=r(n[16]):n[17]&&(i=r(n[18]),e.consent=i&&3<=i.length?i.substring(0,3):null)}catch(e){}return e}();function i(){var e=function(){if(w.Wingify&&Array.isArray(w.Wingify))for(var e=0;e<w.Wingify.length;e++){var t=w.Wingify[e];if(Array.isArray(t)&&('setVisitorId'===t[0]||'setSessionId'===t[0]))return!0}return!1}(),t='a='+account_id+'&u='+encodeURIComponent(w._vis_opt_url||d.URL)+'&vn='+version+'&ph=1'+('undefined'!=typeof platform?'&p='+platform:'')+'&st='+w.performance.now();e||((n=function(){var e,t=[],n={},i=w.Wingify&&w.Wingify.appliedCampaigns||{};for(e in i){var o=i[e]&&i[e].v;o&&(t.push(e+'-'+o+'-1'),n[e]=!0)}if(s&&s.combination)for(var r=0;r<s.combination.length;r++){var a=s.combination[r];n[a.id]||t.push(a.id+'-'+a.value)}return t.join('|')}())&&(t+='&c='+n),(n=function(){var e=[],t={};if(s&&s.combinationChoose)for(var n=0;n<s.combinationChoose.length;n++){var i=s.combinationChoose[n];e.push(i.id+'-'+i.value),t[i.id]=!0}if(s&&s.split)for(var o=0;o<s.split.length;o++)t[(i=s.split[o]).id]||e.push(i.id+'-'+i.value);return e.join('|')}())&&(t+='&cc='+n),(n=function(){var e={},t=[];if(w.Wingify&&Array.isArray(w.Wingify))for(var n=0;n<w.Wingify.length;n++){var i=w.Wingify[n];if(Array.isArray(i)&&'setVariation'===i[0]&&i[1]&&Array.isArray(i[1]))for(var o=0;o<i[1].length;o++){var r,a=i[1][o];a&&'object'==typeof a&&(r=a.e,a=a.v,r&&a&&(e[r]=a))}}for(r in e)t.push(r+'-'+e[r]);return t.join('|')}())&&(t+='&sv='+n)),s&&s.optOut&&(t+='&o='+s.optOut);var n=function(){var e=[],t={};if(s&&s.exclude)for(var n=0;n<s.exclude.length;n++){var i=s.exclude[n];t[i.id]||(e.push(i.id),t[i.id]=!0)}return e.join('|')}();return n&&(t+='&e='+n),s&&s.uuid&&(t+='&id='+s.uuid),s&&s.consent&&(t+='&consent='+s.consent),w.name&&-1<w.name.indexOf('_vis_preview')&&(t+='&pM=true'),w.Wingify&&w.Wingify.ed&&(t+='&ed='+w.Wingify.ed),t}code={script:v,nonce:v&&v.nonce,library_tolerance:function(){return'undefined'!=typeof library_tolerance?library_tolerance:void 0},settings_tolerance:function(){return cc.sT||settings_tolerance},hide_element_style:function(){return'{'+(cc.hES||hide_element_style)+'}'},hide_element:function(){return performance.getEntriesByName('first-contentful-paint')[0]?'':'string'==typeof cc.hE?cc.hE:hide_element},getVersion:function(){return version},finish:function(e){var t;f||(f=!0,(t=d.getElementById('_vis_opt_path_hides'))&&t.parentNode.removeChild(t),e&&((new Image).src='https://edge.wingify.net/ee.gif?a='+account_id+e))},finished:function(){return f},addScript:function(e){var t=d.createElement('script');t.type='text/javascript',e.src?t.src=e.src:t.text=e.text,v&&t.setAttribute('nonce',v.nonce),d.getElementsByTagName('head')[0].appendChild(t)},load:function(e,t){t=t||{};var n=new XMLHttpRequest;n.open('GET',e,!0),n.withCredentials=!t.dSC,n.responseType=t.responseType||'text',n.onload=function(){if(t.onloadCb)return t.onloadCb(n,e);200===n.status?_wingify_code.addScript({text:n.responseText}):_wingify_code.finish('&e=loading_failure:'+e)},n.onerror=function(){if(t.onerrorCb)return t.onerrorCb(e);_wingify_code.finish('&e=loading_failure:'+e)},n.send()},init:function(){var e,t=this.settings_tolerance();w._settings_timer=setTimeout(function(){_wingify_code.finish()},t),'body'!==this.hide_element()?(n=d.createElement('style'),e=(t=this.hide_element())?t+this.hide_element_style():'',t=d.getElementsByTagName('head')[0],n.setAttribute('id','_vis_opt_path_hides'),v&&n.setAttribute('nonce',v.nonce),n.setAttribute('type','text/css'),n.styleSheet?n.styleSheet.cssText=e:n.appendChild(d.createTextNode(e)),t.appendChild(n)):(n=d.getElementsByTagName('head')[0],(e=d.createElement('div')).style.cssText='z-index: 2147483647 !important;position: fixed !important;left: 0 !important;top: 0 !important;width: 100% !important;height: 100% !important;background: white !important;',e.setAttribute('id','_vis_opt_path_hides'),e.classList.add('_vis_hide_layer'),n.parentNode.insertBefore(e,n.nextSibling));var n='https://edge.wingify.net/j.php?'+i();-1!==w.location.search.indexOf('_wingify_xhr')?this.addScript({src:n}):this.load(n+'&x=true',{l:1})}};w._wingify_code=code;code.init();})();
        </script>
        <!-- End Wingify Async SmartCode -->
    <?php endif; ?>
    <?php if ( ! vwo_clhf_is_wingify_account() ) : ?>
        <!-- Start Wingify Async SmartCode -->
        <link rel="preconnect" href="https://dev.visualwebsiteoptimizer.com"/>
        <script type='text/javascript' id="vwoCode" <?php echo vwo_clhf_ignore_js_attr(); ?>>
        window._vwo_code ||
        (function () {
        var w=window,
        d=document;
        var account_id=<?php echo esc_html( $vwo_id ); ?>,
        version=2.2,
        settings_tolerance=<?php echo esc_html( $settings_tolerance ); ?>,
        hide_element='body',
        hide_element_style = 'opacity:0 !important;filter:alpha(opacity=0) !important;background:none !important';
        /* DO NOT EDIT BELOW THIS LINE */
        var f=0, v;
        if(f=!1,v=d.querySelector('#vwoCode'),cc={},-1<d.URL.indexOf('__vwo_disable__')||w._vwo_code)return;try{var e=JSON.parse(localStorage.getItem('_vwo_'+account_id+'_config'));cc=e&&'object'==typeof e?e:{}}catch(e){}function r(t){try{return decodeURIComponent(t)}catch(e){return t}}var s=function(){var e={combination:[],combinationChoose:[],split:[],exclude:[],uuid:null,consent:null,optOut:null},t=d.cookie||'';if(!t)return e;for(var n,i,o=/(?:^|;\s*)(?:(_vis_opt_exp_(\d+)_combi=([^;]*))|(_vis_opt_exp_(\d+)_combi_choose=([^;]*))|(_vis_opt_exp_(\d+)_split=([^:;]*))|(_vis_opt_exp_(\d+)_exclude=[^;]*)|(_vis_opt_out=([^;]*))|(_vwo_global_opt_out=[^;]*)|(_vwo_uuid=([^;]*))|(_vwo_consent=([^;]*)))/g;null!==(n=o.exec(t));)try{n[1]?e.combination.push({id:n[2],value:r(n[3])}):n[4]?e.combinationChoose.push({id:n[5],value:r(n[6])}):n[7]?e.split.push({id:n[8],value:r(n[9])}):n[10]?e.exclude.push({id:n[11]}):n[12]?e.optOut=r(n[13]):n[14]?e.optOut=!0:n[15]?e.uuid=r(n[16]):n[17]&&(i=r(n[18]),e.consent=i&&3<=i.length?i.substring(0,3):null)}catch(e){}return e}();function i(){var e=function(){if(w.VWO&&Array.isArray(w.VWO))for(var e=0;e<w.VWO.length;e++){var t=w.VWO[e];if(Array.isArray(t)&&('setVisitorId'===t[0]||'setSessionId'===t[0]))return!0}return!1}(),t='a='+account_id+'&u='+encodeURIComponent(w._vis_opt_url||d.URL)+'&vn='+version+'&ph=1'+('undefined'!=typeof platform?'&p='+platform:'')+'&st='+w.performance.now();e||((n=function(){var e,t=[],n={},i=w.VWO&&w.VWO.appliedCampaigns||{};for(e in i){var o=i[e]&&i[e].v;o&&(t.push(e+'-'+o+'-1'),n[e]=!0)}if(s&&s.combination)for(var r=0;r<s.combination.length;r++){var a=s.combination[r];n[a.id]||t.push(a.id+'-'+a.value)}return t.join('|')}())&&(t+='&c='+n),(n=function(){var e=[],t={};if(s&&s.combinationChoose)for(var n=0;n<s.combinationChoose.length;n++){var i=s.combinationChoose[n];e.push(i.id+'-'+i.value),t[i.id]=!0}if(s&&s.split)for(var o=0;o<s.split.length;o++)t[(i=s.split[o]).id]||e.push(i.id+'-'+i.value);return e.join('|')}())&&(t+='&cc='+n),(n=function(){var e={},t=[];if(w.VWO&&Array.isArray(w.VWO))for(var n=0;n<w.VWO.length;n++){var i=w.VWO[n];if(Array.isArray(i)&&'setVariation'===i[0]&&i[1]&&Array.isArray(i[1]))for(var o=0;o<i[1].length;o++){var r,a=i[1][o];a&&'object'==typeof a&&(r=a.e,a=a.v,r&&a&&(e[r]=a))}}for(r in e)t.push(r+'-'+e[r]);return t.join('|')}())&&(t+='&sv='+n)),s&&s.optOut&&(t+='&o='+s.optOut);var n=function(){var e=[],t={};if(s&&s.exclude)for(var n=0;n<s.exclude.length;n++){var i=s.exclude[n];t[i.id]||(e.push(i.id),t[i.id]=!0)}return e.join('|')}();return n&&(t+='&e='+n),s&&s.uuid&&(t+='&id='+s.uuid),s&&s.consent&&(t+='&consent='+s.consent),w.name&&-1<w.name.indexOf('_vis_preview')&&(t+='&pM=true'),w.VWO&&w.VWO.ed&&(t+='&ed='+w.VWO.ed),t}code={script:v,nonce:v&&v.nonce,library_tolerance:function(){return'undefined'!=typeof library_tolerance?library_tolerance:void 0},settings_tolerance:function(){return cc.sT||settings_tolerance},hide_element_style:function(){return'{'+(cc.hES||hide_element_style)+'}'},hide_element:function(){return performance.getEntriesByName('first-contentful-paint')[0]?'':'string'==typeof cc.hE?cc.hE:hide_element},getVersion:function(){return version},finish:function(e){var t;f||(f=!0,(t=d.getElementById('_vis_opt_path_hides'))&&t.parentNode.removeChild(t),e&&((new Image).src='https://dev.visualwebsiteoptimizer.com/ee.gif?a='+account_id+e))},finished:function(){return f},addScript:function(e){var t=d.createElement('script');t.type='text/javascript',e.src?t.src=e.src:t.text=e.text,v&&t.setAttribute('nonce',v.nonce),d.getElementsByTagName('head')[0].appendChild(t)},load:function(e,t){t=t||{};var n=new XMLHttpRequest;n.open('GET',e,!0),n.withCredentials=!t.dSC,n.responseType=t.responseType||'text',n.onload=function(){if(t.onloadCb)return t.onloadCb(n,e);200===n.status?_vwo_code.addScript({text:n.responseText}):_vwo_code.finish('&e=loading_failure:'+e)},n.onerror=function(){if(t.onerrorCb)return t.onerrorCb(e);_vwo_code.finish('&e=loading_failure:'+e)},n.send()},init:function(){var e,t=this.settings_tolerance();w._vwo_settings_timer=setTimeout(function(){_vwo_code.finish()},t),'body'!==this.hide_element()?(n=d.createElement('style'),e=(t=this.hide_element())?t+this.hide_element_style():'',t=d.getElementsByTagName('head')[0],n.setAttribute('id','_vis_opt_path_hides'),v&&n.setAttribute('nonce',v.nonce),n.setAttribute('type','text/css'),n.styleSheet?n.styleSheet.cssText=e:n.appendChild(d.createTextNode(e)),t.appendChild(n)):(n=d.getElementsByTagName('head')[0],(e=d.createElement('div')).style.cssText='z-index: 2147483647 !important;position: fixed !important;left: 0 !important;top: 0 !important;width: 100% !important;height: 100% !important;background: white !important;',e.setAttribute('id','_vis_opt_path_hides'),e.classList.add('_vis_hide_layer'),n.parentNode.insertBefore(e,n.nextSibling));var n='https://dev.visualwebsiteoptimizer.com/j.php?'+i();-1!==w.location.search.indexOf('_vwo_xhr')?this.addScript({src:n}):this.load(n+'&x=true',{l:1})}};w._vwo_code=code;code.init();})();
        </script>
        <!-- End Wingify Async SmartCode -->

    <?php endif; ?>
    <?php
    // @codingStandardsIgnoreEnd
    $async_script = ob_get_clean();
    return $async_script;
}

// ------------------------------------------------------------------------//
// ---Hook-----------------------------------------------------------------//
// ------------------------------------------------------------------------//
add_action( 'wp_head', 'vwo_clhf_headercode', 1 );
add_action( 'admin_menu', 'vwo_clhf_plugin_menu' );
add_action( 'admin_init', 'vwo_clhf_register_mysettings' );
add_action( 'admin_notices', 'vwo_clhf_warn_nosettings' );


// ------------------------------------------------------------------------//
// ---Functions------------------------------------------------------------//
// ------------------------------------------------------------------------//
// options page link

/**
 * Generate a function comment for the given function body.
 *
 * @throws Exception Description of exception.
 * @return void
 */
function vwo_clhf_plugin_menu() {
    add_options_page( 'Wingify', 'Wingify', 'create_users', 'clhf_vwo_options', 'vwo_clhf_plugin_options' );
}

/**
 * Register the settings for the Wingify options.
 *
 * @return void
 */
function vwo_clhf_register_mysettings() {
    register_setting('clhf_vwo_options', 'vwo_id', array(
        'sanitize_callback' => 'vwo_clhf_sanitize_settings',
    ));
    register_setting( 'clhf_vwo_options', 'code_type' );
    register_setting( 'clhf_vwo_options', 'vwo_clicks' );
    register_setting( 'clhf_vwo_options', 'ignore_js', 'boolval' );
    register_setting( 'clhf_vwo_options', 'settings_tolerance', 'intval' );
    register_setting( 'clhf_vwo_options', 'library_tolerance', 'intval' );
    register_setting( 'clhf_vwo_options', 'use_existing_jquery', 'boolval' );
    register_setting( 'clhf_vwo_options', 'enable_woocommerce_event_tracking', 'boolval');
    register_setting( 'clhf_vwo_options', 'track_product_view', 'boolval' );
    register_setting( 'clhf_vwo_options', 'track_add_to_cart', 'boolval' );
    register_setting( 'clhf_vwo_options', 'track_remove_from_cart', 'boolval' );
    register_setting( 'clhf_vwo_options', 'track_checkout', 'boolval' );
    register_setting( 'clhf_vwo_options', 'track_purchase', 'boolval' );
    register_setting( 'clhf_vwo_options', 'vwo_server_side_tracking', 'boolval' );
}

// ------------------------------------------------------------------------//
// ---Output Functions-----------------------------------------------------//
// ------------------------------------------------------------------------//


/**
 * Generates the action wingify_clhf_headercode function.
 *
 * @throws Exception Description of exception.
 * @return void
 */
function vwo_clhf_headercode() {
    // Runs in the header.
    $vwo_id    = get_option( 'vwo_id' );
    $code_type = get_option( 'code_type' );

    if ( $vwo_id ) {
        if ( null === get_option( 'is_wingify_account', null ) || false === get_option( 'vwo_dslv', false ) ) {
            vwo_clhf_fetch_and_save_account_info( $vwo_id );
        }

        if ( empty( get_option( 'vwo_clicks' ) ) ) {
            update_option( 'vwo_clicks', '10' );
        }
        $vwo_clicks = get_option( 'vwo_clicks' );

        // Common script code.
        // @codingStandardsIgnoreLine
        echo get_vwo_clhf_script_common_code( $vwo_clicks );

        if ( 'SYNC' === $code_type ) {
            // Sync script code.
            // @codingStandardsIgnoreLine
            echo get_vwo_clhf_script_sync_code( $vwo_id );
        } else {

            $settings_tolerance = get_option( 'settings_tolerance' );
            if ( ! is_numeric( $settings_tolerance ) ) {
                $settings_tolerance = 2000;
            }

            $library_tolerance = get_option( 'library_tolerance' );
            if ( ! is_numeric( $library_tolerance ) ) {
                $library_tolerance = 2500;
            }

            $use_existing_jquery = get_option( 'use_existing_jquery' );
            $use_existing_jquery = ( '1' === $use_existing_jquery ) ? true : false;

            // Async script code.
            // @codingStandardsIgnoreLine
            echo get_vwo_clhf_script_async_code( $vwo_id, $settings_tolerance, $library_tolerance, $use_existing_jquery );
        }
    }
}

// ------------------------------------------------------------------------//
// ---Page Output Functions------------------------------------------------//
// ------------------------------------------------------------------------//
// options page


/**
 * Generates the options page for the VWO plugin.
 *
 * @throws Exception Description of exception.
 * @return void
 */
function vwo_clhf_plugin_options() {

    ?>
    <div class="wrap">
        <h1 style="margin-bottom: 15px;display: flex; align-items: center; gap:6px;">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="158.594" height="50" viewBox="0 0 158.594 50" fill="none"><svg x="0.01" y="0" width="158.571" height="50" viewBox="0 0 86.719 27.344" preserveAspectRatio="xMidYMid meet" overflow="visible"><path fill-rule="evenodd" clip-rule="evenodd" d="M56.674 5.457h-5.383c-0.015 0 -0.032 0.013 -0.032 0.038 0 0.063 0.089 0.085 0.089 0.085 3.02 0.655 5.652 2.813 5.652 5.974 0 3.506 -2.717 6.393 -6.869 6.393 -0.906 0 -1.551 -0.131 -1.996 -0.259 -0.806 1.51 -0.914 1.794 -0.914 1.955 0 0.242 0.297 0.351 0.722 0.351h8.78l-2.289 4.832H45.979c-1.484 0 -2.617 -0.702 -2.617 -1.969 -0.025 -1.241 0.78 -2.266 3.322 -5.612 -2.24 -1.025 -3.623 -3.075 -3.623 -5.53s1.133 -5.098 6.039 -6.906l7.573 -2.805zm-8.623 1.328a0.07 0.07 0 0 0 -0.084 0.035c-0.125 0.238 -0.62 1.293 -0.59 2.954 0.106 5.73 4.184 6.423 4.603 6.479a0.063 0.063 0 0 0 0.059 -0.024c0.113 -0.148 0.594 -0.898 0.594 -2.977 0 -4.922 -4.059 -6.309 -4.582 -6.467" fill="#212326"/><path d="m73.68 3.131 -3.87 -0.984a0.078 0.078 0 0 0 -0.095 0.089l0.594 3.175h7.55l3.346 10.873 1.61 -10.873h3.397l-6.089 19.415h-5.531l4.756 -4.76h-2.018L73.162 7.992h-2.325v12.075H65.578V7.991h-1.56l1.56 -2.605C67.641 1.829 69.151 0.3 73.68 0z" fill="#212326"/><path d="M15.866 12.14a0.077 0.077 0 0 0 0.144 -0.02l1.402 -6.709h3.472l-6.266 15.031 -4.126 -7.69 -4.252 7.69L0 5.411h5.888l2.464 6.759c0.023 0.063 0.108 0.069 0.141 0.011l3.795 -6.795z" fill="#212326"/><path d="M26.622 20.066h-5.284V5.411h5.284z" fill="#212326"/><path d="M38.834 5.162c2.148 0.041 3.293 1.388 3.293 3.656v11.248H36.844V9.781c0 -1.102 -0.319 -1.754 -1.401 -1.754 -0.703 0 -1.52 0.558 -2.021 0.891v11.148h-5.284V5.411h5.284v1.679c1.963 -1.078 3.749 -1.93 5.309 -1.93z" fill="#212326"/><path d="M63.349 20.066h-5.284V5.411h5.284z" fill="#212326"/><path d="M26.622 3.532h-5.284V0.15h5.284z" fill="#212326"/><path d="M63.349 3.532h-5.284V0.15h5.284z" fill="#212326"/><path d="m8.859 24.231 -0.248 -0.081v-0.082h0.552v0.086l-0.166 0.066 -0.783 2.111c-0.067 0.177 -0.177 0.298 -0.351 0.298a0.206 0.206 0 0 1 -0.209 -0.205c0 -0.113 0.092 -0.202 0.202 -0.202 0.099 0 0.156 0.07 0.213 0.138l0.011 0.01 0.191 -0.506 -0.634 -1.658 -0.152 -0.053v-0.085h0.702v0.086l-0.177 0.063 0.432 1.18z" fill="#212326"/><path d="M6.367 25.799c-0.159 0 -0.307 -0.035 -0.399 -0.074l-0.131 -0.053V23.406l-0.22 -0.096v-0.042l0.552 -0.166v1.201c0.081 -0.092 0.277 -0.28 0.549 -0.28 0.326 0 0.652 0.23 0.652 0.794 0 0.527 -0.51 0.984 -1.002 0.984m-0.198 -0.294c0.011 0.014 0.138 0.148 0.365 0.148 0.255 0 0.5 -0.219 0.5 -0.726 0 -0.404 -0.241 -0.702 -0.507 -0.702a0.531 0.531 0 0 0 -0.358 0.152z" fill="#212326"/><path d="M34.082 24.97c0 -0.154 0.091 -0.245 0.284 -0.273l0.445 -0.063v0.12a0.44 0.44 0 0 1 -0.457 0.457c-0.18 0 -0.271 -0.086 -0.271 -0.24m-4.285 -1.094v-0.582h0.832c0.217 0 0.305 0.085 0.305 0.289 0 0.202 -0.091 0.297 -0.305 0.297zm0 1.16v-0.643h0.816q0.401 0 0.4 0.306c0 0.217 -0.139 0.334 -0.4 0.334zm-2.542 -0.693 0.362 -1.002h0.026l0.359 1.002zm11.081 1.21h0.463v-0.461h-0.277c-0.113 0 -0.155 -0.041 -0.155 -0.154v-0.851h0.68l0.599 1.506c0.056 0.141 -0.009 0.233 -0.167 0.233h-0.391v0.461h0.403c0.375 0 0.548 -0.117 0.665 -0.445l0.791 -2.211v-0.01h-0.573l-0.419 1.348h-0.025l-0.463 -1.348h-1.103v-0.608h-0.541v0.608h-0.319v0.463h0.322v0.952c0 0.378 0.138 0.517 0.51 0.517m-4.147 0.081c0.268 0 0.489 -0.109 0.621 -0.305h0.025c0.057 0.156 0.234 0.267 0.457 0.267a0.445 0.445 0 0 0 0.419 -0.242c0.198 0.157 0.48 0.245 0.807 0.245 0.586 0 0.961 -0.284 0.961 -0.722 0 -0.334 -0.22 -0.507 -0.75 -0.57l-0.249 -0.028c-0.189 -0.019 -0.245 -0.054 -0.245 -0.133 0 -0.109 0.104 -0.176 0.273 -0.176 0.184 0 0.347 0.085 0.432 0.227l0.485 -0.211c-0.154 -0.268 -0.504 -0.441 -0.92 -0.441 -0.498 0 -0.816 0.246 -0.816 0.63q0.001 0.496 0.716 0.589l0.261 0.038c0.186 0.025 0.268 0.072 0.268 0.166 0 0.117 -0.129 0.205 -0.369 0.205 -0.267 0 -0.463 -0.111 -0.541 -0.306l-0.242 0.155a0.469 0.469 0 0 1 -0.25 0.088c-0.132 -0.009 -0.182 -0.057 -0.182 -0.173v-0.693c0 -0.479 -0.262 -0.694 -0.848 -0.694 -0.533 0 -0.823 0.186 -0.905 0.573l0.552 0.098c0.031 -0.148 0.154 -0.23 0.347 -0.23 0.211 0 0.312 0.088 0.312 0.277v0.019l-0.617 0.091c-0.406 0.06 -0.649 0.299 -0.649 0.655 0 0.359 0.255 0.598 0.648 0.598m-1.698 -0.081h0.598v-2.259h0.933v-0.517h-2.383v0.517h0.852zm-3.29 0h1.563c0.545 0 0.863 -0.284 0.863 -0.763 0 -0.362 -0.186 -0.589 -0.535 -0.664v-0.026c0.305 -0.104 0.457 -0.313 0.457 -0.633 0 -0.451 -0.287 -0.691 -0.829 -0.691h-1.519zm-2.988 0h0.605l0.249 -0.694h1.118l0.249 0.694h0.633v-0.01l-1.068 -2.77h-0.721l-1.066 2.77zM26.177 21.875l-0.851 3.677h-3.447l0.82 0.349 -0.063 0.274h-1.856l0.461 0.211 -0.048 0.214h-0.936l0.344 -1.49h0.545l0.372 -1.585h1.034l0.378 -1.651z" fill="#212326"/><path d="M18.043 22.762c-0.059 0 -0.128 0 -0.186 0.012l-0.336 0.586c0.151 -0.092 0.336 -0.138 0.522 -0.138 0.603 0 1.102 0.494 1.102 1.091 0 0.598 -0.498 1.091 -1.102 1.091a1.102 1.102 0 0 1 -1.102 -1.08l-0.348 0.586a1.563 1.563 0 0 0 1.438 0.953c0.859 0 1.566 -0.701 1.566 -1.551 0.012 -0.849 -0.695 -1.55 -1.555 -1.55" fill="#212326"/><path d="m13.311 24.381 0.266 -0.459 0.603 1.022 0.695 -1.183 0.697 1.183 1.195 -2.009a0.344 0.344 0 0 1 0.302 -0.172h0.336l-1.832 3.1 -0.696 -1.183 -0.695 1.183z" fill="#212326"/><path d="m13.809 22.762 -1.832 3.101L10.156 22.762h0.336c0.127 0 0.244 0.069 0.302 0.172l1.183 2.022 1.195 -2.021a0.344 0.344 0 0 1 0.302 -0.172z" fill="#212326"/></svg></svg>
        <span>Configuration</span>
        </h1>

        <form method="post" action="options.php" novalidate>
            <?php
            settings_fields('clhf_vwo_options');
            ?>
            <div class="vwo-admin-content">
                <?php vwo_clhf_render_tabs(); ?>
                <div class="tab-content">
                    <div id="tab-general" class="tab-pane active">
                        <?php vwo_clhf_render_general_settings(); ?>
                    </div>
                    <div id="tab-advanced" class="tab-pane">
                        <?php vwo_clhf_render_advanced_settings(); ?>
                    </div>
                    <div id="tab-woocommerce" class="tab-pane">
                        <?php vwo_clhf_render_woocommerce_settings(); ?>
                    </div>
                </div>
            </div>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
    vwo_clhf_render_styles();
    vwo_clhf_render_scripts();
}

function vwo_clhf_render_tabs() {
    ?>
    <h2 class="nav-tab-wrapper">
        <a href="#tab-general" class="nav-tab nav-tab-active">General Settings</a>
        <a href="#tab-advanced" class="nav-tab">Advanced Settings</a>
        <a href="#tab-woocommerce" class="nav-tab">WooCommerce</a>
    </h2>
    <?php
}

function vwo_clhf_render_general_settings() {
    ?>
    <main class="main-grid">
        <div class="form-container">
            <?php
            vwo_clhf_render_field([
                'id' => 'vwo_id',
                'label' => 'Your Wingify Account ID',
                'type' => 'text',
                'tooltip' => 'Enter your Wingify Account ID here',
            ]);
            vwo_clhf_render_field([
                'id' => 'code_type',
                'label' => 'Code Type',
                'type' => 'radio',
                'options' => [
                    [
                        'label' => 'Asynchronous',
                        'value' => 'ASYNC',
                        'sublabel' => 'Loads faster without blocking other elements',
                    ],
                    [
                        'label' => 'Synchronous',
                        'value' => 'SYNC',
                        'sublabel' => 'Executes immediately but may slow down page load',
                    ],
                ],
            ]);
            ?>
        </div>
        <div class="main-grid__description" style="width:350px;">
        <div style="font-size: 18px; font-weight: 700; color: #000000; margin-bottom: 8px;">New to Wingify?</div>
            <div style="font-size: 14px; color: #757575; font-weight: 400; line-height: 20px; margin-bottom: 20px;">Create a free account to start optimising your website, no credit card required.</div>
            <div>
            <a  target="_blank" href="https://wingify.com/free-trial/?utm_source=integration_wordpress&utm_medium=referral&utm_campaign=plugin_page&utm_content=config_screen_banner" style="text-decoration: none; display: block; width: 162px; background: #fff; color: #2271B1; border: 1px solid #2271B1; padding: 10px 12px; font-size: 14px; font-weight: 600; cursor: pointer; text-align: center; border-radius: 8px;">
             Get Started for Free</a>
            <div>
            <div style="margin-bottom: 28px; margin-top: 20px;">
                <div style="font-weight: 600; color: #363A42; font-size: 14px; margin-bottom: 8px;">Wingify Dashboard?</div>
                <div style="font-size: 14px; color: #757575; font-weight: 400;">Visit our knowledge base to learn how to use the Wingify dashboard.</div>
                 <a href="https://app.wingify.com" target="_blank" style="display: inline-flex; align-items: center; color: #2271B1; border-radius: 8px; padding: 6px 12px; font-size: 12px; font-weight: 600; cursor: pointer; text-decoration: none; margin-top: 10px; border: 1px solid #2271B1;">
                    <span style="margin-right: 4px;">Go to Dashboard</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 32 32">
                        <path fill="#2271B1" d="M17.88 1v3.75h5.62l-9.38 9.38 3.76 3.74 9.37-9.37v5.63H31V1H17.87zm9.37 26.25H4.75V4.75h7.5V1H1v30h30V19.75h-3.75v7.5z"/>
                    </svg>
                </a>
            </div>
            <div style="font-size: 13px;">
                Need help? Visit our <a style="color: inherit;" href="https://help.wingify.com/hc/en-us/articles/59247859917465-Integrate-Wingify-with-WordPress">Knowledge Base</a> for guides and FAQs.
            </div>
        </div>
    </main>
    <?php
}

function vwo_clhf_render_advanced_settings() {
    ?>
    <div class="form-container">
        <?php
        vwo_clhf_render_field([
            'id' => 'vwo_clicks',
            'label' => 'No. of Heatmap Clicks',
            'type' => 'number',
            'tooltip' => 'Set the number of heatmap clicks to record',
            'min' => 3,
            'default' => 10,
        ]);
        vwo_clhf_render_field([
            'id' => 'settings_tolerance',
            'label' => 'Settings Timeout',
            'type' => 'number',
            'tooltip' => 'Set the timeout for settings in milliseconds',
            'default' => 2000,
            'class' => 'async-option',
            'suffix' => 'ms',
        ]);
        vwo_clhf_render_field([
            'id' => 'library_tolerance',
            'label' => 'Library Timeout',
            'type' => 'number',
            'tooltip' => 'Set the timeout for library in milliseconds',
            'default' => 2500,
            'class' => 'async-option',
            'suffix' => 'ms',
        ]);
        vwo_clhf_render_field([
            'id' => 'use_existing_jquery',
            'label' => 'Use Existing jQuery',
            'type' => 'checkbox',
            'tooltip' => 'Use the existing jQuery library on your site',
            'class' => 'async-option',
        ]);
        vwo_clhf_render_field([
            'id' => 'ignore_js',
            'label' => 'Skip Deferred Execution',
            'type' => 'checkbox',
            'tooltip' => 'Skip deferred execution of the Wingify script',
        ]);
        ?>
    </div>
    <?php
}

function vwo_clhf_render_woocommerce_settings() {
    $value = get_option('enable_woocommerce_event_tracking', false);
    $vwo_server_side_tracking = get_option('vwo_server_side_tracking', false);
    ?>
    <div>
        <div class="woocommerce-main-header">
            <div class="checkbox-container">
                <input type="checkbox" id="enable_woocommerce_event_tracking" name="enable_woocommerce_event_tracking" class="vwo-checkbox" <?php  echo checked($value, '1', false) ?>>
                <label class="vwo-checkbox-label" for="enable_woocommerce_event_tracking">Toggle</label>
                <label class="form-label form-label--checkbox" for="enable_woocommerce_event_tracking">Enable WooCommerce Event Tracking</label>
            </div>
            <p class="form-description form-description--checkbox">Event tracking will not work unless WooCommerce is enabled on your WordPress site.</p>
        </div>
        <div class="woocommerce-main-header">
            <div class="checkbox-container vwo_server_side_tracking">
                <input type="checkbox" id="vwo_server_side_tracking" name="vwo_server_side_tracking" class="vwo-checkbox" <?php  echo checked($vwo_server_side_tracking, '1', false) ?>>
                <label class="vwo-checkbox-label" for="vwo_server_side_tracking">Toggle</label>
                <label class="form-label form-label--checkbox" for="Enable Server-Side Tracking">Enable Server-Side Tracking</label>
            </div>
            <p class="form-description form-description--checkbox">Enable server-side tracking instead of JavaScript-based tracking.</p>
        </div>


        <div class="woocommerce-row woocommerce-row--disabled">
            <?php
            vwo_clhf_render_woocommerce_event_tracking([
                'id' => 'track_product_view',
                'label' => 'Product Viewed',
                'description' => 'This event logs an instance where a customer views a product details page.',
                'readmore_link' => 'https://help.wingify.com/hc/en-us/articles/59247859917465-Integrate-Wingify-with-WordPress'
            ]);
            vwo_clhf_render_woocommerce_event_tracking([
                'id' => 'track_add_to_cart',
                'label' => 'Add To Cart',
                'description' => 'This event logs an instance where a customer adds a product to their cart.',
                'readmore_link' => 'https://help.wingify.com/hc/en-us/articles/59247859917465-Integrate-Wingify-with-WordPress'
            ]);
            vwo_clhf_render_woocommerce_event_tracking([
                'id' => 'track_remove_from_cart',
                'label' => 'Product Removed From Cart',
                'description' => 'This event logs an instance where a customer removes a product from their cart.',
                'readmore_link' => 'https://help.wingify.com/hc/en-us/articles/59247859917465-Integrate-Wingify-with-WordPress'
            ]);
            vwo_clhf_render_woocommerce_event_tracking([
                'id' => 'track_purchase',
                'label' => 'Purchase Order',
                'description' => 'This event logs an instance where a customer completes a purchase.',
                'readmore_link' => 'https://help.wingify.com/hc/en-us/articles/59247859917465-Integrate-Wingify-with-WordPress'
            ]);
            ?>
        </div>
    </div>
    <?php
}

function vwo_clhf_render_woocommerce_event_tracking($field) {
    $value = get_option($field['id'], isset($field['default']) ? $field['default'] : '');
    ?>
    <div class="woocommerce-row-item">
        <div class="woocommerce-row-item-header">
            <h3 class="woocommerce-row-item-title"><?php echo esc_html($field['label']); ?></h3>
            <input type="checkbox" name="<?php echo esc_attr($field['id']); ?>" id="<?php echo esc_attr($field['id']); ?>" <?php  echo checked($value, '1', false) ?> class="vwo-checkbox">
            <label for="<?php echo esc_attr($field['id']); ?>" class="vwo-checkbox-label">Toggle</label>
        </div>
        <p class="woocommerce-row-item-description">
            <?php echo esc_html($field['description']); ?>
            <?php /* if (isset($field['readmore_link'])): ?>
                <a href="<?php echo esc_url($field['readmore_link']); ?>" target="_blank">Read more</a>
            <?php endif; */ ?>
        </p>
    </div>
    <?php
}


function vwo_clhf_render_field($field) {
    $isCheckbox = $field['type'] === 'checkbox';
    $value = get_option($field['id'], isset($field['default']) ? $field['default'] : '');

    echo '<div class="' . esc_attr(isset($field['class'])?$field['class']:"") . '">';

    $label = '<label class="form-label" for="' . esc_attr($field['id']) . '">' . esc_html($field['label']) . '</label>';

    switch ($field['type']) {
        case 'text':
        case 'number':
            echo $label;
            echo '<input type="' . esc_attr($field['type']) . '" id="' . esc_attr($field['id']) . '" name="' . esc_attr($field['id']) . '" value="' . esc_attr($value) . '"';
            if (isset($field['min'])) echo ' min="' . esc_attr($field['min']) . '"';
            echo ' class="form-input" />';
            if (isset($field['suffix'])) echo ' ' . esc_html($field['suffix']);
            break;
        case 'radio':
            echo $label;
            foreach ($field['options'] as $options) {
                echo '<div class="radio-container-wrapper">
                    <div class="radio-container">';
                echo '<label class="form-radio-label"><input type="radio" name="' . esc_attr($field['id']) . '" value="' . esc_attr($options['value']) . '"' . checked($value, $options['value'], false) . ' /> ' . esc_html($options['label']) . '</label> ';
                echo '</div>';
                echo '<p class="radio-sublabel">' . esc_html($options['sublabel']) . '</p>';
                echo '</div>';
            }
            break;
        case 'checkbox':
            echo '<div class="checkbox-container">';
            echo '<input type="checkbox" id="' . esc_attr($field['id']) . '" name="' . esc_attr($field['id']) . '" class="vwo-checkbox" value="1"' . checked($value, '1', false) . ' />';
            echo '<label class="vwo-checkbox-label" for="' . esc_attr($field['id']) . '">Toggle</label>';
            echo '<label class="form-label form-label--checkbox" for="' . esc_attr($field['id']) . '">' . esc_html($field['label']) . '</label>';
            echo '</div>';
            break;
    }

    if (isset($field['tooltip'])) {
        echo '<p class="form-description ' . ($isCheckbox ? 'form-description--checkbox' : '') . '">' . esc_html($field['tooltip']) . '</p>';
    }

    echo '</div>';
}

function vwo_clhf_render_styles() {
    ?>
    <style>
        input[type="radio"] {
            margin: 0 !important;
        }
        input[type=radio]:checked::before {
            background-color: #3858E9;
        }
        .vwo-admin-content {
            background: #fff;
            padding: 20px;
            border: 1px solid #ccd0d4;
            box-shadow: 0 1px 1px rgba(0,0,0,.04);
            margin-top: 20px;
        }
        .vwo-admin-content .nav-tab,
        .vwo-admin-content .nav-tab-active{
            outline:none;
            box-shadow: none;
        }
        .main-grid {
            display: flex;
            justify-content: space-between;
        }
        .main-grid__description {
            background-color: #f9f9f9;
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            font-family: 'Segoe UI', sans-serif;
            height: fit-content;max-width: 650px;
            border: 1px solid #E0E0E0;
            margin: 20px;
        }
        .main-grid__description h2 {
            font-weight: 600;
            margin-bottom: 10px;
            margin-top: 0;
            font-size: 20px;
            color: #333;
        }
        .main-grid__description p {
            font-size: 14px;
            color: #757575;
            line-height: 1.6;
            margin-top: 21px;
            margin-bottom: 0px;
        }
        .main-grid__description a {
            color: #3858E9;
        }
        .form-container {
            margin-top: 24px;
            margin-bottom: 30px;
            display: flex;
            flex-direction: column;
            gap: 28px;
            flex: 1;
        }
        .form-label {
            font-size: 12px;
            color: #1E1E1E;
            display: block;
            margin-bottom: 10px;
            font-weight: 500;
        }
        .form-label--checkbox {
            cursor: pointer;
            margin-bottom: 0;
        }
        .form-radio-label {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            cursor: pointer;
        }
        .form-radio-label:last-child {
            margin-bottom: 0;
        }
        .form-description {
            color: #757575;
            margin-top: 10px;
            margin-bottom: 0;
            font-size: 12px;
        }
        .form-description--checkbox {
            margin-top: 5px;
            margin-left: 42px;
        }
        .form-input {
            width: 100%;
            max-width: 400px;
            border: 1px solid #949494 !important;
            border-radius: 2px !important;
        }
        .checkbox-container, .radio-container {
            display: flex;
            gap: 10px;
        }
        .radio-container-wrapper {
            margin-bottom: 20px;
        }
        .radio-container-wrapper:last-child {
            margin-bottom: 0;
        }
        .radio-sublabel {
            font-size: 12px;
            color: #757575;
            margin-top: 5px;
            margin-bottom: 0;
            margin-left: 26px;
        }
        .checkbox-container .form-description {
            width: 100%;
        }
        .async-option {
            display: none;
        }
        .tab-pane {
            display: none;
        }
        .tab-pane.active {
            display: block;
        }
        .description {
            max-width: 800px;
            margin-bottom: 20px;
        }

        .woocommerce-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }
        .woocommerce-row-item {
            border: 1px solid rgba(0, 0, 0, 0.10);
            border-radius: 8px;
        }
        .woocommerce-row-item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 5px;
            padding: 10px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.10);
        }
        .woocommerce-row-item-title {
            margin: 0;
            font-size: 13px;
            font-weight: 500;
            color: #1E1E1E;
        }
        .woocommerce-row-item-description {
            margin: 0;
            font-size: 12px;
            color: #757575;
            padding: 10px;
        }
        .woocommerce-row-item-description a {
            color: #3858E9;
        }
        .woocommerce-main-header {
            margin: 30px 0;
        }
        .woocommerce-row--disabled {
            opacity: 0.4;
            cursor: not-allowed;
            pointer-events: none;
        }
        input[type=checkbox].vwo-checkbox{
            height: 0;
            width: 0;
            visibility: hidden;
            position: absolute;
            clip: rect(1px,1px,1px,1px);
            overflow: hidden;
        }

        label.vwo-checkbox-label {
            box-sizing: border-box;
            cursor: pointer;
            text-indent: -9999px;
            width: 32px;
            height: 18px;
            border: 1px solid #000;
            background: #fff;
            display: block;
            border-radius: 100px;
            position: relative;
        }

        label.vwo-checkbox-label:after {
            content: '';
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 2px;
            width: 12px;
            height: 12px;
            background: #000;
            border-radius: 90px;
            transition: 0.3s;
        }

        input.vwo-checkbox:checked + label.vwo-checkbox-label {
            background: #3858E9;
            border-color: #3858E9;
        }

        input.vwo-checkbox:checked + label.vwo-checkbox-label:after {
            left: calc(100% - 2px);
            transform: translateX(-100%) translateY(-50%);
            background-color: #fff;
        }

    </style>
    <?php
}

function vwo_clhf_render_scripts() {
    ?>
    <script>
        jQuery(document).ready(function($) {
            function toggleAsyncOptions() {
                var isAsync = $('input[name="code_type"]:checked').val() === 'ASYNC';
                $('.async-option').toggle(isAsync);
            }
            function toggleWooCommerceOptions() {
                var isWooCommerce = $('input[name="enable_woocommerce_event_tracking"]:checked');

                if(isWooCommerce.length > 0) {
                    $('.woocommerce-row').removeClass('woocommerce-row--disabled');
                     $('.vwo_server_side_tracking').removeClass('woocommerce-row--disabled');
                    
                } else {
                    $('.woocommerce-row').addClass('woocommerce-row--disabled');
                    $('.vwo_server_side_tracking').addClass('woocommerce-row--disabled');
                }
            }

            $('input[name="enable_woocommerce_event_tracking"]').change(toggleWooCommerceOptions);
            $("label[for='enable_woocommerce_event_tracking']").click(toggleWooCommerceOptions);
            toggleWooCommerceOptions(); // Run on page load

            $('input[name="code_type"]').change(toggleAsyncOptions);
            toggleAsyncOptions(); // Run on page load

            // Handle tab switching
            $('.nav-tab-wrapper .nav-tab').on('click', function(e) {
                e.preventDefault();
                var targetTab = $(this).attr('href');

                // Update active tab
                $('.nav-tab-wrapper .nav-tab').removeClass('nav-tab-active');
                $(this).addClass('nav-tab-active');

                // Show target tab content
                $('.tab-pane').removeClass('active').hide();
                $(targetTab).addClass('active').show();
            });

            // Ensure the first tab is visible on page load
            $('#tab-general').show();
        });
    </script>
    <?php
}

function vwo_clhf_enqueue_admin_scripts($hook) {
    if ('settings_page_clhf_vwo_options' !== $hook) {
        return;
    }
    wp_enqueue_style('wp-admin');
}
add_action('admin_enqueue_scripts', 'vwo_clhf_enqueue_admin_scripts');

/**
 * Displays a warning message if VWO settings are not configured.
 * This function checks if the user is an admin and if the VWO ID option is set. If the user is not an admin or
 * the VWO ID option is not set, it displays a warning message.
 *
 * @throws Exception Description of exception.
 * @return void
 */
function vwo_clhf_warn_nosettings() {
    if ( ! is_admin() ) {
        return;
    }

    $clhf_option = get_option( 'vwo_id' );
    if ( ! $clhf_option || $clhf_option < 1 ) {
        echo "<div id='vwo-warning' class='updated fade'><p><strong>Wingify is almost ready.</strong> You must <a href=\"options-general.php?page=clhf_vwo_options\">enter your Account ID</a> for it to work.</p></div>";
    }
}


add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'vwo_clhf_add_plugin_page_settings_link' );

/**
 * Function to add Settings Links on Plugin page
 *
 * @param array $links Array of links.
 * @return array
 */
function vwo_clhf_add_plugin_page_settings_link( $links ) {
    $links[] = '<a href="' .
        admin_url( 'options-general.php?page=clhf_vwo_options' ) .
        '">' . __( 'Settings' ) . '</a>';
    return $links;
}

/**
 * Disables VWO in Divi Builder.
 *
 * @throws Exception Description of exception.
 * @return void
 */
function disable_vwo_in_divi_builder() {
    if ( has_action( 'wp_head', 'vwo_clhf_headercode' ) && function_exists( 'et_core_is_fb_enabled' ) && et_core_is_fb_enabled() ) {
        remove_action( 'wp_head', 'vwo_clhf_headercode', 1 );
    }
}

add_action( 'wp_head', 'disable_vwo_in_divi_builder', 0 );

// Add this new function to validate settings
function vwo_clhf_validate_settings() {
    $has_errors = false;

    // Validate VWO Account ID
    $vwo_id = get_option('vwo_id');
    if (empty($vwo_id) || !is_numeric($vwo_id)) {
        add_settings_error('vwo_clhf_options', 'vwo_id', 'Please enter a valid Wingify Account ID.', 'error');
        $has_errors = true;
    }

    // Add more validation for other fields as needed

    return $has_errors;
}

/**
 * Whether the configured account is a Wingify account.
 *
 * @return bool
 */
function vwo_clhf_is_wingify_account() {
    return '1' === get_option( 'is_wingify_account' );
}

/**
 * Whether the account should use SmartCode 3.0.
 *
 * @return bool
 */
function vwo_clhf_is_smartcode_v3() {
    return 3 === (int) get_option( 'vwo_dslv', 0 );
}

/**
 * SmartCode host for the active account type.
 *
 * @return string
 */
function vwo_clhf_smartcode_base_url() {
    return vwo_clhf_is_wingify_account() ? 'https://edge.wingify.net' : 'https://dev.visualwebsiteoptimizer.com';
}

/**
 * Fetch account info from VWO API and save collUrl and is_wingify_account options.
 *
 * @param int|string $vwo_id VWO Account ID.
 * @return string Collection URL if available, empty string otherwise.
 */
function vwo_clhf_fetch_and_save_account_info( $vwo_id ) {
    $coll_url = '';

    if ( empty( $vwo_id ) || ! is_numeric( $vwo_id ) ) {
        return $coll_url;
    }

    $api_url  = 'https://edge.wingify.net/accInfo?a=' . $vwo_id;
    $response = wp_remote_get(
        $api_url,
        array(
            'timeout'   => 15,
            'sslverify' => false,
            'headers'   => array(
                'Accept-Encoding' => 'gzip, deflate, br',
                'User-Agent'      => 'vwo-woocommerce-plugin',
            ),
        )
    );

    if ( is_wp_error( $response ) ) {
        return $coll_url;
    }

    $body = wp_remote_retrieve_body( $response );
    if ( empty( $body ) ) {
        return $coll_url;
    }

    $data = json_decode( $body, true );
  
    if ( ! is_array( $data ) ) {
        return $coll_url;
    }

    if ( ! empty( $data['collUrl'] ) ) {
        $coll_url = $data['collUrl'];
        update_option( 'vwo_coll_url', sanitize_text_field( $data['collUrl'] ) );
    }

    if ( isset( $data['wd'] ) && $data['wd'] ) {
        update_option( 'is_wingify_account', '1' );
    } else {
        update_option( 'is_wingify_account', '' );
    }

    $dslv = ( isset( $data['dslv'] ) && is_numeric( $data['dslv'] ) ) ? (int) $data['dslv'] : 0;
    update_option( 'vwo_dslv', (string) $dslv );

    return $coll_url;
}

// Add this new function to sanitize and validate settings
function vwo_clhf_sanitize_settings($input) {
    // Sanitize and validate VWO Account ID
    $vwo_id = sanitize_text_field($input);
    if (empty($vwo_id) || !is_numeric($vwo_id)) {
        add_settings_error('vwo_clhf_options', 'vwo_id', 'Please enter a valid Wingify Account ID.', 'error');
    }

    // Add more sanitization and validation for other fields as needed
    // Check if vwo_id is changed
    $current_vwo_id = get_option('vwo_id');
    if ($current_vwo_id !== $vwo_id) {
        update_option( 'vwo_coll_url', '' );
        delete_option( 'is_wingify_account' );
        delete_option( 'vwo_dslv' );
    }
    if ( ! empty( $vwo_id ) && is_numeric( $vwo_id ) && ( $current_vwo_id !== $vwo_id || false === get_option( 'vwo_dslv', false ) ) ) {
        vwo_clhf_fetch_and_save_account_info( $vwo_id );
    }
    return $vwo_id;
}

function enqueue_jquery_script() {
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'enqueue_jquery_script');

if (file_exists(plugin_dir_path(__FILE__) . 'woocommerce-events.php')) {
    include_once plugin_dir_path(__FILE__) . 'woocommerce-events.php';
}


?>