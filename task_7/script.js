$(document).ready(function() {
    const API_URL = 'api.php';
    const $personForm = $('#person-form');
    const $tableBody = $('#people-list-body');
    let localPeopleData = [];

    function fetchAndRenderTable() {
        $.getJSON(API_URL + '?action=read', function(data) {
            localPeopleData = data;
            renderTable();
        }).fail(function() {
            $tableBody.html('<tr><td colspan="4">Error: Could not load data from the server.</td></tr>');
        });
    }

    function renderTable() {
        const searchTerm = $('#searchInput').val().toLowerCase();
        const filteredData = localPeopleData.filter(p =>
            p.FirstName.toLowerCase().includes(searchTerm) ||
            p.Surname.toLowerCase().includes(searchTerm) ||
            p.EmailAddress.toLowerCase().includes(searchTerm)
        );

        $tableBody.empty();

        if (filteredData.length === 0) {
            $tableBody.html('<tr><td colspan="4">No people to display.</td></tr>');
            return;
        }

        filteredData.forEach(function(person) {
            $tableBody.append(`
                <tr>
                    <td>${person.FirstName} ${person.Surname}</td>
                    <td>${person.EmailAddress}</td>
                    <td>${person.DateOfBirth || 'N/A'}</td>
                    <td class="actions">
                        <button class="edit-btn" data-id="${person.PersonID}">Edit</button>
                        <button class="delete-btn" data-id="${person.PersonID}">Delete</button>
                    </td>
                </tr>
            `);
        });
    }

    function resetForm() {
        $personForm[0].reset();
        $('#person-id').val('');
        $('#form-title').text('Add Person');
        $('#submit-btn').text('Save Person');
    }

    $personForm.on('submit', function(e) {
        e.preventDefault();
        const personId = $('#person-id').val();
        const personData = {
            personId: personId ? parseInt(personId) : null,
            firstName: $('#first-name').val(),
            surname: $('#surname').val(),
            dateOfBirth: $('#dob').val(),
            emailAddress: $('#email').val(),
            age: parseInt($('#age').val()) || 0
        };
        const action = personId ? 'update' : 'create';

        $.ajax({
            url: `${API_URL}?action=${action}`,
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(personData),
            success: function() {
                resetForm();
                fetchAndRenderTable();
            }
        });
    });

    $tableBody.on('click', '.edit-btn, .delete-btn', function() {
        const id = $(this).data('id');

        if ($(this).hasClass('delete-btn')) {
            if (confirm('Are you sure you want to delete this person?')) {
                $.ajax({
                    url: `${API_URL}?action=delete`,
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ personId: id }),
                    success: function() {
                        fetchAndRenderTable();
                    }
                });
            }
        }

        if ($(this).hasClass('edit-btn')) {
            const person = localPeopleData.find(p => p.PersonID === id);
            if (person) {
                $('#person-id').val(person.PersonID);
                $('#first-name').val(person.FirstName);
                $('#surname').val(person.Surname);
                $('#dob').val(person.DateOfBirth);
                $('#email').val(person.EmailAddress);
                $('#age').val(person.Age);
                $('#form-title').text('Edit Person');
                $('#submit-btn').text('Update Person');
                window.scrollTo(0, 0);
            }
        }
    });

    $('#find-person-form').on('submit', function(e) {
        e.preventDefault();

        const searchData = {
            action: 'find',
            firstName: $('#find-first-name').val(),
            surname: $('#find-surname').val(),
            dateOfBirth: $('#find-dob').val()
        };

        $.getJSON(API_URL, searchData, function(person) {
            localPeopleData = person ? [person] : [];
            renderTable();
        }).fail(function() {
            alert("An error occurred during the search.");
        });
    });

    $('#show-all-btn').on('click', function() {
        fetchAndRenderTable();
        $('#find-person-form')[0].reset();
    });

    $('#searchInput').on('input', renderTable);

    $('#cancel-btn').on('click', resetForm);

    fetchAndRenderTable();
});