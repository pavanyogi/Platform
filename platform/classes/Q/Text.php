<?php
	
/**
 * @module Q
 */
/**
 * Methods for loading text from files.
 * Used for translations, A/B testing and more.
 * @class Q_Text
 */
class Q_Text
{
	public static $collection = array();
	public static $language = 'en';
	public static $locale = 'US';
	
	/**
	 * Call this function to get the basename to use for loading files,
	 * based on the language and locale set on this class.
	 * Used to load files customized to a user's language (and locale).
	 * @param {array} [$options]
	 * @param {string} [$options.language=null] Override language
	 * @param {string} [$options.locale=null] Override locale
	 * @return {string} something like "en-US"
	 */
	static function basename($options = array())
	{
		$locale = Q_Config::get('Q', 'text', 'useLocale', false)
			? self::$locale
			: '';
		if (isset($options['language'])) {
			$language = $options['language'];
			$locale = Q::ifset($options, 'locale', $locale);
		} else {
			$language = self::$language;
		}
		return $locale ? "$language-$locale" : $language;
	}
	
	/**
	 * Sets the language and locale to use in Q_Text::basename() calls.
	 * The Q_Dispatcher::dispatch() method calls this by default using
	 * information from Q_Request::languages().
	 * @method set
	 * @static
	 * @param {String} language Something like "en"
	 * @param {String} [locale=null] Something like "US", but can also be null if unknown
	 */
	static function setLanguage($language, $locale = null)
	{
		self::$language = strtolower($language);
		self::$locale = $locale ? strtoupper($locale) : '';
	}
	
	/**
	 * Sets the text for a specific text source.
	 * @static
	 * @method set
	 * @param {string} name The name of the text source
	 * @param {array} content The content, a hierarchical object whose leaves are
	 *  the actual text translated into the current language in Q.Text.language
	 * @param {boolean} [merge=false] If true, merges on top instead of replacing
	 */
	static function set($name, $content, $merge = false)
	{
		$language = self::$language;
		$locale = self::$locale;
		self::$collection[$language][$locale][$name] = $content;
	}
	
	/**
	 * Get the text from a specific text source or sources.
	 * @static
	 * @method get
	 * @param {string|array} name The name of the text source. Can also be an array,
	 *  in which case the text sources are merged in the order they are named.
	 * @param {array} [$options=array()]
	 * @param {boolean} [$options.ignoreCache=false] If true, reloads the text source even if it's been already cached.
	 * @param {boolean} [$options.merge=false] For Q_Text::set if content is loaded
	 * @param {string} [$options.language=null] Override language
	 * @param {string} [$options.locale=null] Override locale
	 * @param {boolean} [$options.reload=false] Whether to reload the files even if they was already loaded before
	 * @return {array} Returns the (merged) content of the text source(s)
	 */
	static function get($name, $options = array())
	{
		if (is_array($name)) {
			$result = new Q_Tree();
			$name = array_unique($name);
			foreach ($name as $n) {
				$result->merge(self::get($n, $options));
			}
			return $result->getAll();
		}
		$basename = self::basename($options);
		$filename = "text/$name/$basename.json";
		if (self::$get[$filename]) {
			return self::$get[$filename];
		}
		$config = Q_Config::get('Q', 'text', '*', array());
        $json = Q::readFile($filename, Q::take($config, array(
			'ignoreCache' => true,
			'dontCache' => true,
			'duration' => 3600
		)));
		if ($json) {
			$content = Q::json_decode($json, true);
			self::set($name, $content, Q::ifset($options, 'merge', false));
		}
		return self::$get[$filename] = $content ? $content : array();
	}

	/**
	 * Get sources for a view template merged from all the wildcards in the config
	 * Looks in the config under Q/text/$viewPattern and expects an array of strings,
	 * of an object of options, with key "sources" with an array of strings.
	 * @method sources
	 * @static
	 * @param {array} $parts The parts of the view name, to use with Q/text config
	 * @return {array} The merged array of names of sources to load
	 */
	static function sources($parts = array())
	{
		$count = count($parts);
		$try = array();
		for ($i=0, $j=0; $i<=$count; ++$i) {
			$try[$j] = $parts;
			if ($i > 0) {
				array_splice($try[$j], -$i, $i, '*');
			}
			++$j;
		}
		$result = array();
		$count = count($try);
		for ($j=0; $j<$count; ++$j) {
			$p = array_merge(array('Q', 'text'), $try[$j], array(null));
			if ($sources = call_user_func_array(array('Q_Config', 'get'), $p)) {
				if (Q::isAssociative($sources)) {
					$sources = Q::ifset($sources, 'sources', array());
				}
				$result = array_merge($result, $sources);
			}
		}
		return $result;
	}

	/**
	 * Get parameters merged from all the text sources corresponding to a view template.
	 * Looks in the config under Q/text/$viewPattern and expects an array of strings,
	 * of an object of options, with key "sources" with an array of strings.
	 * @method params
	 * @static
	 * @param {array} $parts The parts of the view name, to use with Q/text config
	 * @param {array} [$options=array()] Array of options which will pass to Q_Text::get
	 * @return {array} The merged parameters that come from the text
	 */
	static function params($parts = array(), $options = array())
	{
		$count = count($parts);
		$try = array();
		for ($i=0, $j=0; $i<=$count; ++$i) {
			$try[$j] = $parts;
			if ($i > 0) {
				array_splice($try[$j], -$i, $i, '*');
			}
			++$j;
		}
		$count = count($try);
		$tree = new Q_Tree();
		$sources = array();
		for ($j=0; $j<$count; ++$j) {
			$p = array_merge(array('Q', 'text'), $try[$j], array(null));
			if ($text = call_user_func_array(array('Q_Config', 'get'), $p)) {
				if (Q::isAssociative($text)) { 
					$options2 = array_merge($options, $text);
					if (empty($options2['sources'])) {
						continue;
					}
					$sources = array_merge($sources, $options2['sources']);
				} else {
					$options2 = $options;
					$sources = array_merge($sources, $text);
				}
				
			}
		}
		$sources = array_unique($sources);
		foreach ($sources as $s) {
			$tree->merge(Q_Text::get($s, $options2));
		}
		return $tree->getAll();
	}
	
	/**
	 * Depending on whether the client is a touchscreen or not,
	 * returns either the word "click" or "tap" in the current language,
	 * @method clickOrTap
	 * @static
	 * @param {boolean} $uppercase Whether the first letter should be uppercase
	 * @return {string}
	 */
	static function clickOrTap($uppercase)
	{
		if (Q_Request::isTouchscreen()) {
			$word = $uppercase ? 'Tap' : 'tap';
		} else {
			$word = $uppercase ? 'Click': 'click';
		}
		$text = Q_Text::get('Q/content');
		return Q::ifset($text, 'words', $word, $word);
	}
	
	protected static $get = array();
}