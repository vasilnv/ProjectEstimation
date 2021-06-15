const projectId = new URLSearchParams(window.location.search).get("project");

function refresh() { 
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
                usersInProject +=  `<li>${user.username}</li>`;
            } else {
                usersNotInProject += `<li>${user.username}</li>`;
            }
        });

        var projectTeam = document.getElementById("project-team"); 
        projectTeam.innerHTML = usersInProject;
        var usersOutsideProject = document.getElementById("users-outside-project");
        usersOutsideProject.innerHTML = usersNotInProject;

        usersOutsideProject.childNodes.forEach(node => {
            node.addEventListener('click', (event) => {
                (async () => {
                    const res = await fetch("../../backend/api/projects/add-user-to-project.php", {
                        method: 'POST',
                        body: JSON.stringify({username: node.textContent, "project": projectId}),
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });

                    refresh();
                })();
            });
        });

        projectTeam.childNodes.forEach(node => {
            node.addEventListener('click', (event) => {
                (async () => {
                    const res = await fetch("../../backend/api/projects/remove-user-from-project.php", {
                        method: 'POST',
                        body: JSON.stringify({username: node.textContent, "project": projectId}),
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });

                    refresh();
                })();
            });
        });
    });
}

refresh();