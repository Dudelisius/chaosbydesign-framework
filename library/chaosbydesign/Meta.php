<?php

/*
 * Meta
 *
 * Meta head functions
 *
 * @category	Chaosbydesign Framework
 * @package		Chaosbydesign Framework
 * @author		Rick de Graaf
 * @copyright	Copyright (c) 2016 Rick de GRaaf
 * @version		1.0
*/

class Meta extends View
{
	// Variables
	public $_variables;
	public $_title;
	public $_desription;
	public $_author;
	
	// Construct
	public function __construct($_variables)
	{
		$this->_variables = $_variables;
	}
	
	// Encoding
	public function Encoding()
	{
		return $this->_variables['encoding'];	
	}
	
	// Create title tag
	public function Title($title = null, $seperator = null)
	{
		// Check Which elements are there and create proper title
		if(!empty($this->_variables['title']) && !empty($seperator) && !empty($title))
		{
			$this->_title = $title.' '.$seperator.' '.$this->_variables['title'];
		}
		elseif(!empty($this->_variables['title']) && !empty($title))
		{
			$this->_title = $title.' '.$this->_variables['title'];
		}
		elseif(!empty($title))
		{
			$this->_title = $title;
		}
		
		// Last check if the tag is not empty
		if(!empty($this->_title))
		{
			// Return title tag
			return '<title>'.$this->_title.'</title>';	
		}
	}
	
	// Create description tag
	public function Description($description = null)
	{
		// Check Which elements are there and create proper title
		if(!empty($description))
		{
			// Set description value
			$this->_description = $description;
			
			// Return description tag
			return '<meta name="description" content="'.$this->_description.'" />';
		}
	}
	
	// Create author tag
	public function Author($author = null)
	{
		// Check for author value
		if(!empty($author))
		{
			$this->_author = $author;
		}
		
		// Return author tag
		return '<meta name="author" content="'.$author.'" />';
	}
	
	// Create twitter tags. This function uses already set variables like title and author
	public function Twitter($title = null, $card = null, $site = null, $description = null, $creator = null, $largeImage = null)
	{
		// Set variable
		$html = '';

		// Check if page title is already set
		if(!empty($title) && $title !== null)
		{
			$title = $title;
		}
		elseif(!empty($this->_title))
		{
			$title = $this->_title;	
		}
		
		// Check of title tag needs output
		if(!empty($title))
		{
			$html .= '<meta name="twitter:title" content="'.$title.'"><meta name="twitter:title" content="'.$title.'">';
		}
		
		// Check for card
		if(!empty($card) && $card !== null)
		{
			$html .= '<meta name="twitter:card" content="'.$card.'">';
		}
		
		// Check for site
		if(!empty($site) && $site !== null)
		{
			$html .= '<meta name="twitter:site" content="'.$site.'">';
		}
		
		// If description is set
		if(!empty($description) && $description !== null)
		{
			$description = $description;
		}
		elseif(!empty($this->_description))
		{
			$description = $this->_description;	
		}
		
		// Check of title tag needs output
		if(!empty($description))
		{
			$html .= '<meta name="twitter:description" content="'.$description.'">';
		}
		
		// Check for creator
		if(!empty($creator) && $creator !== null)
		{
			$html .= '<meta name="twitter:creator" content="'.$creator.'">';
		}
		
		// Check for large image
		if(!empty($largeImage) && $largeImage !== null)
		{
			$html .= '<meta name="twitter:image:src" content="'.$largeImage.'">';
		}
		
		// Return html
		return $html;
	}
	
	// Google Plus
	public function GooglePlus($title = null, $description = null, $image = null)
	{
		// Set variable
		$html = '';
		
		// Check if page title is already set
		if(!empty($title) && $title !== null)
		{
			$title = $title;
		}
		elseif(!empty($this->_title))
		{
			$title = $this->_title;	
		}
		
		// Check of title tag needs output
		if(!empty($title))
		{
			$html .= '<meta itemprop="name" content="'.$title.'">';
		}
		
		// If description is set
		if(!empty($description) && $description !== null)
		{
			$description = $description;
		}
		elseif(!empty($this->_description))
		{
			$description = $this->_description;	
		}
		
		// Check of title tag needs output
		if(!empty($description))
		{
			$html .= '<meta itemprop="description" content="'.$description.'">';
		}

		// Check for large image
		if(!empty($image) && $image !== null && file_exists($image))
		{
			$html .= '<meta itemprop="image" content="'.$image.'">';
		}
		
		// Return html
		return $html;
	}
	
