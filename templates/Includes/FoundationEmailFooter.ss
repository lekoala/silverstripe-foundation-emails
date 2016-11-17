<% if $SiteConfig.EmailFooter %>
<table class="wrapper footer secondary" align="center">
    <tr>
        <td class="wrapper-inner">
            <table class="spacer"><tbody><tr><td height="16px" style="font-size:16px;line-height:16px;">&#xA0;</td></tr></tbody></table>
            <table class="row">
                <tbody>
                    <tr>
                        <% if $SiteConfig.EmailFooterLinks %>
                        <th class="small-12 large-6 columns first">
                            <table class="wrapper">
                                <tr>
                                    <td class="text-center">
                                        <% loop $SiteConfig.EmailFooterLinks %>
                                        <table class="button $Class expand">
                                            <tr>
                                                <td>
                                                    <table>
                                                        <tr>
                                                            <td class="text-center">
                                                                <a href="$Link" align="center" class="float-center">$Label</a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td class="expander"></td>
                                            </tr>
                                        </table>
                                        <% end_loop %>
                                    </td>
                                </tr>
                            </table>
                        </th>
                        <th class="small-12 large-6 columns last">
                            <table class="wrapper">
                                <tr>
                                    <td class="footer-text">
                                        $SiteConfig.EmailFooter
                                    </td>
                                </tr>
                            </table>
                        </th>
                        <% else %>
                        <th class="small-12 large-12 columns last">
                            <table class="wrapper">
                                <tr>
                                    <td class="footer-text text-center">
                                        $SiteConfig.EmailFooter
                                    </td>
                                </tr>
                            </table>
                        </th>
                        <% end_if %>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
</table> <!-- /footer -->
<% end_if %>