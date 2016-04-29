<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width"/>
        <% base_tag %>

        <% include FoundationEmailStyles %>
    </head>

    <body>
        <!-- <style> -->
        <table class="body" data-made-with-foundation="">
            <tr>
                <td class="float-center" align="center" valign="top">
                    <center>
                        <% include FoundationEmailHeader %>
                        <table class="container float-center">
                            <tbody>
                                <tr>
                                    <td>
                                        <table class="spacer">
                                            <tbody>
                                                <tr>
                                                    <td height="16px" style="font-size:16px;line-height:16px;">&#xA0;</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table class="row primary">
                                            <tbody>
                                                <tr>
                                                    <th class="small-12 large-12 columns first last">
                                                        <table>
                                                            <tr>
                                                                <th>
                                                                    <p class="lead"><%t ChangePasswordEmail_ss.HELLO 'Hi' %> $FirstName,</p>

                                                                    <p>
                                                                        <%t ChangePasswordEmail_ss.CHANGEPASSWORDTEXT1 'You changed your password for' is 'for a url' %> {$SiteConfig.Title}.<br />
                                                                        <%t ChangePasswordEmail_ss.CHANGEPASSWORDTEXT2 'You can now use the following credentials to log in:' %>
                                                                    </p>

                                                                    <p>
                                                                        <%t ChangePasswordEmail_ss.EMAIL 'Email' %>: $Email<br />
                                                                        <%t ChangePasswordEmail_ss.PASSWORD 'Password' %>: $CleartextPassword
                                                                    </p>

                                                                </th>
                                                                <th class="expander"></th>
                                                            </tr>
                                                        </table>
                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table> <!-- /primary -->
                                        <% include FoundationEmailFooter %>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </center>
                </td>
            </tr>
        </table>
    </body>
</html>