	// OpenGraph
	public function OpenGraph($title = null, $type = null, $url = null, $image = null, $description = null, $siteName = null, $publishedTime = null, $modifiedTime = null, $section = null, $tag = null, $fbAdmin = null)
	{
		// Set variable
		$html = '';
		
		// Check if page title is already set
		if(!empty($title) && $title !== null)
		{
			$title = $title;
		}
		elseif(!empty($this->_title))
		{
			$title = $this->_title;	
		}
		
		// Check of title tag needs output
		if(!empty($title))
		{
			$html .= '<meta property="og:title" content="'.$title.'" />';
		}
		
		// Check for type
		if(!empty($type) && $type !== null)
		{
			$html .= '<meta property="og:type" content="'.$type.'" />';
		}
		
		// Check for url
		if(!empty($url) && $url !== null)
		{
			$html .= '<meta property="og:url" content="'.$url.'" />';
		}
		
		// Check for image
		if(!empty($image) && $image !== null && file_exists($image))
		{
			$html .= '<meta property="og:image" content="'.$image.'" />';
		}
       
        // If description is set
		if(!empty($description) && $description !== null)
		{
			$description = $description;
		}
		elseif(!empty($this->_description))
		{
			$description = $this->_description;	
		}
		
		// Check of title tag needs output
		if(!empty($description))
		{
			$html .= '<meta property="og:description" content="'.$description.'" />';
		}
        
		// Check for image
		if(!empty($siteName) && $siteName !== null)
		{
			$html .= '<meta property="og:site_name" content="'.$siteName.'" />';
		}
        
		// Check for published time
		if(!empty($publishedTime) && $publishedTime !== null)
		{
			$html .= '<meta property="article:published_time" content="'.$publishedTime.'" />';
		}
        
        // Check for published time
		if(!empty($modifiedTime) && $modifiedTime !== null)
		{
			$html .= '<meta property="article:modified_time" content="'.$modifiedTime.'" />';
		}
		
		// Check for section
		if(!empty($section) && $section !== null)
		{
			$html .= '<meta property="article:section" content="'.$section.'" />';
		}
		
		// Check for article tag
		if(!empty($tag) && $tag !== null)
		{
			$html .= '<meta property="article:tag" content="'.$tag.'" />';
		}
		
		// Check for facebook admin
		if(!empty($fbAdmin) && $fbAdmin !== null)
		{
			$html .= '<meta property="fb:admins" content="'.$fbAdmin.'" />';
		}
		
        return $html;
	}
	
	// Favicon
	public function Favicon($url = null, $pinnedTab = null, $tileColor = null, $themeColor = null)
	{
		// Set variable
		$html = '';
		
		if(!empty($url) && $url !== null)
		{
			$html = '<link rel="apple-touch-icon" sizes="57x57" href="'.$url.'/apple-touch-icon-57x57.png"><link rel="apple-touch-icon" sizes="60x60" href="'.$url.'/apple-touch-icon-60x60.png"><link rel="apple-touch-icon" sizes="72x72" href="'.$url.'/apple-touch-icon-72x72.png"><link rel="apple-touch-icon" sizes="76x76" href="'.$url.'/apple-touch-icon-76x76.png"><link rel="apple-touch-icon" sizes="114x114" href="'.$url.'/apple-touch-icon-114x114.png"><link rel="apple-touch-icon" sizes="120x120" href="'.$url.'/apple-touch-icon-120x120.png"><link rel="apple-touch-icon" sizes="144x144" href="'.$url.'/apple-touch-icon-144x144.png"><link rel="apple-touch-icon" sizes="152x152" href="'.$url.'/apple-touch-icon-152x152.png"><link rel="apple-touch-icon" sizes="180x180" href="'.$url.'/apple-touch-icon-180x180.png"><link rel="icon" type="image/png" href="'.$url.'/favicon-32x32.png" sizes="32x32"><link rel="icon" type="image/png" href="'.$url.'/android-chrome-192x192.png" sizes="192x192"><link rel="icon" type="image/png" href="'.$url.'/favicon-96x96.png" sizes="96x96"><link rel="icon" type="image/png" href="'.$url.'/favicon-16x16.png" sizes="16x16"><link rel="manifest" href="'.$url.'/manifest.json"><meta name="msapplication-TileImage" content="'.$url.'/mstile-144x144.png">';
			
			if(!empty($pinnedTab) && $pinnedTab !== null)
			{
				$html .= '<link rel="mask-icon" href="'.$url.'/safari-pinned-tab.svg" color="'.$pinnedTab.'">';
			}
			
			if(!empty($tileColor) && $tileColor !== null)
			{
				$html .= '<meta name="msapplication-TileColor" content="'.$tileColor.'">';
			}
			
			if(!empty($themeColor) && $themeColor !== null)
			{
				$html .= '<meta name="theme-color" content="'.$themeColor.'">';
			}
		}
		
		return $html;
	}
	
	// Google Analytics
	public function GoogleAnalytics($code = null)
	{
		if(preg_match('/^ua-\d{4,9}-\d{1,4}$/i', strval($code)))
		{
			return '<script>(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;e=o.createElement(i);r=o.getElementsByTagName(i)[0];e.src=\'//www.google-analytics.com/analytics.js\';r.parentNode.insertBefore(e,r)}(window,document,\'script\',\'ga\'));ga(\'create\',\''.$code.'\',\'auto\');ga(\'send\',\'pageview\');</script>';
		}
	}
}