<?php

/**
 * An html helper for Foundation Emails without Inky
 *
 * @author LeKoala <thomas@lekoala.be>
 */
class FoundationEmails
{

    public static function button($text, $href, $classes = null)
    {
        $buttonStart = '<table class="button expand">
          <tr>
            <td>
              <table>
                <tr>
                  <td>
                    <center data-parsed="">';

        $buttonEnd = '</center>
                  </td>
                </tr>
              </table>
            </td>
            <td class="expander"></td>
          </tr>
        </table>';

        $a = '<a href="'.$href.'" classes="'.$classes.'">'.$text.'</a>';

        return $buttonStart.$a.$buttonEnd;
    }
}