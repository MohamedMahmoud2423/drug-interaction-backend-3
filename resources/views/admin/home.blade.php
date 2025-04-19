@extends('admin.layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center">Registered Users</h2>
    <div class="card shadow">
        <div class="card-body table-responsive">
            <table class="table table-hover text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>

                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>

                            <td>{{ $user->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('profile.show', $user->id) }}" class="btn btn-sm btn-outline-primary">View Profile</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
