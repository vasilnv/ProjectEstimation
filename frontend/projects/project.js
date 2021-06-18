const projectId = new URLSearchParams(window.location.search).get("project");

function refresh() {
    fetch("../../backend/api/tasks/get-all-tasks-for-project.php?project=" + projectId)
        .then(response => response.json())
        .then(json => {
            var tasksElement = document.getElementById("project-tasks");
            json.forEach(task => {
                let pName = document.createElement("p");
                let lbl = document.createElement("label");
                lbl.innerText = `Име на задачата: ${task.name}`;
                pName.appendChild(lbl);
                tasksElement.appendChild(lbl);
                let pDescription = document.createElement("p");
                let lblDescription = document.createElement("label");
                lblDescription.innerText = `Описание на задачата: ${task.description}`;
                pDescription.appendChild(lblDescription);
                tasksElement.appendChild(pName);
                tasksElement.appendChild(pDescription);
                let pButton = document.createElement("p");
                let btnDelete = document.createElement("button");
                btnDelete.innerText = `Изтрий задача`;
                pButton.appendChild(btnDelete);
                tasksElement.appendChild(pButton);

                btnDelete.addEventListener('click', (event) => {
                        fetch("../../backend/api/tasks/delete-task.php?task=" + `${task.id}`)
                            .then(response=>response.json)
                            .then(data=>console.log(data));
                    });
                })
            });

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
                usersInProject +=  `<li>${user.name} ${user.lastname}, [${user.username}]</li>`;
            } else {
                usersNotInProject += `<li>${user.name} ${user.lastname}, [${user.username}]</li>`;
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
                        body: JSON.stringify({username: node.textContent.match("\\[(.+)\\]")[1], "project": projectId}),
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
                        body: JSON.stringify({username: node.textContent.match("\\[(.+)\\]")[1], "project": projectId}),
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