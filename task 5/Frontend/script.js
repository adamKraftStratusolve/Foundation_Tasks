const submitButton = document.getElementById('submitBtn');
const resultDiv = document.getElementById('result');

submitButton.addEventListener('click', function() {
    const userInput = document.getElementById('number').value; // Changed ID

    fetch('index.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'number=' + encodeURIComponent(userInput) // Changed key to 'number'
    })
        .then(response => response.text())
        .then(data => {
            resultDiv.innerHTML = data;
        })
        .catch(error => {
            console.error('Error:', error);
            resultDiv.innerHTML = 'An error occurred. Check the console.';
        });
});