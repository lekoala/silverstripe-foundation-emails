<table class="row">
    <tbody>
        <tr>
            <th class="small-12 large-12 columns first last">
                <table>
                    <tr>
                        <th>
                            <table class="spacer">
                                <tbody>
                                    <tr>
                                        <td height="32px" style="font-size:32px;line-height:32px;">&#xA0;</td>
                                    </tr>
                                </tbody>
                            </table>
                            <% if Member.Avatar %>
                    <center data-parsed=""> 
                        <img src="$Member.Avatar.SetWidth(200).URL" align="center" class="float-center"> 
                    </center>
                    <table class="spacer">
                        <tbody>
                            <tr>
                                <td height="16px" style="font-size:16px;line-height:16px;">&#xA0;</td>
                            </tr>
                        </tbody>
                    </table>
                    <% end_if %>

                    <h2><%t WelcomeEmail.HI 'Hi' %> $Member.FirstName $Member.Surname !</h2>

                    <table class="spacer">
                        <tbody>
                            <tr>
                                <td height="16px" style="font-size:16px;line-height:16px;">&#xA0;</td>
                            </tr>
                        </tbody>
                    </table>
                    <h4><%t WelcomeEmail.WELCOME 'Thank you for signing up for' %> {$SiteConfig.Title}.</h4>
                    <p><%t WelcomeEmail.DEFAULT_TEXT 'We\'re really happy to have you! If you have any questions simply reply to this email and I\'d be more than happy to chat. :)' %></p>

                    <% if $ValidationLink %>
                    <p><%t WelcomeEmail.PLEASEVALIDATE 'To login on our website, please' %> <a href="$ValidationLink"><%t WelcomeEmail.VALIDATELINK 'validate your email address' %></a>.</p>

                    <p><%t WelcomeEmail.IFLINKFAILS 'If the above link doesn\'t work, please copy and paste the line below into your browser\'s navigation bar' %>.</p>

                    <p>$ValidationLink</p>
                    <% end_if %>
            </th>
            <th class="expander"></th>
        </tr>
</table>
</th>
</tr>
</tbody>
</table>