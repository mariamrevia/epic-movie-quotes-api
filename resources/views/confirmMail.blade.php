<body>
    <div style='width:100%'>
        <div style="padding:16px; max-width:520px; margin:0 auto">
            
        </div>
        <div style="margin-bottom:40px">
            <h1
                style="margin-bottom: 16px;  margin:0 auto;color: #010414; font-size: 25px; font-weight: bold; margin-top: 0; text-align: center;">
                Confirmation Email</h1>

            <p
            style="margin-bottom: 16px;  margin:0 auto;color: #010414; font-size: 18px;  margin-top: 0; text-align: center;">
            Thanks for joining {{ $verificationUrl }} Movie quotes! We really appreciate it. Please click the button below to verify your account:</p>

        </div>
       

        <a href="{{ $verificationUrl }}" target="_blank"
        style="
        border-bottom: 19px solid #E31221;
        border-left: 100px solid #E31221;
        border-right: 100px solid #E31221;
        border-top: 19px solid #E31221;
        background-color:#E31221;
        display:block;max-width:392px;
        border-radius:8px;color:#fff;
        text-transform:uppercase;
        font-weight:700;margin:0 auto;
        text-decoration:none;
        text-align:center;
        font-size:16px;outline:none">Verify account</a>
    
    </div>
</body>
