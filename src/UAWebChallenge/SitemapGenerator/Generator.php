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
	const PARSE_LEVEL = 3;

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
     * Parse input site url
     *
     * @param Parser $parser
     * @param int $level
     * @return array $links
     */
    public function parseSite(Parser $parser, $level = self::PARSE_LEVEL)
    {
    	$parser->parseFromUrl($this->$siteUrl);
    	$links = $parser->getLinks($level);

    	return $links;
    }

	/**
	 * Generate a XML file
	 * 
	 */
	public function generateXmlFile() 
	{
		$links = $this->parseSite(new Parser());
		$this->saveXmlFile();
	}

	/**
	 * Save XML file on drive
	 *
	 * @param string $fileName
	 */
	private function saveXmlFile($fileName = self::XML_FILE)
	{

	}
}