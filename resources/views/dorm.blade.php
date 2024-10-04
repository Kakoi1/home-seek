<!DOCTYPE html>
<html>

<head>
    <title>Facebook SDK Login Example</title>
</head>

<body>
    <h1>Login with Facebook</h1>
    <div id="user-info"></div>

    <!-- Facebook Login Button -->
    <button onclick="facebookLogin()">Login with Facebook</button>

    <!-- Facebook Logout Button -->
    <button onclick="facebookLogout()">Logout from Facebook</button>

    <!-- Facebook SDK Script -->
    <script>
        window.fbAsyncInit = function () {
            FB.init({
                appId: '2273069623069177',
                cookie: true,
                xfbml: true,
                version: 'v20.0'
            });

            FB.getLoginStatus(function (response) {
                statusChangeCallback(response);
            });
        };

        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        function statusChangeCallback(response) {
            if (response.status === 'connected') {
                getUserInfo();
            } else {
                document.getElementById('user-info').innerHTML = 'Not logged in';
            }
        }

        function facebookLogin() {
            FB.login(function (response) {
                if (response.authResponse) {
                    getUserInfo();
                }
            }, { scope: 'public_profile,email' });
        }

        function facebookLogout() {
            FB.logout(function (response) {
                document.getElementById('user-info').innerHTML = 'Logged out';
            });
        }

        function getUserInfo() {
            FB.api('/me', { fields: 'name, email, picture' }, function (response) {
                document.getElementById('user-info').innerHTML = `
                    <p>Name: ${response.name}</p>
                    <p>Email: ${response.email}</p>
                    <img src="${response.picture.data.url}" alt="Profile Picture" />
                `;
            });
        }
    </script>
</body>

</html>