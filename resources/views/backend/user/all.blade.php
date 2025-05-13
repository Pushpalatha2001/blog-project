@extends('layouts.app')

@section('content')

<div class="row mt-2">
    <div class="col-sm-2"></div>
    <div class="col-sm-8 mt-2">
        <h2>User List</h2>
        <div class="card">
            <div class="card-body">
                <div class="container py-4">

                    <form action="{{ route('user_all') }}" method="GET" class="mb-3">
                        <!-- <input type="text" name="search" placeholder="Search by name" class="form-control" value="{{ request()->search }}"> -->
                    <input type="text" id="search" name="search"  class="form-control rounded-pill" placeholder="Search users..." autocomplete="off" value="{{ request()->search }}">
                    </form>

                    <table id="user-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $user['name'] }}</td>
                                    <td>{{ $user['email'] }}</td>
                                    <td>{{ $user['address']['street'] ?? 'N/A' }}, {{ $user['address']['city'] ?? 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-2"></div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#user-table').DataTable({
            "processing": true, // Show processing message while data is being fetched
            "serverSide": true, // Enable server-side processing
            "scrollY": "400px", // Vertical scroll height
            "scrollCollapse": true, // Allow the table to collapse and expand vertically
            "searching": true, // Enable searching (frontend search)
        });

        // Optional: Attach frontend search to filter users in real-time
        $("input[name='search']").on('keyup', function() {
            $('#user-table').DataTable().draw();
        });
    });
</script>
<script>
    function filterTable() {
        // Get the search input and its value
        var input = document.getElementById("search");
        var filter = input.value.toUpperCase();

        // Get the table and its rows
        var table = document.getElementById("user-table");
        var tr = table.getElementsByTagName("tr");

        // Loop through all the rows (skip the first one - headers)
        for (var i = 1; i < tr.length; i++) {
            var tdName = tr[i].getElementsByTagName("td")[0]; // Name column
            var tdEmail = tr[i].getElementsByTagName("td")[1]; // Email column
            var tdAddress = tr[i].getElementsByTagName("td")[2]; // Address column

            // Check if the current row contains the values we are searching for
            if (tdName || tdEmail || tdAddress) {
                var txtValueName = tdName.textContent || tdName.innerText;
                var txtValueEmail = tdEmail.textContent || tdEmail.innerText;
                var txtValueAddress = tdAddress.textContent || tdAddress.innerText;

                // If the search term is found in any of the columns, show the row, else hide it
                if (
                    txtValueName.toUpperCase().indexOf(filter) > -1 ||
                    txtValueEmail.toUpperCase().indexOf(filter) > -1 ||
                    txtValueAddress.toUpperCase().indexOf(filter) > -1
                ) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    // Attach event listener to the search input
    document.getElementById("search").addEventListener("keyup", filterTable);
</script>

@endpush
