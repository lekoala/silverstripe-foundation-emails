<table class="wrapper header float-center" align="center">
    <tr>
        <td class="wrapper">
            <table class="container">
                <tbody>
                    <tr>
                        <td>
                            <table class="row">
                                <tbody>
                                    <tr>
                                        <th class="small-12 large-12 columns first last">
                                            <table>
                                                <tr>
                                                    <th>
                                                        <table class="spacer"><tbody><tr><td height="16px" style="font-size:16px;line-height:16px;">&#xA0;</td></tr></tbody></table>
                                                        <% if $SiteConfig.Logo %>
                                                        <center><img src="$SiteConfig.Logo.SetHeight(50).URL" alt="" style="max-width:200px"  align="center" class="float-center" /></center>
                                                        <% else %>
                                                        <p class="white-color text-center">$SiteConfig.Title</p>
                                                        <% end_if %>
                                                        <table class="spacer"><tbody><tr><td height="16px" style="font-size:16px;line-height:16px;">&#xA0;</td></tr></tbody></table>
                                                    </th>
                                                    <th class="expander"></th>
                                                </tr>
                                            </table>
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="row">
                                <tbody>
                                    <tr>
                                        <th class="small-12 large-12 columns first last header-row">
                                            <table>
                                                <tr>
                                                    <th>
                                                        <table class="spacer"><tbody><tr><td height="'.$height.'px" style="font-size:'.$height.'px;line-height:'.$height.'px;">&#xA0;</td></tr></tbody></table>
                                                        <h1 class="text-center">$Subject</h1>
                                                        <table class="spacer"><tbody><tr><td height="'.$height.'px" style="font-size:'.$height.'px;line-height:'.$height.'px;">&#xA0;</td></tr></tbody></table>
                                                    </th>
                                                    <th class="expander"></th>
                                                </tr>
                                            </table>
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
</table> <!-- /header -->