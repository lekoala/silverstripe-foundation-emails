<% if $SiteConfig.EmailFooterLinks %>
<table class="row footer-links">
    <tbody>
        <tr>
            <td class="wrapper wrapper-inner">
                <table align="center">
                    <tbody>
                        <tr>
                            <% loop $SiteConfig.EmailFooterLinks %>
                            <th width="40">
                                <a href="$Link"><img src="$Icon" alt="$Label" align="" /></a>
                            </th>
                            <% end_loop %>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table> <!-- /footer-links-->
<% end_if %>
<% if $SiteConfig.EmailFooter %>
<table class="wrapper footer-white" align="center">
    <tr>
        <td>
            <table class="spacer"><tbody><tr><td height="16px" style="font-size:16px;line-height:16px;">&#xA0;</td></tr></tbody></table>
            <table class="row">
                <tbody>
                    <tr>
                        <th class="small-12 large-12 columns last">
                            <table class="wrapper">
                                <tr>
                                    <td class="footer-text text-center">
                                        $SiteConfig.EmailFooter
                                    </td>
                                </tr>
                            </table>
                        </th>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
</table> <!-- /footer -->
<% end_if %>
<% if $SiteConfig.EmailFooter2 %>
<table class="wrapper footer-white" align="center">
    <tr>
        <td>
            <table class="spacer"><tbody><tr><td height="16px" style="font-size:16px;line-height:16px;">&#xA0;</td></tr></tbody></table>
            <table class="row">
                <tbody>
                    <tr>
                        <th class="small-12 large-12 columns last">
                            <table class="wrapper">
                                <tr>
                                    <td class="footer-text text-center">
                                        $SiteConfig.EmailFooter2
                                    </td>
                                </tr>
                            </table>
                        </th>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
</table> <!-- /footer -->
<% end_if %>