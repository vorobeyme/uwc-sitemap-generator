<?php

namespace UAWebChallenge\SitemapGenerator;

use UAWebChallenge\SitemapGenerator\Storage;

class Parser
{
	/** @var array $links */
	private $links = [];
    
    /** @var string $url */
    private $siteUrl;

    /** @var string $content */
    private $content;

    /** @var string $currentUrl */
    private $currentUrl;

    /** @var array $parsedLinks */
    private $parsedLinks = [];

    /** @var Storage $storage */
    private $storage;

	/**
	 * Constructor
	 */
	public function __construct($url)
	{        
        $this->storage = new Storage;
        $this->siteUrl = $url;
        $this->parse($url);
	}
    
    /**
     * Curl initialize
     *
     * @param int $timeout
     * @return bool
     */
    private function getContent($timeout = 300)
    {
    	$curl = curl_init();

    	$header = [
    		"Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5",
    		"Cache-Control: max-age=0",
    		"Connection: keep-alive",
    		"Keep-Alive: 300",
    		"Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7",
    		"Accept-Language: en-us,en;q=0.5",
    		"Pragma: ",
    	];

        curl_setopt($curl, CURLOPT_URL, $this->currentUrl);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);

        $this->content = curl_exec($curl);
        curl_close($curl);

        if (!$this->content) {            
            throw new \Exception('No content!');            
        }

        $links = $this->getLinks(3);
        foreach ($links as $link) {
            $this->parse($link);
        }

        return $this->content;
    }

	/**
	 *
	 * @param int $level Links level to parse
	 */
	public function getLinks($level)
    {
        $dom = new \domDocument;
        @$dom->loadHTML($this->content);
        $links = $dom->getElementsByTagName('a');

        if (!(substr($this->currentUrl, -1) == '/')) {
            if (is_dir($this->currentUrl)) {
                $this->currentUrl .= '/';
            } else if ($this->currentUrl != $this->siteUrl) {
                $this->currentUrl = str_replace(basename($this->currentUrl), '', $this->currentUrl);
            }
        }

        foreach ($links as $tag) {

            if (Validator::isValidLink($tag->getAttribute('href'))) {

                if (strstr($tag->getAttribute('href'), $this->currentUrl)) {
                    $this->storage->addLink($tag->getAttribute('href'));
                } else if (substr($tag->getAttribute('href'), 0, 1) == '/') {
                    $this->storage->addLink($this->siteUrl . $tag->getAttribute('href'));
                } else if (!preg_match("/^(mailto|http|\#)/", $tag->getAttribute('href'))) {
                    if (substr($tag->getAttribute('href'), 0, 2) == './') {
                        $this->storage->addLink($this->currentUrl . substr($tag->getAttribute('href'), 2));
                    } else if (substr($tag->getAttribute('href'), 0, 3) == '../') {                    
                        $count = substr_count($tag->getAttribute('href'), '../');
                        $baseUrlTemp = $this->currentUrl;
                        for ($i = 1; $i <= $count + 1; $i++) {
                            $baseUrlTemp = substr($baseUrlTemp, 0, strrpos($baseUrlTemp, '/'));
                        }
                        $this->storage->addLink($baseUrlTemp . '/' . str_replace('../', '', $tag->getAttribute('href')));
                    } else {                
                        $this->storage->addLink($this->currentUrl . $tag->getAttribute('href'));
                    }
                }

            }
        }
        
        return $this->storage->getUnparsedLinks();
    }

    /**
     *
     *
     */
    public function parse($link)
    {
        if (!empty($link)) {                   
            $this->currentUrl = $link;
            $this->getContent();
        }
    }

    /**
     * Returns parsed links for sitemap generation
     *
     * @return array
     */
    public function getParsedLinks()
    {
        return $this->storage->getUnparsedLinks();
    }
}
