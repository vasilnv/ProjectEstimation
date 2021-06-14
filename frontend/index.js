const btnExit = document.getElementById('exit-btn');
btnExit.addEventListener('click', (event) => {
    event.preventDefault();
    window.location.replace("./login/login.html");
});

const btnProject = document.getElementById('create-project-btn');
btnProject.addEventListener('click', (event) => {
// TODO fetch to backend create a project
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
