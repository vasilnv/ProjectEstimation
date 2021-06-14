
// fetch('../../backend/api/users/get-users.php', {
//     method: 'GET',
//     // body: JSON.stringify(formData),
//     headers: {
//         'Content-Type': 'application/json'
//         // 'Content-Type': 'application/x-www-form-urlencoded',
//     }
// })
//     .then(response => response.json())
//     .then(response => {
//         if (response.statusCode === 400) {
//             console.log("Няма потребители");
//         } else if (response.statusCode === 500) {
//             console.log("Жестока грешка");
//         } else if (response.statusCode === 200) {
//             console.log("Найс");
//         }
//     })
//     .then(data => alert(data));
fetch("../../backend/api/users/get-users.php")
    
    // Converting received data to JSON
    .then(response => response.json())
    .then(json => {
   
        // Create a variable to store HTML
        let li = `<tr><th>Име</th><th>Фамилия</th><th>Потребителско име</th>
        <th>Роля</th><th>Позиция</th></tr>`;
        
        // Loop through each data and add a table row
        json.forEach(user => {
            li += `<tr>
                <td>${user.name} </td>
                <td>${user.lastname} </td>
                <td>${user.username} </td>
                <td>${user.role} </td>
                <td>${user.position}</td>         
            </tr>`;
        });
   
    // Display result
    document.getElementById("users").innerHTML = li;
});