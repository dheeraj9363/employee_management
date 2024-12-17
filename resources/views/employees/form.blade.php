@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col col-lg-8">
            <h1>{{ isset($employee) ? 'Edit Employee' : 'Create Employee' }}</h1>  
        </div>
    </div>
    <div class="row justify-content-md-center">
        <div class="col col-lg-8">
            <form method="POST" action="{{ isset($employee) ? route('employees.update', $employee->id) : route('employees.store') }}" enctype="multipart/form-data">
              @csrf
              @if(isset($employee))
                @method('PUT') <!-- Use PUT method for updating -->
              @endif
              
              <!-- First Name -->
              <div class="mb-3">
                <label class="form-label" for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" class="form-control" value="{{ old('first_name', $employee->first_name ?? '') }}">
                @error('first_name') 
                    <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>  

              <!-- Last Name -->
              <div class="mb-3">
                <label class="form-label" for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" class="form-control" value="{{ old('last_name', $employee->last_name ?? '') }}">
                @error('last_name') 
                    <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>  

              <!-- Email -->
              <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $employee->email ?? '') }}">
                @error('email') 
                    <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>

              <!-- Mobile -->
              <div class="mb-3">
                <label class="form-label" for="country_code">Mobile</label>
                <div class="d-flex">
                  <select name="country_code" id="country_code" class="form-select w-auto">
                    <option value="+91" {{ (old('country_code', $employee->country_code ?? '') == '+91') ? 'selected' : '' }}>+91</option>
                    <option value="+1" {{ (old('country_code', $employee->country_code ?? '') == '+1') ? 'selected' : '' }}>+1</option>
                  </select>
                  <input type="text" name="mobile" class="form-control ms-2" placeholder="Mobile number" value="{{ old('mobile', $employee->mobile ?? '') }}">
                </div>
                @error('mobile') 
                    <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>

              <!-- Address -->
              <div class="mb-3">
                <label class="form-label" for="address">Address</label>
                <textarea id="address" name="address" class="form-control" rows="4">{{ old('address', $employee->address ?? '') }}</textarea>
                @error('address') 
                    <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>

              <!-- Gender -->
              <div class="mb-3">
                <label class="form-label">Gender</label>
                <div>
                  <input type="radio" id="male" name="gender" value="male" {{ (old('gender', $employee->gender ?? '') == 'male') ? 'checked' : '' }}>
                  <label for="male">Male</label>
                  <input type="radio" id="female" name="gender" value="female" {{ (old('gender', $employee->gender ?? '') == 'female') ? 'checked' : '' }}>
                  <label for="female">Female</label>
                </div>
                @error('gender') 
                    <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>

              <!-- Hobbies -->
              <div class="mb-3 form-check">
                  <label class="form-check-label" for="hobbies">Hobbies</label>
                  <div>
                    <input type="checkbox" class="form-check-input" id="reading" name="hobbies[]" value="reading" {{ in_array('reading', old('hobbies', $employee->hobbies ?? [])) ? 'checked' : '' }}>
                    <label for="reading">Reading</label>
                  </div>
                  <div>
                    <input type="checkbox" class="form-check-input" id="traveling" name="hobbies[]" value="traveling" {{ in_array('traveling', old('hobbies', $employee->hobbies ?? [])) ? 'checked' : '' }}>
                    <label for="traveling">Traveling</label>
                  </div>
                  @error('hobbies') 
                      <div class="text-danger">{{ $message }}</div>
                  @enderror
              </div>

              <!-- Photo -->
              <div class="mb-3">
                <label class="form-label" for="photo">Upload Photo</label>
                <input type="file" id="photo" name="photo" class="form-control">
                @if(isset($employee) && $employee->photo)
                    <img src="{{ asset('storage/' . $employee->photo) }}" alt="Employee Photo" class="img-fluid mt-2" style="max-width: 150px;">
                @endif
                @error('photo') 
                    <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>

              <button type="submit" class="btn btn-primary">{{ isset($employee) ? 'Update' : 'Submit' }}</button>
            </form>
        </div>
    </div>
</div>
@endsection
