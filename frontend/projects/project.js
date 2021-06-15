const projectId = new URLSearchParams(window.location.search).get("project");

fetch("../../backend/api/projects/get-project-name.php?project=" + projectId)
.then (response => response.json())
.then(json => {
    document.getElementById("project-name").innerHTML = json.projectName;
})

fetch("../../backend/api/users/get-users-with-project.php?project=" + projectId)
    
// Converting received data to JSON
.then(response => response.json())
.then(json => {
    var usersInProject = "";
    var usersNotInProject = "";
    json.forEach(user => {
        if (user.isInProject == 1) {
            usersInProject +=  `<li>${user.name}</li>`;
        } else {
            usersNotInProject += `<li>${user.name}</li>`;
        }
    });
    
    document.getElementById("project-team").innerHTML = usersInProject;
    document.getElementById("users-outside-project").innerHTML = usersNotInProject;
});