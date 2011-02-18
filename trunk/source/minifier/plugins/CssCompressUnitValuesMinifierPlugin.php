<?php
/**
 * CssMin - A (simple) css minifier with benefits
 * 
 * --
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING 
 * BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND 
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, 
 * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 * --
 * 
 * This {@link aCssMinifierPlugin} will compress several unit values to their short notations. Examples:
 * 
 * <code>
 * padding: 0.5em;
 * border: 0px;
 * margin: 0 0 0 0;
 * </code>
 * 
 * Will get compressed to:
 * 
 * <code>
 * padding:.5px;
 * border:0;
 * margin:0;
 * </code>
 * 
 * --
 *
 * @package		CssMin/Minifier/Plugins
 * @link		http://code.google.com/p/cssmin/
 * @author		Joe Scylla <joe.scylla@gmail.com>
 * @copyright	2008 - 2011 Joe Scylla <joe.scylla@gmail.com>
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 * @version		3.0.0
 */
class CssCompressUnitValuesMinifierPlugin extends aCssMinifierPlugin
	{
	/**
	 * Regular expression used for matching and replacing unit values.
	 * 
	 * @var array
	 */
	private $re = array
		(
		"/(^| |-)0\.([0-9]+?)(0+)?(%|em|ex|px|in|cm|mm|pt|pc)/iS" => "\${1}.\${2}\${4}",
		"/(^| )-?(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/iS" => "\${1}0",
		"/^(0 0 0 0)|(0 0 0)|(0 0)$/iS" => "0"
		);
	/**
	 * Regular expression matching the value.
	 * 
	 * @var string
	 */
	private $reMatch = "/(^| |-)0\.([0-9]+?)(0+)?(%|em|ex|px|in|cm|mm|pt|pc)|(^| )-?(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)|^(0 0 0 0)|(0 0 0)|(0 0)$/iS";
	/**
	 * Implements {@link aCssMinifierPlugin::minify()}.
	 * 
	 * @param aCssToken $token Token to process
	 * @return boolean Return TRUE to break the processing of this token; FALSE to continue
	 */
	public function apply(aCssToken &$token)
		{
		if (get_class($token) === "CssRulesetDeclarationToken" && preg_match($this->reMatch, $token->Value))
			{
			foreach ($this->re as $reMatch => $reReplace)
				{
				$token->Value = preg_replace($reMatch, $reReplace, $token->Value);
				}
			}
		return false;
		}
	}
?>