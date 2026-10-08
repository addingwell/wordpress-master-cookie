<?php
/**
 * Plugin Name: Addingwell - Visitor UUID Cookie
 * Description: A simple plugin to create a visitor UUID server cookie named "_aw_master_id" with 13 months lifetime
 * Version: 1.1
 * Author: Addingwell
 * Author URI: https://www.addingwell.com/
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

function dynamic_master_cookie_enqueue_script() {
    wp_enqueue_script('mastercookie-js', plugin_dir_url(__FILE__) . 'mastercookie.js', null, null, true);

    wp_localize_script('mastercookie-js', 'dynamic_cookie_data', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));
}
add_action('wp_enqueue_scripts', 'dynamic_master_cookie_enqueue_script');

// Handle AJAX request to set the cookie
function dynamic_master_cookie_ajax_handler() {
    $cookieName = '_aw_master_id';
    if (!isset($_COOKIE[$cookieName])) {
        $cookieLifetime = time() + (60 * 60 * 24 * 30 * 13);
        $domain = getMainDomain($_SERVER['SERVER_NAME']);
        $cookieValue = generateUUID();
        setcookie($cookieName, $cookieValue, $cookieLifetime, '/', $domain, true, true);
        wp_send_json_success('Cookie set successfully.');
    } else {
        wp_send_json_success('Cookie already exists.');
    }
    wp_die(); // Always die after handling AJAX
}
function getMainDomain($url) {
    $composedTlds = [
        'co.uk', 'gov.uk', 'ac.uk', 'org.uk', 'net.uk', 'sch.uk', 'nhs.uk', 'police.uk', 'ltd.uk', 'plc.uk', 'me.uk',
        'com.au', 'net.au', 'org.au', 'edu.au', 'gov.au', 'asn.au', 'id.au',
        'co.nz', 'net.nz', 'org.nz', 'ac.nz', 'govt.nz', 'school.nz', 'gen.nz', 'geek.nz', 'kiwi.nz', 'maori.nz',
        'co.jp', 'ac.jp', 'ne.jp', 'or.jp', 'go.jp', 'ed.jp', 'ad.jp', 'gr.jp',
        'com.cn', 'net.cn', 'gov.cn', 'org.cn', 'edu.cn', 'mil.cn', 'ac.cn',
        'com.tw', 'net.tw', 'org.tw', 'edu.tw', 'gov.tw', 'idv.tw',
        'com.br', 'net.br', 'org.br', 'gov.br', 'edu.br', 'mil.br', 'art.br', 'coop.br',
        'co.in', 'net.in', 'org.in', 'gov.in', 'ac.in', 'res.in', 'edu.in', 'mil.in', 'nic.in', 'firm.in', 'gen.in', 'ind.in',
        // Canada: federal + provincial/territorial suffixes
        'gc.ca', 'gov.ca',
        'ab.ca', 'bc.ca', 'mb.ca', 'nb.ca', 'nf.ca', 'nl.ca', 'ns.ca', 'nt.ca', 'nu.ca', 'on.ca', 'pe.ca', 'qc.ca', 'sk.ca', 'yk.ca',
        'com.de', 'net.de', 'org.de',
        'gov.it', 'edu.it',
        'asso.fr', 'nom.fr', 'prd.fr', 'presse.fr', 'tm.fr', 'com.fr', 'gouv.fr',
        'com.es', 'nom.es', 'org.es', 'gob.es', 'edu.es',
        'com.pt', 'org.pt', 'gov.pt', 'edu.pt',
        'co.at', 'or.at', 'gv.at', 'ac.at',
        'ac.be',
        'com.pl', 'net.pl', 'org.pl', 'gov.pl', 'edu.pl', 'info.pl', 'biz.pl',
        'com.gr', 'org.gr', 'net.gr', 'gov.gr', 'edu.gr',
        'com.ro', 'org.ro',
        'co.hu', 'org.hu',
        'com.cy', 'com.mt',
        'com.ua', 'net.ua', 'org.ua', 'gov.ua', 'edu.ua',
        'co.za', 'net.za', 'gov.za', 'org.za', 'edu.za',
        'com.mx', 'net.mx', 'org.mx', 'edu.mx', 'gob.mx',
        'com.co', 'net.co', 'org.co', 'edu.co', 'gov.co',
        'com.pe', 'net.pe', 'org.pe', 'edu.pe', 'gob.pe',
        'com.uy', 'net.uy', 'org.uy', 'edu.uy', 'gub.uy',
        'com.ve', 'com.ec', 'gob.cl', 'gov.cl',
        'com.ru', 'net.ru', 'org.ru', 'edu.ru', 'gov.ru',
        'co.kr', 'ne.kr', 'or.kr', 're.kr', 'pe.kr', 'go.kr', 'mil.kr',
        'com.sg', 'net.sg', 'org.sg', 'edu.sg', 'gov.sg', 'per.sg',
        'com.my', 'net.my', 'org.my', 'gov.my', 'edu.my', 'mil.my',
        'com.hk', 'net.hk', 'org.hk', 'gov.hk', 'edu.hk', 'idv.hk',
        'co.th', 'in.th', 'or.th', 'ac.th', 'go.th',
        'co.id', 'or.id', 'ac.id', 'go.id', 'web.id', 'my.id',
        'com.ph', 'net.ph', 'org.ph', 'gov.ph', 'edu.ph',
        'com.vn', 'net.vn', 'org.vn', 'gov.vn', 'edu.vn',
        'com.pk', 'net.pk', 'org.pk', 'gov.pk', 'edu.pk',
        'com.ar', 'net.ar', 'org.ar', 'gov.ar', 'edu.ar', 'int.ar',
        'com.tr', 'net.tr', 'org.tr', 'gov.tr', 'edu.tr', 'mil.tr',
        'co.il', 'org.il', 'net.il', 'ac.il', 'gov.il', 'muni.il',
        'co.ae', 'net.ae', 'org.ae', 'gov.ae', 'ac.ae',
        'com.sa', 'net.sa', 'org.sa', 'gov.sa', 'edu.sa',
        'com.eg', 'edu.eg', 'gov.eg',
        'co.ma', 'net.ma', 'org.ma', 'gov.ma', 'ac.ma',
        'com.tn', 'org.tn', 'gov.tn',
        'com.ng', 'org.ng', 'gov.ng', 'edu.ng',
        'co.ke', 'or.ke', 'go.ke', 'ac.ke',
    ];

    // Remove protocol if present
    $domain = preg_replace('/^https?:\/\//', '', $url);
    // Remove www. if present
    $domain = preg_replace('/^www\./', '', $domain);
    // Split the domain into parts
    $parts = explode('.', $domain);

    // Check against composed TLDs
    for ($i = 0; $i < count($parts) - 1; $i++) {
        $possibleTld = implode('.', array_slice($parts, $i));
        if (in_array($possibleTld, $composedTlds)) {
            $main_domain = implode('.', array_slice($parts, $i - 1));
            return $main_domain;
        }
    }

    // Default to last two parts if no composed TLD matches
    return implode('.', array_slice($parts, -2));
}
function generateUUID() {
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xFFFF), mt_rand(0, 0xFFFF),
        mt_rand(0, 0xFFFF),
        mt_rand(0, 0x0FFF) | 0x4000,
        mt_rand(0, 0x3FFF) | 0x8000,
        mt_rand(0, 0xFFFF), mt_rand(0, 0xFFFF), mt_rand(0, 0xFFFF)
    );
}

add_action('wp_ajax_set_dynamic_master_cookie', 'dynamic_master_cookie_ajax_handler');
add_action('wp_ajax_nopriv_set_dynamic_master_cookie', 'dynamic_master_cookie_ajax_handler');
