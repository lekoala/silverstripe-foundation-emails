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
                                        <table class="spacer"><tbody><tr><td height="16px" style="font-size:16px;line-height:16px;">&#xA0;</td></tr></tbody></table>
                                        <table class="row primary">
                                            <tbody>
                                                <tr>
                                                    <th class="small-12 large-12 columns first last">
                                                        <p class="lead"><%t ForgotPasswordEmail_ss.HELLO 'Hi' %> $FirstName,</p>
                                                        <p><%t ForgotPasswordEmail_ss.TEXT1 'Here is your' %> <%t ForgotPasswordEmail_ss.TEXT2 'password reset link' %>  <%t ForgotPasswordEmail_ss.TEXT3 'for' %> {$SiteConfig.Title}.</p>
                                                        </p>
                                                        <table class="button large expand">
                                                            <tr>
                                                                <td>
                                                                    <table>
                                                                        <tr>
                                                                            <td>
                                                                                <center data-parsed=""><a href="$PasswordResetLink" align="center" class="float-center"><%t ForgotPasswordEmail_ss.TEXTBTN 'Reset your password' %></a></center>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                                <td class="expander"></td>
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
        <!-- prevent Gmail on iOS font size manipulation -->
        <div style="display:none; white-space:nowrap; font:15px courier; line-height:0;"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </div>
    </body>
</html>