<?php

namespace UAWebChallenge\SitemapGenerator;

use UAWebChallenge\SitemapGenerator\Parser;

/**
 * Sitemap generator
 * http://www.sitemaps.org/protocol.html
 */
class Generator
{
	const SCHEME = 'http://www.sitemaps.org/schemas/sitemap/0.9';
	const XML_FILE = 'sitemap.xml';

	/** @var string $siteUrl */
	private $siteUrl;

	public $loc;
	public $lastmod;
	public $changefreq;
	public $priority;

	/**
	 * Constructor
	 *
	 * @param string $url 
	 */
	public function __construct($url) 
	{
		$this->setSiteUrl($url);
	}

	/**
	 * Set site url
	 * 
	 * @param string $url 
	 */
	public function setSiteUrl($url) 
	{
		$url = $this->prepareUrl($url);
		$this->siteUrl = $url;
	}

	/**
     * Parses url
     *
     * @param  string $url Url to parse
     * @return string $url
     */
    public function prepareUrl($url)
    {
    	// TODO
    	return $url;
    }

	/**
	 * Generate a XML file
	 * 
	 */
	public function generateXmlFile() 
	{
		
	}
}