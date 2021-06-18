const btnCreate = document.getElementById('create-task-btn');
const btnCancel = document.getElementById('cancel-btn');

btnCreate.addEventListener('click', (event) => {
    event.preventDefault();
    var isValid = true;
    if (document.getElementById("task_name").value.length < 3 || document.getElementById("task_name").value.length > 50){
        document.getElementById('error_task_name').style.display = 'block'
        document.getElementById('task_name').style.borderColor = '#B0706D'
        document.getElementById('error_task_name').classList.remove("err_hidden");
        document.getElementById('error_task_name').classList.add("error");
        isValid = false;
    } else {
        document.getElementById('error_task_name').style.display = 'none'
        document.getElementById('task_name').style.borderColor = '#C3CDC0'
        document.getElementById('error_task_name').classList.remove('error')
    }

    //TODO check if a project exists and if not show error_project

    if (document.getElementById("estimation").value < 0){
        document.getElementById('error_estimation').style.display = 'block'
        document.getElementById('estimation').style.borderColor = '#B0706D'
        document.getElementById('error_estimation').classList.remove("err_hidden");
        document.getElementById('error_estimation').classList.add("error");
        isValid = false;
    } else {
        document.getElementById('error_estimation').style.display = 'none'
        document.getElementById('estimation').style.borderColor = '#C3CDC0'
        document.getElementById('error_estimation').classList.remove('error')
    }

    const formData = {
        project: document.getElementById("project").value,
        name: document.getElementById("task_name").value,
        description: document.getElementById("description").value,
        estimation: document.getElementById("estimation").value
    };

    if (isValid) {
        fetch('../../backend/api/tasks/create-task.php', {
            method: 'POST',
            body: JSON.stringify(formData),
            headers: {
                'Content-Type': 'application/json'
                // 'Content-Type': 'application/x-www-form-urlencoded',
            }
        })
            .then(response=>response.json())
            .then(response=> {
                if(response.statusCode === 400) {
                    document.getElementById("error_project").style.display='block';
                    // notify(response);
                } else if(response.statusCode === 500) {
                    document.getElementById("error_server").style.display = 'block';
                } else if (response.statusCode === 200) {
                    window.location.replace("../index.html");
                }
            })
            .then(data=>console.log(data));
    }

});

btnCancel.addEventListener('click', (event) => {
    event.preventDefault();
    window.location.replace("../index.html");
});
