@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4 fw-bold">Admin Dashboard</h2>

    <div class="row g-4">
        <!-- Elections -->
        <div class="col-sm-6 col-lg-3">
            <div class="card text-white bg-primary h-100 shadow">
                <div class="card-body text-center">
                    <h6 class="card-title text-uppercase">Elections</h6>
                    <p class="display-4 fw-bold mb-0">{{ $elections }}</p>
                </div>
                <div class="card-footer text-center">
                    <small>Total Elections</small>
                </div>
            </div>
        </div>

        <!-- Candidates -->
        <div class="col-sm-6 col-lg-3">
            <div class="card text-white bg-success h-100 shadow">
                <div class="card-body text-center">
                    <h6 class="card-title text-uppercase">Candidates</h6>
                    <p class="display-4 fw-bold mb-0">{{ $candidates }}</p>
                </div>
                <div class="card-footer text-center">
                    <small>Total Candidates</small>
                </div>
            </div>
        </div>

        <!-- Voters -->
        <div class="col-sm-6 col-lg-3">
            <div class="card text-white bg-warning h-100 shadow">
                <div class="card-body text-center">
                    <h6 class="card-title text-uppercase">Voters</h6>
                    <p class="display-4 fw-bold mb-0">{{ $voters }}</p>
                </div>
                <div class="card-footer text-center">
                    <small>Registered Voters</small>
                </div>
            </div>
        </div>

        <!-- Votes -->
        <div class="col-sm-6 col-lg-3">
            <div class="card text-white bg-danger h-100 shadow">
                <div class="card-body text-center">
                    <h6 class="card-title text-uppercase">Votes</h6>
                    <p class="display-4 fw-bold mb-0">{{ $votes }}</p>
                </div>
                <div class="card-footer text-center">
                    <small>Total Votes Cast</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
