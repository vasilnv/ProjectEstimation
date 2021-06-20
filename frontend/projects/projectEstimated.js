const projectId = new URLSearchParams(window.location.search).get("project");

function refresh() {
    fetch("../../backend/api/projects/get-project-name.php?project=" + projectId)
        .then (response => response.json())
        .then(json => {
            document.getElementById("project-name").innerHTML = json.projectName;
        })

    fetch("../../backend/api/projects/get-project-manager.php?project=" + projectId)
        .then (response => response.json())
        .then(json => {
            document.getElementById("managerName").innerHTML = json.managerName;
        })

    fetch("../../backend/api/projects/get-users-from-project.php?project=" + projectId)
        .then (response => response.json())
        .then(json => {
            document.getElementById("devsNumber").innerHTML = json.numberOfUsers;
            document.getElementById("coefficient").innerHTML = Math.log(json.estimatedTime * 24 /json.totalCapacity);

        })

    fetch("../../backend/api/projects/get-tasks-from-project.php?project=" + projectId)
        .then (response => response.json())
        .then(json => {
            document.getElementById("tasksNumber").innerHTML = json.numberOfTasks;
        })

    fetch("../../backend/api/projects/get-tasks-from-project.php?project=" + projectId)
        .then (response => response.json())
        .then(json => {
            document.getElementById("estimationTime").innerHTML = json.estimatedProjectTime;
        })



}

refresh();