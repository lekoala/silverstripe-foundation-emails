<?php

use SilverStripe\View\TemplateGlobalProvider;
use SilverStripe\Core\Config\Configurable;

/**
 * An html helper for Foundation Emails with or without Inky
 *
 * @author LeKoala <thomas@lekoala.be>
 */
class FoundationEmails implements TemplateGlobalProvider
{
    use Configurable;

    const THEME_NONE = 'none';
    const THEME_CEEJ = 'ceej';
    const THEME_VISION = 'vision';

    /**
     * @config
     * @var string
     */
    private static $theme = '';

    /**
     * @return array
     */
    public static function get_template_global_variables()
    {
        return array(
            'FoundationSpacer' => array(
                'method' => 'spacer',
                'casting' => 'HTMLText',
            ),
            'FoundationButton' => array(
                'method' => 'button',
                'casting' => 'HTMLText',
            ),
            'FoundationCallout' => array(
                'method' => 'callout',
                'casting' => 'HTMLText',
            ),
            'FoundationContainer' => array(
                'method' => 'container',
                'casting' => 'HTMLText',
            ),
        );
    }

    /**
     * Render a space in content
     *
     * @link http://foundation.zurb.com/emails/docs/spacer.html
     * @param int $height 10 by default
     * @return string
     */
    public static function spacer($height = '10')
    {
        return '<table class="spacer"><tbody><tr><td height="' . $height . 'px" style="font-size:' . $height . 'px;line-height:' . $height . 'px;">&#xA0;</td></tr></tbody></table>';
    }

    /**
     * Render a button
     *
     * @link http://foundation.zurb.com/emails/docs/button.html
     * @param string $text
     * @param string $href
     * @param string $tableClass tiny|small|large|expanded|secondary|success|warning|alert|radius|rounded
     * @param string $btnClasses
     * @return string
     */
    public static function button(
        $text,
        $href,
        $tableClass = '',
        $btnClasses = ''
    ) {
        if (!empty($tableClass)) {
            $tableClass = ' ' . $tableClass;
        }
        $isExpanded = false;
        if (strpos($tableClass, 'expand') !== false) {
            $isExpanded = true;
        }
        $buttonStart = '<table class="button' . $tableClass . '">
          <tr>
            <td>
              <table>
                <tr>
                  <td>';

        $buttonEnd = '</td>
                </tr>
              </table>
            </td>
            <td class="expander"></td>
          </tr>
        </table>';

        if ($isExpanded) {
            $buttonStart = $buttonStart . '<center data-parsed="">';
            $buttonEnd = '</center>' . $buttonEnd;
        }

        $a = '<a href="' . $href . '" classes="' . $btnClasses . '">' . $text . '</a>';

        return $buttonStart . $a . $buttonEnd;
    }

    /**
     * Create a callout
     *
     * @link http://foundation.zurb.com/emails/docs/callout.html
     * @param string $content
     * @param string $calloutClass primary|secondary|success|warning|alert
     * @return string
     */
    public static function callout($content, $calloutClass = '')
    {
        if (!empty($calloutClass)) {
            $calloutClass = ' ' . $calloutClass;
        }
        return '<table class="callout">
  <tr>
    <th class="callout-inner' . $calloutClass . '">
      <p>Successfully avoided Kraken. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>
    </th>
    <th class="expander"></th>
  </tr>
</table>';
    }

    /**
     * Create content in a grid. Columns will have the same size and need to be a multiple of 12.
     *
     * @link http://foundation.zurb.com/emails/docs/grid.html
     * @param array $contentArray
     * @param bool $collapse
     * @return string
     */
    public static function grid(array $contentArray, $collapse = '')
    {
        $c = count($contentArray);
        if (!in_array($c, [1, 2, 3, 4, 6, 12])) {
            throw new Exception("Number of columns must be a multiple of 12");
        }

        $i = 0;

        $columns = '';
        foreach ($contentArray as $content) {
            $i++;
            $classes = [];
            if ($i == 1) {
                $classes[] = 'first';
            }
            if ($i == $c) {
                $classes[] = 'last';
            }
            $columns .= self::column(
                $content,
                12 / $c,
                12 / $c,
                implode(' ', $classes)
            );
        }
        return self::container(self::row($columns, $collapse));
    }

    /**
     * Create a container
     *
     * @link http://foundation.zurb.com/emails/docs/grid.html
     * @param string $content
     * @return string
     */
    public static function container($content)
    {
        return '<table align="center" class="container">
  <tbody>
    <tr>
      <td>' . $content . '</td>
    </tr>
  </tbody>
</table>';
    }

    /**
     * Create a row
     *
     * @link http://foundation.zurb.com/emails/docs/grid.html
     * @param string $columns
     * @param string $collapse
     * @return string
     */
    public static function row($columns, $collapse = '')
    {
        if ($collapse) {
            $collapse = ' collapse';
        }
        return ' <table class="row' . $collapse . '">
          <tbody>
            <tr>' . $columns . '</tr>
          </tbody>
        </table>';
    }

    /**
     * Create a column
     *
     * @link http://foundation.zurb.com/emails/docs/grid.html
     * @param string $content
     * @param int $large
     * @param int $small
     * @param string $extraClass first|last|x-offset
     * @return string
     */
    public static function column(
        $content,
        $large = 12,
        $small = 12,
        $extraClass = ''
    ) {
        if (!empty($extraClass)) {
            $extraClass = ' ' . $extraClass;
        }
        return '<th class="small-' . $small . ' large-' . $large . ' columns' . $extraClass . '">
  <table>
    <tr>
      <th>' . $content . '</th>
      <th class="expander"></th>
    </tr>
  </table>
</th>';
    }

    /**
     * Parse inky markup
     *
     * @link http://foundation.zurb.com/emails/docs/inky.html
     * @param string $markup
     * @return string
     */
    public static function inky($markup)
    {
        $transpiled = \Pinky\transformString($markup);
        return $transpiled->saveHTML();
    }
}
