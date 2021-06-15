const btnExit = document.getElementById('exit-btn');
btnExit.addEventListener('click', (event) => {
    event.preventDefault();
    window.location.replace("./login/login.html");
});

const btnProject = document.getElementById('create-project-btn');
btnProject.addEventListener('click', (event) => {
    event.preventDefault();
    var isValid = true;
    if (!document.getElementById("project-name").value.match(new RegExp("^[a-zA-Z0-9]{6,50}$"))){
        document.getElementById('error_project_name').style.display = 'block'
        document.getElementById('project-name').style.borderColor = '#B0706D'
        document.getElementById('error_project_name').classList.remove("err_hidden");
        document.getElementById('error_project_name').classList.add("error");
        isValid = false;
    } else {
        document.getElementById('error_project_name').style.display = 'none'
        document.getElementById('project-name').style.borderColor = '#C3CDC0'
        document.getElementById('error_project_name').classList.remove('error')
    }

    const formData = {
        projectName: document.getElementById("project-name").value
    };

    if (isValid) {

        fetch('../backend/api/projects/create-project.php', {
            method: 'POST',
            body: JSON.stringify(formData),
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(response=>response.json())
            .then(data=>console.log(data));
    }
});

const btnTask = document.getElementById('create-task-btn');
btnTask.addEventListener('click', (event) => {
    event.preventDefault();
    window.location.replace("./tasks/task.html")
});

const btnChangeRole = document.getElementById('change-role-btn');
btnChangeRole.addEventListener('click', (event) => {
    event.preventDefault();
    window.location.replace("./users/users.html")
});

const btnChangeWorkHours = document.getElementById('change-work-hours-btn');
btnChangeWorkHours.addEventListener('click', (event) => {
    event.preventDefault();
    var isValid=true;
    const formData = {
        newCapacity: document.getElementById("workHours").value
    };

    if (isValid) {
        fetch('../backend/api/users/change-capacity.php', {
            method: 'POST',
            body: JSON.stringify(formData),
        })
            .then(response => response.json())
            .then(data => console.log(data));
    }
});
