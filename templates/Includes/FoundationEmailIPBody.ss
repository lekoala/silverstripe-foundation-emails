<table class="row">
    <tbody>
        <tr>
            <th class="small-12 large-12 columns first last">
                <table>
                    <tr>
                        <th>
<p class="lead"><%t IPEmail.YOURACCOUNTHASBEENACCESSED 'Your account has been accessed from a new IP Address' %>.</p>
<p><%t IPEmail.SECURITYISVERYIMPORTANT 'Your security is very important to us. Your account has been accessed from a new IP address:' %></p>
<p>
------------------------------------------<br/>
email: $Email<br/>
time: $AccessTime<br/>
IP address: $RequestIP<br/>
browser: $RequestUA<br/>
------------------------------------------
</p>

<p><%t WelcomeEmail.IGNOREALERTORCHANGEPW 'If this was you, you can ignore this alert. If you noticed any suspicious activity on your account, please change your password and enable two-factor authentication.' %>.</p>
</th>
<th class="expander"></th>
                    </tr>
                </table>
            </th>
        </tr>
    </tbody>
</table>
