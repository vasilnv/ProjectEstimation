const btn = document.getElementById('login-btn');
btn.addEventListener('click', (event) => {
    document.getElementById("msg_exists").style.display = 'none';

    var isValid = true;
    console.log(document.getElementById("password").value);
    if (!document.getElementById("password").value.match(new RegExp('^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)[a-zA-Z\\d]{6,10}$'))){
        document.getElementById('error_password').style.display = 'block'
        document.getElementById('password').style.borderColor = '#B0706D'
        document.getElementById('error_password').classList.remove("err_hidden");
        document.getElementById('error_password').classList.add("error");
        isValid = false;
    } else {
        document.getElementById('error_password').style.display = 'none'
        document.getElementById('password').style.borderColor = '#C3CDC0'
        document.getElementById('error_password').classList.remove('error')
    }
    if (document.getElementById("username").value.length < 3 || document.getElementById("username").value.length > 10){
        document.getElementById('error_username').style.display = 'block'
        document.getElementById('username').style.borderColor = '#B0706D'
        document.getElementById('error_username').classList.remove("err_hidden");
        document.getElementById('error_username').classList.add("error");
        isValid = false;
    } else {
        document.getElementById('error_username').style.display = 'none'
        document.getElementById('username').style.borderColor = '#C3CDC0'
        document.getElementById('error_username').classList.remove('error')
    }

    const formData = {
        username: document.getElementById("username").value,
        password: document.getElementById("password").value,
    };

    console.log(isValid);
    if (isValid) {

        fetch('../../backend/api/register-user.php', {
            method: 'GET',
            body: JSON.stringify(formData),
            headers: {
                'Content-Type': 'application/json'
                // 'Content-Type': 'application/x-www-form-urlencoded',
            }
        })
            .then(response=>response.json())
            .then(response=> {
                console.log(response.status);
                if(response.status === 'SUCCESS') {
                    console.log("here");
                    window.location.replace("../login/login.html");
                } else {
                    document.getElementById("msg_exists").style.display='block';
                }
            })
            .then(data=>console.log(data));
    }
    event.preventDefault();

});