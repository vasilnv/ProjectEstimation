fetch("../../backend/api/users/get-users.php")
    
    // Converting received data to JSON
    .then(response => response.json())
    .then(json => {
   
        // Create a variable to store HTML
        let li = `<tr><th>Име</th><th>Фамилия</th><th>Потребителско име</th><th>Позиция</th></tr>`;
        
        // Loop through each data and add a table row
        json.forEach(user => {
            li += `<tr>
                <td>${user.name} </td>
                <td>${user.lastname} </td>
                <td>${user.username} </td>
                <td>${user.position}</td>         
            </tr><button>Edit<button>`
            ;
        });
   
    // Display result
    document.getElementById("users").innerHTML = li;
});