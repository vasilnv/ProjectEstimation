"use strict";
const btnProject = document.getElementById('create-project-btn');
btnProject.addEventListener('click', (event) => {
    event.preventDefault();
    var isValid = true;
    if (!document.getElementById("project-name").value.match(new RegExp("^[a-zA-Z0-9]{6,50}$"))) {
        document.getElementById('project-name').style.borderColor = '#B0706D'
        isValid = false;
        alert("Невалидно име на проект! Моля въведете отново.");

    } else {
        document.getElementById('project-name').style.borderColor = '#C3CDC0'
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
            .then(response => response.json())
            .then(data=> {
                location.reload();
                alert(data.message);
            })

    }
});

const btnChangeWorkHours = document.getElementById('change-work-hours-btn');
btnChangeWorkHours.addEventListener('click', (event) => {
    event.preventDefault();
    var isValid = true;
    const formData = {
        newCapacity: document.getElementById("workHours").value
    };

    if (isValid) {
        fetch('../backend/api/users/change-capacity.php', {
            method: 'POST',
            body: JSON.stringify(formData),
        })
            .then(response => response.json())
            .then(data=>alert(data.message));
    }
});

function refresh() {
    var projectsElement = document.getElementById("projects");
    fetch("../backend/api/projects/get-all-projects.php")
        .then(response => response.json())
        .then(json => {
            json.forEach(project => {
                let li = document.createElement("li");

                let h3 = document.createElement("h3");
                h3.innerText = `${project.name}`
                li.appendChild(h3);

                let btnEdit = document.createElement("button");
                btnEdit.innerText = `Промени проект`;
                li.appendChild(btnEdit);
                let btnEstimate = document.createElement("button");
                btnEstimate.innerText = `Оцени проект`;
                li.appendChild(btnEstimate);

                projectsElement.appendChild(li);

                btnEdit.addEventListener('click', (event) => {
                    event.preventDefault();

                    window.location.replace(`projects/project.html?project=${project.id}`)
                });

                btnEstimate.addEventListener('click', (event) => {
                    event.preventDefault();
                    window.location.replace(`projects/projectEstimated.html?project=${project.id}`);
                });
            });
        })
}

refresh();
