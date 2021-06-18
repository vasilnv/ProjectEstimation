async function getProjects() {
    var projectsManagers = await (await fetch("../backend/api/projects/get-projects-managers.php")).json();
    var projectsUsers = await (await fetch("../backend/api/projects/get-projects-users-without-manager.php")).json();
    var projectsTasks = await (await fetch("../backend/api/projects/get-projects-tasks.php")).json();
    var projects = {};

    projectsManagers.forEach(project => {
        projects[project.projectName] = {
            users: [`Manager:  ${project.firstname} ${project.lastname}, [${project.username}]`],
            tasks: []
        }
    });

    projectsUsers.forEach(element => {
        projects[element.projectName].users.push(`${element.firstname} ${element.lastname}, [${element.username}]`);
    });

    projectsTasks.forEach(task => {
        projects[task.projectName].tasks.push(`${task.taskName}: ${task.estimation}`);
    });

    return projects;
}

function NodeFactory(mmXml) {
    const creator = mmXml;
    return {
        create: function (text) {
            var node = creator.createElement("node");
            node.setAttribute("TEXT", text);
            return node;
        }
    }
}

function exportToMM() {
    getProjects()
        .then(projects => {
            var mmXml = document.implementation.createDocument("", "");
            var nodeFactory = NodeFactory(mmXml);

            var mapNode = mmXml.createElement("map");
            mapNode.setAttribute("version", "1.0.1");

            var projectsNode = nodeFactory.create("Projects");

            Object.entries(projects).forEach(project => {
                const [projectName, projectInfo] = project;
                var projectNode = nodeFactory.create(projectName);

                var teamNode = nodeFactory.create("Team");
                projectInfo.users.forEach(user => {
                    var userNode = nodeFactory.create(user);
                    teamNode.appendChild(userNode);
                });
                projectNode.appendChild(teamNode);

                var tasksNode = nodeFactory.create("Tasks");
                projectInfo.tasks.forEach(task => {
                    var taskNode = nodeFactory.create(task);
                    tasksNode.appendChild(taskNode);
                });
                projectNode.appendChild(tasksNode);

                projectsNode.appendChild(projectNode);
            });


            mapNode.appendChild(projectsNode);
            mmXml.appendChild(mapNode);

            download("export.mm", new XMLSerializer().serializeToString(mmXml));
        });
}

function download(filename, text) {
    var element = document.createElement('a');
    element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
    element.setAttribute('download', filename);

    element.style.display = 'none';
    document.body.appendChild(element);

    element.click();

    document.body.removeChild(element);
}