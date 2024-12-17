@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h1>Employee List</h1>  
        </div>
        <div class="col text-end">
            <a href="{{ route('employees.create') }}" class="btn btn-primary btn-lg" tabindex="-1" role="button" aria-disabled="true">Create</a>
        </div>
    </div>

    <!-- Employee Table -->
    <table class="table table-dark table-striped table-responsive">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Gender</th>
                <th>Photo</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
            <tr>
                <td>{{ $employee->id }}</td>
                <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                <td>{{ $employee->email }}</td>
                <td>{{ $employee->mobile }}</td>
                <td>{{ $employee->gender }}</td>
                <td>
                    @if($employee->photo)
                        <img src="{{ asset('storage/' . $employee->photo) }}" alt="Employee Photo" class="img-fluid" style="max-width: 100px;">
                    @else
                        <span>No Photo</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this employee?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
