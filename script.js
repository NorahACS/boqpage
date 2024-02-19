document.getElementById('addNewItemButton').addEventListener('click', openPopup);

function openPopup() {
    document.getElementById('popup').style.display = 'block';
}

function closePopup() {
    document.getElementById('popup').style.display = 'none';
}

// Fetch data from the server (assuming it returns JSON)
fetch('submittoboq.php')
    .then(response => response.json()) // Parse the response as JSON
    .then(data => {
        // Process the fetched data
        data.forEach(item => {
            const card = createCard(item);
            document.getElementById('cardContainer').appendChild(card);
        });
    })
    .catch(error => console.error('Error fetching data:', error));

function createCard(data) {
    const card = document.createElement('div');
    card.className = 'card';

    // Iterate through all fields in the data object
    for (const field in data) {
        if (data.hasOwnProperty(field)) {
            const label = document.createElement('label');
            label.textContent = field; // Display the field key as label

            const value = document.createElement('p');
            value.textContent = data[field]; // Display the field value

            card.appendChild(label);
            card.appendChild(value);
        }
    }

    const toggleButton = document.createElement('button');
    toggleButton.className = 'toggle-button';
    toggleButton.addEventListener('click', () => toggleFields(card, data));

    const toggleImage = document.createElement('img');
    toggleImage.src = 'angle-arrow-pointing-down.png';
    toggleImage.alt = 'Show/Hide';

    const deleteButton = document.createElement('button');
    deleteButton.className = 'delete-button';
    deleteButton.addEventListener('click', () => deleteCard(card, data));

    const deleteImage = document.createElement('img');
    deleteImage.src = 'trash.png';
    deleteImage.alt = 'Delete';

    deleteButton.appendChild(deleteImage);
    toggleButton.appendChild(toggleImage);
    card.appendChild(toggleButton);
    card.appendChild(deleteButton);

    return card;
}

function toggleFields(card, data) {
    const hiddenFields = ['period', 'origin', 'unitType', 'itemType'];

    hiddenFields.forEach(field => {
        const label = document.createElement('label');
        label.textContent = data[field].label;

        const value = document.createElement('p');
        value.textContent = data[field].value;

        const div = document.createElement('div');
        div.appendChild(label);
        div.appendChild(value);

        card.appendChild(div);
    });

    const toggleButton = card.querySelector('.toggle-button');
    toggleButton.removeEventListener('click', () => toggleFields(card, data));
    toggleButton.addEventListener('click', () => hideFields(card, data));
}

function hideFields(card, data) {
    const hiddenFields = card.querySelectorAll('div:not(:first-child)'); // Exclude the first child (initial fields)

    hiddenFields.forEach(field => {
        field.remove();
    });

    const toggleButton = card.querySelector('.toggle-button');
    toggleButton.removeEventListener('click', () => hideFields(card, data));
    toggleButton.addEventListener('click', () => toggleFields(card, data));
}

function deleteCard(card, data) {
    // Remove all child elements of the card element
    while (card.firstChild) {
        card.firstChild.remove();
    }

    // Send a request to the server to delete the corresponding database record
    fetch('submittoboq.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ itemNumber: data['item_number'] }), // Adjust the field name here
    })
    .then(response => {
        if (response.ok) {
            return response.json(); // Parse the response as JSON
        } else {
            throw new Error('Error deleting data from database. Server responded with status ' + response.status + ': ' + response.statusText);
        }
    })
    .then(result => console.log(result.message))
    .catch(error => console.error('Error deleting data from database:', error));
}