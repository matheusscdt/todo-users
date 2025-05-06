<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table th:last-child, .table td:last-child {
            width: 10%;
        }
    </style>
</head>
<body>
    <div style="position: absolute; top: 10px; right: 10px;">
        <form action="{{ route('auth.logout') }}" method="POST">
            @csrf
            <button type="submit" style="background-color: red; color: white; border: none; padding: 10px 20px; cursor: pointer;">
                Logout
            </button>
        </form>
    </div>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
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
                        <div class="mb-3">
                            <form id="filters-form" class="row g-3">
                                <div class="col-md-4">
                                    <input type="text" name="title" class="form-control" placeholder="Filter by Title">
                                </div>
                                <div class="col-md-3">
                                    <input type="date" name="start_date" class="form-control" placeholder="Start Date" title="Start Date (From)">
                                </div>
                                <div class="col-md-3">
                                    <input type="date" name="end_date" class="form-control" placeholder="End Date" title="End Date (To)">
                                </div>
                                <div class="col-md-2">
                                    <select name="status" class="form-select">
                                        <option value="">All Status</option>
                                        <option value="pending">Pending</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="completed">Completed</option>
                                    </select>
                                </div>
                                <div class="col-md-12 text-end">
                                    <button type="button" id="apply-filters" class="btn btn-primary">Apply Filters</button>
                                </div>
                            </form>
                        </div>
                        <table class="table table-striped table-responsive">
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

    <div id="loading-spinner" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1000;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tasksTableBody = document.querySelector('tbody');
            const paginationContainer = document.createElement('div');
            const loadingSpinner = document.getElementById('loading-spinner');
            paginationContainer.classList.add('mt-3', 'text-center');
            document.querySelector('.card-body').appendChild(paginationContainer);

            function toggleSpinner(show) {
                loadingSpinner.style.display = show ? 'block' : 'none';
            }

            function fetchTasks(page = 1) {
                toggleSpinner(true);
                const formData = new FormData(document.getElementById('filters-form'));
                const params = new URLSearchParams(formData).toString();

                fetch(`/api/tasks?page=${page}&${params}`)
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
                    })
                    .finally(() => toggleSpinner(false));
            }

            fetchTasks();

            document.getElementById('apply-filters').addEventListener('click', () => fetchTasks());
        });
    </script>
</body>
</html>