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
                                        <th class="small-6 large-6 columns first">
                                            <table>
                                                <tr>
                                                    <th>
                                                        <% if $SiteConfig.Logo %>
                                                        <img src="$SiteConfig.Logo.SetHeight(50).URL" alt="" style="max-width:200px" />
                                                        <% else %>
                                                        $SiteConfig.Title
                                                        <% end_if %>
                                                    </th>
                                                </tr>
                                            </table>
                                        </th>
                                        <th class="small-6 large-6 columns last">
                                            <table>
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