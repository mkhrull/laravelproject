@extends('layout.base')
@section('title', 'Dashboard')
@section('content')
<div class="container mt-5">
    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session()->has('status'))
        <div class="alert alert-info">
            {{ session('status') }}
        </div>
    @endif

    <div class="row mb-3 align-items-center">
        <div class="col-auto">
            <div style="width: 100px; height: 100px; border-radius: 50%; overflow: hidden; margin-right: 10px; margin-bottom: 20px;">
                <img src="{{ asset(Auth::user()->image) }}" style="width: 100%; height: 100%; object-fit: cover;" alt="User Image">
            </div>
        </div>
        <div class="col">
            <h3 class="mb-0">Hi, {{ Auth::user()->name }}.</h3>
        </div>
        <div class="col-auto">
            <a href="{{ url('admindashboard/'.Auth::user()->id.'/edit') }}" class="btn btn-secondary ms-2">Profile</a>
            <a href="{{ route('panotest') }}" class="btn btn-info">Easter Egg</a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            List of Users
            <div class="float-end">
                <a href="{{ route('createuser') }}" class="btn btn-success">Create New User</a>
                <button onclick="printTable()" class="btn btn-primary ms-2">Print/Export</button>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                </div>
            </div>
            <div class="table-responsive">
                <table id="userTable" class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td style="max-width: 100px;">
                                <img src="{{ asset($item->image) }}" style="max-width: 100%; height: auto;" alt="{{ $item->name }} Image">
                            </td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->phonenum }}</td>
                            <td>{{ $item->address }}</td>
                            <td>
                                <button class="btn btn-info" onclick="showUserDetails({{ $item }})">Show</button>
                                <a href="{{ url('admindashboard/'.$item->id.'/edit') }}" class="btn btn-primary">Edit</a>
                                <a href="{{ url('admindashboard/'.$item->id.'/delete') }}" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- User Details Modal -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">User Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <img src="" id="modalUserImage" style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%;" alt="User Image">
                        <p>Name: <span id="modalUserName"></span></p>
                        <p>Email: <span id="modalUserEmail"></span></p>
                        <p>Phone Number: <span id="modalUserPhone"></span></p>
                        <p>Address: <span id="modalUserAddress"></span></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript function to print/export table -->
    <script type="text/javascript">
        function printTable() {
            var printContents = document.getElementById('userTable').outerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }

        // JavaScript function to search the table
        document.getElementById('searchInput').addEventListener('keyup', function() {
            var searchValue = this.value.toLowerCase();
            var tableRows = document.querySelectorAll('#userTable tbody tr');

            tableRows.forEach(function(row) {
                var rowText = row.innerText.toLowerCase();
                if (rowText.indexOf(searchValue) === -1) {
                    row.style.display = 'none';
                } else {
                    row.style.display = '';
                }
            });
        });

        // JavaScript function to show user details in modal
        function showUserDetails(user) {
            document.getElementById('modalUserImage').src = '{{ asset('') }}' + user.image;
            document.getElementById('modalUserName').innerText = user.name;
            document.getElementById('modalUserEmail').innerText = user.email;
            document.getElementById('modalUserPhone').innerText = user.phonenum;
            document.getElementById('modalUserAddress').innerText = user.address;

            var userModal = new bootstrap.Modal(document.getElementById('userModal'));
            userModal.show();
        }
    </script>
</div>
@endsection
