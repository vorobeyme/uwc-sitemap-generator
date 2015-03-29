<?php

namespace UAWebChallenge\SitemapGenerator;

/**
 * Class Storage
 */
class Storage
{
	/** @var array $parsedLinks */
	private $parsedLinks = [];

	/** @var array $unparsedLinks */
	private $unparsedLinks = [];

	/**
	 * Add link to unparsed links storage
	 * 
	 * @param string $link
	 */
	public function addLink($link) 
	{
		if (!isset($this->unparsedLinks[md5($link)])) {
			$this->unparsedLinks[md5($link)] = $link;
		}
	}

	/**
	 * Removing link from unparsedLinks array 
	 * and add this link to parsedLinks array
	 *
	 * @param string $link
	 */
	public function removeLink($link) 
	{
		if (isset($this->unparsedLinks[md5($link)])) {
			$this->parsedLinks[md5($link)] = $link;
		}

		unset($this->unparsedLinks[md5($link)]);
	}

	/**
	 * Returns parsed links
	 *
	 * @return array
	 */
	public function getParsedLinks() 
	{
		return $this->parsedLinks;
	}

	/**
	 * Returns unparsed links
	 *
	 * @return array
	 */
	public function getUnparsedLinks() 
	{
		return $this->unparsedLinks;
	}

}
