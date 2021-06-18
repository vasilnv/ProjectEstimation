const btn = document.getElementById('register-btn');
btn.addEventListener('click', (event) => {
    document.getElementById("msg_exists").style.display = 'none';

    var isValid = true;
    if (!document.getElementById("email").value.match(new RegExp('^[a-zA-Z0-9\.-]+@[a-z-]+\\.[a-z]+'))){
        document.getElementById('error_email').style.display = 'block'
        document.getElementById('email').style.borderColor = '#B0706D'
        document.getElementById('error_email').classList.remove("err_hidden");
        document.getElementById('error_email').classList.add("error");
        isValid = false;
    } else {
        document.getElementById('error_email').style.display = 'none'
        document.getElementById('email').style.borderColor = '#C3CDC0'
        document.getElementById('error_email').classList.remove('error')
    }
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
    if (document.getElementById("name").value.length > 50){
        document.getElementById('error_name').style.display = 'block'
        document.getElementById('name').style.borderColor = '#B0706D'
        document.getElementById('error_name').classList.remove("err_hidden");
        document.getElementById('error_name').classList.add("error");
        isValid = false;
    } else {
        document.getElementById('error_name').style.display = 'none'
        document.getElementById('name').style.borderColor = '#C3CDC0'
        document.getElementById('error_name').classList.remove('error')
    }
    if (document.getElementById("family-name").value.length > 50){
        document.getElementById('error_family_name').style.display = 'block'
        document.getElementById('family-name').style.borderColor = '#B0706D'
        document.getElementById('error_family_name').classList.remove("err_hidden");
        document.getElementById('error_family_name').classList.add("error");
        isValid = false;
    } else {
        document.getElementById('error_family_name').style.display = 'none'
        document.getElementById('family-name').style.borderColor = '#C3CDC0'
        document.getElementById('error_family_name').classList.remove('error')
    }

    const formData = {
        firstname: document.getElementById("name").value,
        lastname: document.getElementById("family-name").value,
        email: document.getElementById("email").value,
        username: document.getElementById("username").value,
        password: document.getElementById("password").value,
        position: document.getElementById("select-position").value,
        role: "user"
    };

    console.log(isValid);
    if (isValid) {

        fetch('../../backend/api/register-user.php', {
            method: 'POST',
            body: JSON.stringify(formData),
            headers: {
                'Content-Type': 'application/json'
                // 'Content-Type': 'application/x-www-form-urlencoded',
            }
        })
            .then(response=>response.json())
            .then(response=> {
                if(response.status === 'SUCCESS') {
                    window.location.replace("../login/login.html");
                } else {
                    document.getElementById("msg_exists").style.display='block';
                    alert(response.message)
                }
            })
            .then(data=>console.log(data));
    }
    event.preventDefault();

});