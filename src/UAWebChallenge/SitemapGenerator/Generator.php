<?php

namespace UAWebChallenge\SitemapGenerator;

use UAWebChallenge\SitemapGenerator\Parser;
use UAWebChallenge\SitemapGenerator\Validator;

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

	/** @var Parser $parser */
	private $parser;	

	/**
	 * Constructor
	 *
	 * @param string $url 
	 */
	public function __construct($url) 
	{
		$this->setSiteUrl($url);
		$this->parser = new Parser($this->siteUrl);
	}

	/**
	 * Set site url
	 * 
	 * @param string $url 
	 */
	public function setSiteUrl($url) 
	{
		$this->siteUrl = $this->prepareUrl($url);
	}

	/**
	 * Get site url address
	 *
	 * @return string
	 */
	public function getSiteUrl()
	{
		return $this->siteUrl;
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
    	return Validator::prepareSiteUrl($url);
    }

    /**
     * Parse input site url
     *
     * @param Parser $parser
     * @param int $level
     * @return array $links
     */
    public function parseSite($level = self::PARSE_LEVEL)
    {    	
    	$links = $this->parser->getParsedLinks();
    	
    	return $links;
    }

	/**
	 * Generate a XML file
	 * 
	 */
	public function generateXmlFile() 
	{
		$links = $this->parseSite();
		$this->saveXmlFile();

		return $this->siteUrl;
	}

	/**
	 * Save XML file on drive
	 *
	 * @param string $fileName
	 */
	private function saveXmlFile($fileName = self::XML_FILE)
	{

	}

	/**
	 * Check if sitemap is generated
	 *
	 * @return bool
	 */
	public function isGenerated()
	{
		
	}

	/**
	 * Get link to download a generated sitemap
	 *
	 * @param bool $zip
	 * @return string
	 */
	public function getDownloadLink($zip = true)
	{
		
	}
}
