<p style="margin: 0 0 20px; font-size: 16px; line-height: 1.5; color: #333;">
    You've been invited to create an account!
</p>

<p style="margin: 0 0 25px; font-size: 16px; line-height: 1.5; color: #333;">
    To get started, simply click the button below to create your account.
</p>

<div style="text-align: center; margin: 30px 0;">
    <a 
        href="{{ route('invite.accept', $invite->token) }}" 
        style="
            display: inline-block; 
            padding: 12px 24px; 
            background-color: #c31a00; 
            color: #ffffff; 
            text-decoration: none; 
            border-radius: 4px; 
            font-weight: bold;
            font-size: 16px;
            transition: background-color 0.3s ease;
        "
        onmouseover="this.style.backgroundColor='#a01500'"
        onmouseout="this.style.backgroundColor='#c31a00'"
    >
        Accept Invitation
    </a>
</div>

<p style="margin: 0 0 15px; font-size: 14px; line-height: 1.5; color: #777;">
    If the button doesn’t work, copy and paste this link into your browser:<br>  
    <span style="word-break: break-all; color: #c31a00; font-family: monospace;">
        {{ route('invite.accept', $invite->token) }}
    </span>
</p>

<p style="margin: 0; font-size: 14px; line-height: 1.5; color: #777;">
    If you didn’t request this invitation, you can safely ignore this email.
</p>