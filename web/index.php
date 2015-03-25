<?php

require_once '../vendor/autoload.php';

$sitemap = new SitemapGenerator($url);
$sitemap->generate();