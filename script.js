const form = document.getElementById('personForm');
const tableBody = document.getElementById('peopleTableBody');
const message = document.getElementById('message');

function showMessage(text, isError = false) {
    message.textContent = text;

    if (isError) {
        message.style.color = 'red';
    } else {
        message.style.color = 'green';
    }
}

function escapeHtml(value) {
    const div = document.createElement('div');
    div.textContent = value;
    return div.innerHTML;
}

form.addEventListener('submit', async function (event) {
    event.preventDefault();

    const formData = new FormData(form);

    try {
        const response = await fetch('add.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (!response.ok || !data.success) {
            throw new Error(data.message);
        }

        const person = data.person;

        const row = document.createElement('tr');

        row.id = `row-${person.id}`;

        row.innerHTML = `
            <td>${person.id}</td>
            <td>${escapeHtml(person.name)}</td>
            <td>${person.age}</td>
            <td class="status">${person.status}</td>
            <td>
                <button
                    type="button"
                    class="toggle-btn"
                    data-id="${person.id}">
                    Toggle
                </button>
            </td>
        `;

        tableBody.prepend(row);

        form.reset();

        showMessage('Record added successfully');

    } catch (error) {
        showMessage(error.message, true);
    }
});

tableBody.addEventListener('click', async function (event) {
    const button = event.target.closest('.toggle-btn');

    if (!button) {
        return;
    }

    const id = button.dataset.id;

    button.disabled = true;

    try {
        const body = new URLSearchParams();

        body.append('id', id);

        const response = await fetch('toggle.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: body
        });

        const data = await response.json();

        if (!response.ok || !data.success) {
            throw new Error(data.message);
        }

        const row = document.getElementById(`row-${id}`);

        row.querySelector('.status').textContent = data.status;

        showMessage(`Status changed to ${data.status}`);

    } catch (error) {
        showMessage(error.message, true);

    } finally {
        button.disabled = false;
    }
});