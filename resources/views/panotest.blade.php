@extends('layout.base')
@section('title', 'PanoTest')
@section('content')
<style>
    .iframe-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 80vh; /* Adjust the height as needed */
    }

    .iframe-wrapper {
        width: 60%;
    }

    .back-button {
        margin-top: 20px;
    }
</style>

<div class="iframe-container">
    <div class="iframe-wrapper">
        <iframe src="https://momento360.com/e/uc/d6c25a129d1d42a5ae14c83aff8729f2?utm_campaign=embed&utm_source=other&size=medium&display-plan=true" width="100%" height="800"></iframe>
    </div>
</div>

<div class="text-center">
    <a href="{{ url('admindashboard') }}" class="btn btn-secondary back-button">Back</a>
</div>
@endsection