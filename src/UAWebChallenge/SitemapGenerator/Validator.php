<?php

namespace UAWebChallenge\SitemapGenerator;

class Validator
{
	/** $var array $ignoredList */
	public static $ignoredExtentions = ['javascript:', '.css', '.js', '.map', '.ico', '.jpg', '.jpeg', '.png', '.gif', '.swf'];

	/**
	 * @param string $url 
	 * @return string
	 */
	public static function prepareSiteUrl($url)
	{
		if (!(substr($url, -1) == '/')) {
	        return $url . '/';
	    }

	    return $url;
	}

	/**
	 * Check if link is valid
	 *
	 * @param string $url
	 * @return bool
	 */
	public static function isValidLink($url)
	{
		$isValid = true;
        foreach (self::$ignoredExtentions as $extention) {
            if (stripos($url, $extention) !== false) {
                $isValid = false;
                break;
            }
        }
        
        return $isValid;
	}

}
