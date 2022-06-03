<% if $PreHeader %>
<div style="display: none; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">
    $PreHeader
</div>
<% end_if %>
<table class="wrapper header float-center" align="center">
    <tr>
        <td class="wrapper-inner">
            <table class="container">
                <tbody>
                    <tr>
                        <td>
                            <table class="row collapse">
                                <tbody>
                                    <tr>
                                        <th class="small-12 large-6 columns first">
                                            <table class="wrapper">
                                                <tr>
                                                    <th>
                                                        <% if $SiteConfig.Logo %>
                                                        <img src="$SiteConfig.Logo.ScaleHeight(50).URL" alt="" style="max-width:200px" />
                                                        <% else %>
                                                        <p>$SiteConfig.Title</p>
                                                        <% end_if %>
                                                    </th>
                                                </tr>
                                            </table>
                                        </th>
                                        <th class="small-12 large-6 columns last no-bottom show-for-large">
                                            <table class="wrapper">
                                                <tr>
                                                    <th>
                                                        <p class="text-right">$Subject</p>
                                                    </th>
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
