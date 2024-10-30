<?php
/*
Plugin Name: MobiDevices Search URL
Plugin URI: https://1000.tech/en
Description: SEO-плагин для автоматического преобразования URL страниц поиска с формата <a href="http://mobidevices.ru/?s=iPhone">http://mobidevices.ru/?s=iPhone</a> на <a href="http://mobidevices.ru/search/iPhone">http://mobidevices.ru/search/iPhone</a>, разработанный порталом <a href="http://mobidevices.ru">MobiDevices</a>.
Version: 1.3
Author: 1000.tech
Author URI: https://1000.tech/en
Author Email: info@1000.tech
*/

function md_seo_redirect() {
    $post = get_post();
    $url = strtolower(get_permalink($post->ID));
    $urls = get_site_url().$_SERVER['REQUEST_URI'];

    if (is_single() || is_page()){
        if ($url != get_site_url().strtolower($_SERVER['REQUEST_URI'])){
            header('Location: '.$url.'',true,301);
            exit;
        }
    }
    elseif (is_search() && ! empty($_GET['s'])) {
        if (get_query_var('paged')) {
            header('Location: '.get_site_url().'/search/'.urlencode(get_query_var('s')).("/page/").get_query_var('paged'),true,301);
            exit();
        }
        else{
            header('Location: '.get_site_url().'/search/'.urlencode(get_query_var('s')),true,301);
            exit();
        }
    }
    elseif (is_search() || is_archive() ){
        if (preg_match('/\/page\/1$/', $urls)) {
            $url = get_site_url().str_replace('/page/1','',$_SERVER['REQUEST_URI']);
            header('Location: '.$url.'',true,301);
            exit;
        }
    }
}
add_action('template_redirect','md_seo_redirect');