<?php

/**
 * An html helper for Foundation Emails with or without Inky
 *
 * @author LeKoala <thomas@lekoala.be>
 */
class FoundationEmails
{

    /**
     * Render a button
     *
     * @param string $text
     * @param string $href
     * @param string $tableClass tiny|small|large|expanded|secondary|success|warning|alert|radius|rounded
     * @param string $btnClasses
     * @return string
     */
    public static function button($text, $href, $tableClass = '',
                                  $btnClasses = '')
    {
        if (!empty($tableClass)) {
            $tableClass = ' '.$tableClass;
        }
        $isExpanded = false;
        if (strpos($tableClass, 'expand') !== false) {
            $isExpanded = true;
        }
        $buttonStart = '<table class="button'.$tableClass.'">
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
            $buttonStart = $buttonStart.'<center data-parsed="">';
            $buttonEnd   = '</center>'.$buttonEnd;
        }

        $a = '<a href="'.$href.'" classes="'.$btnClasses.'">'.$text.'</a>';

        return $buttonStart.$a.$buttonEnd;
    }

    /**
     * Create a callout
     *
     * @param type $content
     * @param string $calloutClass primary|secondary|success|warning|alert
     * @return string
     */
    public static function callout($content, $calloutClass = '')
    {
        if (!empty($calloutClass)) {
            $calloutClass = ' '.$calloutClass;
        }
        return '<table class="callout">
  <tr>
    <th class="callout-inner'.$calloutClass.'">
      <p>Successfully avoided Kraken. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>
    </th>
    <th class="expander"></th>
  </tr>
</table>';
    }

    /**
     * Create content in a grid. Columns will have the same size and need to be a multiple of 12.
     *
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
            $columns .= self::column($content, 12 / $c, 12 / $c,
                    implode(' ', $classes));
        }
        return self::container(self::row($columns, $collapse));
    }

    /**
     * Create a container
     *
     * @param string $content
     * @return string
     */
    public static function container($content)
    {
        return '<table align="center" class="container">
  <tbody>
    <tr>
      <td>'.$content.'</td>
    </tr>
  </tbody>
</table>';
    }

    /**
     * Create a row
     *
     * @param string $columns
     * @param string $collapse
     * @return string
     */
    public static function row($columns, $collapse = '')
    {
        if ($collapse) {
            $collapse = ' collapse';
        }
        return ' <table class="row'.$collapse.'">
          <tbody>
            <tr>'.$columns.'</tr>
          </tbody>
        </table>';
    }

    /**
     * Create a column
     *
     * @param string $content
     * @param int $large
     * @param int $small
     * @param string $extraClass first|last|x-offset
     * @return string
     */
    public static function column($content, $large = 12, $small = 12,
                                  $extraClass = '')
    {
        if (!empty($extraClass)) {
            $extraClass = ' '.$extraClass;
        }
        return '<th class="small-'.$small.' large-'.$large.' columns'.$extraClass.'">
  <table>
    <tr>
      <th>'.$content.'</th>
      <th class="expander"></th>
    </tr>
  </table>
</th>';
    }

    /**
     * Parse inky markup
     *
     * @param string $markup
     * @return string
     */
    public static function inky($markup)
    {
        $inky = self::getInky();

        $inky->releaseTheKraken($markup);

        return $inky;
    }

    /**
     * Get a configured Inky instance
     *
     * @return Hampe\Inky\Inky
     */
    public static function getInky()
    {
        $gridColumns                  = self::config()->grid;
        $additionalComponentFactories = self::config()->components;
        $aliases                      = self::config()->aliases;

        $inky = new Hampe\Inky\Inky($gridColumns);
        foreach ($additionalComponentFactories as $additionalComponentFactory) {
            $inky->addComponentFactory(new $additionalComponentFactory());
        }
        foreach ($aliases as $name => $value) {
            $inky->addAlias($name, $value);
        }
        return $inky;
    }
}