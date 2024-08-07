<?php
/**
 * Plugin Name: Addingwell - Visitor UUID Cookie
 * Description: A simple plugin to create a visitor UUID server cookie named "_aw_master_id" with 13 months lifetime
 * Version: 1.0
 * Author: Addingwell
 * Author URI: https://www.addingwell.com/
 */

// Hook to initialize the UUID cookie when WordPress initializes

function set_aw_master_id() {
    $cookieName = '_aw_master_id';
    if (!isset($_COOKIE[$cookieName])) {
        $cookieValue = generateUUID();
    } else {
        $cookieValue = $_COOKIE[$cookieName];
    }

    $cookieLifetime = time() + (60 * 60 * 24 * 30 * 13);
    $domain = getMainDomain($_SERVER['SERVER_NAME']);
    setcookie($cookieName, $cookieValue, $cookieLifetime, '/', $domain, true, true);
}

function getMainDomain($url) {
    $composedTlds = [
        'co.uk', 'gov.uk', 'ac.uk', 'org.uk', 'net.uk', 'sch.uk', 'nhs.uk', 'police.uk',
        'com.au', 'net.au', 'org.au', 'edu.au', 'gov.au', 'asn.au', 'id.au',
        'co.jp', 'ac.jp', 'ne.jp', 'or.jp', 'go.jp', 'ed.jp', 'ad.jp', 'gr.jp',
        'com.cn', 'net.cn', 'gov.cn', 'org.cn', 'edu.cn', 'mil.cn', 'ac.cn',
        'com.br', 'net.br', 'org.br', 'gov.br', 'edu.br', 'mil.br', 'art.br', 'coop.br',
        'co.in', 'net.in', 'org.in', 'gov.in', 'ac.in', 'res.in', 'edu.in', 'mil.in', 'nic.in',
        'gc.ca', 'gov.ca',
        'com.de', 'net.de', 'org.de',
        'gov.it', 'edu.it',
        'asso.fr', 'nom.fr', 'prd.fr', 'presse.fr', 'tm.fr', 'com.fr', 'gouv.fr',
        'com.es', 'nom.es', 'org.es', 'gob.es', 'edu.es',
        'co.za', 'net.za', 'gov.za', 'org.za', 'edu.za',
        'com.mx', 'net.mx', 'org.mx', 'edu.mx', 'gob.mx',
        'com.ru', 'net.ru', 'org.ru', 'edu.ru', 'gov.ru',
        'co.kr', 'ne.kr', 'or.kr', 're.kr', 'pe.kr', 'go.kr', 'mil.kr',
        'com.sg', 'net.sg', 'org.sg', 'edu.sg', 'gov.sg', 'per.sg',
        'com.my', 'net.my', 'org.my', 'gov.my', 'edu.my', 'mil.my',
        'com.hk', 'net.hk', 'org.hk', 'gov.hk', 'edu.hk', 'idv.hk',
        'com.ar', 'net.ar', 'org.ar', 'gov.ar', 'edu.ar', 'int.ar',
        'com.tr', 'net.tr', 'org.tr', 'gov.tr', 'edu.tr', 'mil.tr',
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
function generateUUID()
{
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xFFFF), mt_rand(0, 0xFFFF),
        mt_rand(0, 0xFFFF),
        mt_rand(0, 0x0FFF) | 0x4000,
        mt_rand(0, 0x3FFF) | 0x8000,
        mt_rand(0, 0xFFFF), mt_rand(0, 0xFFFF), mt_rand(0, 0xFFFF)
    );
}

add_action('init', 'set_aw_master_id');
