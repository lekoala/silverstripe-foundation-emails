<% if $SiteConfig.EmailFooter %>
<table class="wrapper secondary" align="center">
    <tr>
        <td class="wrapper-inner">
            <table class="spacer">
                <tbody>
                    <tr>
                        <td height="16px" style="font-size:16px;line-height:16px;">&#xA0;</td>
                    </tr>
                </tbody>
            </table>
            <table class="row">
                <tbody>
                    <tr>
                        <th class="small-12 large-6 columns first">
                            <table>
                                <tr>
                                    <td class="text-center">
                                        <% if SiteConfig.TwitterLink %>
                                        <table class="button twitter expand">
                                            <tr>
                                                <td>
                                                    <table>
                                                        <tr>
                                                            <td class="text-center">
                                                                <a href="$SiteConfig.TwitterLink" align="center" class="float-center">Twitter</a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td class="expander"></td>
                                            </tr>
                                        </table>
                                        <% end_if %>
                                        <% if SiteConfig.FacebookPageLink %>
                                        <table class="button facebook expand">
                                            <tr>
                                                <td>
                                                    <table>
                                                        <tr>
                                                            <td class="text-center">
                                                                <a href="$SiteConfig.FacebookPageLink" align="center" class="float-center">Facebook</a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td class="expander"></td>
                                            </tr>
                                        </table>
                                        <% end_if %>
                                        <% if SiteConfig.GooglePlusLink %>
                                        <table class="button google expand">
                                            <tr>
                                                <td>
                                                    <table>
                                                        <tr>
                                                            <td class="text-center">
                                                                <a href=$SiteConfig.GooglePlusLink" align="center" class="float-center">Google+</a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td class="expander"></td>
                                            </tr>
                                        </table>
                                        <% end_if %>
                                    </td>
                                </tr>
                            </table>
                        </th>
                        <th class="small-12 large-6 columns last">
                            <table>
                                <tr>
                                    <td class="footer-text">
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
</table> <!-- /secondary -->
<% end_if %>