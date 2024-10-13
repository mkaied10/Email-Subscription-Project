@extends('layouts.app')

@section('content')
@if($errors->any())
<div class="alert alert-danger">
    <strong>{{ $errors->first() }}</strong>
</div>
@endif

<h2 class="form-title text-center">Subscribe to Our Email List</h2>
<form method="POST" action="{{ route('subscription.store') }}">
    @csrf
    <div class="form-group">
        <label for="name">Full Name</label>
        <input type="text" class="form-control" id="name" value="{{ old('name') }}" placeholder="Enter your full name" name="name" required>
    </div>
    <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" class="form-control" id="email" value="{{ old('email') }}" placeholder="Enter your email" name="email" required>
    </div>
    <button type="submit" class="btn btn-custom btn-block">Subscribe</button>
</form>


@if(session()->has('success'))
<div class="alert alert-success">
    <strong>{{ session()->get('success') }}</strong>
</div>
@endif
@if(session()->get('isAdmin'))
<div class="container mt-5">
    <h2 class="mb-4">All Subscriptions</h2>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Subscribed At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subscriptions as $subscription)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $subscription->name }}</td>
                    <td>{{ $subscription->email }}</td>
                    <td>{{ $subscription->created_at->format('d-m-Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif


@endsection
