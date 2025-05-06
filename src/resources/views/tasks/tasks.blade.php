<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">Tasks</div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="mb-3 text-end">
                            <a href="{{ route('tasks.create') }}" class="btn btn-success">Create Task</a>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Due Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tasksTableBody = document.querySelector('tbody');
            const paginationContainer = document.createElement('div');
            paginationContainer.classList.add('mt-3', 'text-center');
            document.querySelector('.card-body').appendChild(paginationContainer);

            function fetchTasks(page = 1) {
                fetch(`/api/tasks?page=${page}`)
                    .then(response => response.json())
                    .then(data => {
                        tasksTableBody.innerHTML = '';
                        data.data.forEach(task => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${task.id}</td>
                                <td>${task.title}</td>
                                <td>${task.description}</td>
                                <td>${task.status}</td>
                                <td>${task.due_date}</td>
                                <td>
                                    <a href="/tasks/${task.id}/edit" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="/tasks/${task.id}" method="POST" style="display:inline;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            `;
                            tasksTableBody.appendChild(row);
                        });

                        paginationContainer.innerHTML = '';
                        for (let i = 1; i <= data.last_page; i++) {
                            const button = document.createElement('button');
                            button.textContent = i;
                            button.classList.add('btn', 'btn-sm', 'btn-primary', 'mx-1');
                            if (i === data.current_page) {
                                button.disabled = true;
                            }
                            button.addEventListener('click', () => fetchTasks(i));
                            paginationContainer.appendChild(button);
                        }
                    });
            }

            fetchTasks();
        });
    </script>
</body>
</html>