"use strict";
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

function refresh() {
    var projectsElement = document.getElementById("projects");
    fetch("../backend/api/projects/get-all-projects.php")
        .then (response => response.json())
        .then(json => {
            json.forEach(project => {
                let lbl = document.createElement("label");
                lbl.innerText = `${project.name}`;
                projectsElement.appendChild(lbl);
                let btnEdit = document.createElement("button");
                btnEdit.innerText = `Промени проект`;
                projectsElement.appendChild(btnEdit);
                let btnEstimate = document.createElement("button");
                btnEstimate.innerText = `Оцени проект`;
                projectsElement.appendChild(btnEstimate);

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
