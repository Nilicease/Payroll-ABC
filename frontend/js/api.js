async function api(event) {

    event.preventDefault();

    const link = document.getElementById("formLink").getAttribute("action");
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    const form = {
        email: email,
        password: password
    };

    const response = await fetch(`http://localhost:8000/${link}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(form)
        });
    const result = await response.json();

    return console.log(result);
}