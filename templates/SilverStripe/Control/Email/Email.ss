<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <% base_tag %>

        <% include FoundationEmailStyles %>
    </head>

    <body>
        <table class="body" data-made-with-foundation="">
            <tr>
                <td class="float-center" align="center" valign="top">
                    <center>
                        $foundationTemplate(FoundationEmailHeader)
                        <table class="container float-center">
                            <tbody>
                                <tr>
                                    <td>
                                        $foundationTemplate(FoundationEmailLayout)
                                        $foundationTemplate(FoundationEmailFooter)
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
