<?php 
namespace Craft;

use Twig_Extension;
use Twig_Filter_Method;
use Twig_Markup;
use DOMDocument;

class EmailObfuscateTwigExtension extends \Twig_Extension
{
	/**
	 * @var this
	 */
	static $charset;

	/**
	 * Get name of the Twig extension
	 *
	 * @return string
	 */
	public function getName()
	{
		return 'EmailObfuscate';
	}

	/**
	 * Get a list of the Twig filters this extension is providing
	 *
	 * @return array
	 */
	public function getFilters()
	{
		return array(
			'emailObfuscate' => new Twig_Filter_Method($this, 'emailObfuscate'),
			);
	}


	/**
	 * Regex to find email addresses and replace them with full HTML links
	 *
	 * @param string $string
	 * @return string 
	 *
	 */ 
	public function emailObfuscate($string)
	{

		if (trim($string) == '') {
			return;
		}
		
		// Start the dom object
		$dom = new DOMDocument();
		$dom->recover = true;
		$dom->substituteEntities = true;

		// Feed the content to the dom object
		libxml_use_internal_errors(true);
		$dom->loadHTML($string);
		libxml_use_internal_errors(false);

		// Check each link
		foreach ($dom->getElementsByTagName('a') as $anchor) {

			// Get the href
			$href = $anchor->getAttribute('href');

			// // Check if it's a mailto link
			if (substr($href, 0, 7) == 'mailto:') {

				$anchor = $dom->saveHTML($anchor);
				$encoded = $this->js_rot13_encode($anchor);
				$string = str_replace($anchor, $encoded, $string);
			}
		}

		return new Twig_Markup($string, craft()->templates->getTwig()->getCharset());
	}

	/**
	 * Returns a rot13 encrypted string as well as a JavaScript decoder function.
	 * @param string $inputString The string to encrypt
	 * @return string An encoded javascript function
	 */
	private function js_rot13_encode($string)
	{
		$rotated = str_replace('"','\"',str_rot13($string));
		$string = '<script type="text/javascript">
			/*<![CDATA[*/
			document.write("'.$rotated.'".replace(/[a-zA-Z]/g, function(c){return String.fromCharCode((c<="Z"?90:122)>=(c=c.charCodeAt(0)+13)?c:c-26);}));
			/*]]>*/
			</script>';

		return $string;
	}
}
