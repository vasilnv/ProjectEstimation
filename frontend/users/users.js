

fetch("../../backend/api/users/get-users.php")

    // Converting received data to JSON
    .then(response => response.json())
    .then(json => {
        fetch("../../backend/api/positions/get-positions.php")
            .then(response => response.json())
            .then(positions => {

                // Create a variable to store HTML
                let li = `<tr><th>Име</th><th>Фамилия</th>
        <th>Потребителско име</th><th>Имейл</th>
        <th>Позиция</th><th>Нова Позиция</th>
        <th></th></tr>`;

                // Loop through each data and add a table row
                json.forEach(user => {
                    let options = `<select name="positions" id="0${user.id}">`;
                    positions.forEach(position => {
                        options += `<option value="${position.id}">${position.name}</option>;`
                    })
                    options += `</select>`;


                    li += `
                    <tr id="${user.id}">
                        <td>${user.name}</td>
                        <td>${user.lastname}</td>
                        <td>${user.username}</td>
                        <td>${user.email}</td> 
                        <td>${user.position}</td>
                        <td class="row-data">${options}</td>
                    <td><input type="button" value="Запази" onclick="show()"></input></td> 
                
            </tr>`
                        ;
                });

                // Display result
                document.getElementById("users").innerHTML = li;
            })
    });

const btnSave = document.getElementsByClassName('save-user-btn');

function show() {
    var rowId = event.target.parentNode.parentNode.id;
    var posIdOption = "0" + rowId;
    var posId = document.getElementById(posIdOption).selectedIndex + 1;
    var formData = {
        position: posId,
        userId: rowId
    }
    console.log(formData)
    fetch('../../backend/api/users/change-position.php', {
        method: 'POST',
        body: JSON.stringify(formData),
        headers: {
            'Content-Type': 'application/json'
            // 'Content-Type': 'application/x-www-form-urlencoded',
        }
    })
        .then(response => response.json())
        .then(response => {
            if (response.statusCode === 400) {
                alert("Wrong data");
            } else if (response.statusCode === 500) {
                alert("Error");
            } else if (response.statusCode === 200) {
                console.log("Success");
            }
        })
        .then(data => console.log(data))
        //TODO refresh without reload
        .then(location.reload());
}

                // window.location.replace("../index.html");

