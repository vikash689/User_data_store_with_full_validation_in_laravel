<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Form</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #userTable {
            display: none; /* Initially hidden */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>User Form</h2>
        <form id="userForm" onsubmit="submitForm(event)" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" placeholder="Description" required></textarea>
            </div>
            <div class="form-group">
                <label for="role_id">Role</label>
                <select class="form-control" id="role_id" name="role_id" required>
                    <option value="" disabled selected>Select a role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="profile_image">Profile Image</label>
                <input type="file" class="form-control-file" id="profile_image" name="profile_image">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        
        <table class="table" id="userTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Description</th>
                    <th>Role</th>
                    <th>Profile Image</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                <!-- Users will be displayed here -->
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        function submitForm(event) {
            event.preventDefault();

            var formData = new FormData(document.getElementById('userForm'));

            $.ajax({
                url: 'http://127.0.0.1:8000/api/user_store',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                   
                    loadUsers(); 
                    document.getElementById('userForm').reset();
                    $('#userForm').find('input, select, textarea').prop('disabled', true);
                    $('#userTable').show(); 


                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    for (var error in errors) {
                        alert(errors[error][0]);
                    }
                }
            });
        }

        function loadUsers() {
            $.ajax({
                url: 'http://127.0.0.1:8000/api/users',
                type: 'GET',
                success: function(response) {
                    var userTableBody = $('#userTableBody');
                    userTableBody.empty(); 
                    response.forEach(function(user) {
                        var profileImage = user.profile_image ? `<img src="http://127.0.0.1:8000/storage/app/public/${user.profile_image}" alt="Profile Image" width="50">` : 'N/A';
                        userTableBody.append(`
                            <tr>
                                <td>${user.name}</td>
                                <td>${user.email}</td>
                                <td>${user.phone}</td>
                                <td>${user.description}</td>
                                <td>${user.role.name}</td>
                                <td>${profileImage}</td>
                            </tr>
                        `);
                    });
                },
                
            });
        }

        $(document).ready(function() {
           
            $('#userTable').hide();
        });
    </script>
</body>
</html>
