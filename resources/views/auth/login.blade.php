@extends('layouts.app')

@section('title', 'Log In - Expo Catering')

@section('styles')
<style>
    body {
        background-color: #fcfbfa !important;
        --primary-brand: #e65f2b;
        background-image: 
            linear-gradient(to right, rgba(230, 95, 43, 0.03) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(230, 95, 43, 0.03) 1px, transparent 1px) !important;
        background-size: 30px 30px !important;
    }

    .auth-container {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 3rem 0;
        min-height: 75vh;
    }
    
    .auth-card {
        width: 100%;
        max-width: 440px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 2.25rem;
        box-shadow: 0 10px 25px -5px rgba(230, 95, 43, 0.05);
        animation: fadeIn 0.4s ease;
    }

    .auth-title {
        font-family: 'Outfit', sans-serif;
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.35rem;
        text-align: center;
        color: #0f172a;
    }

    .auth-subtitle {
        color: #64748b;
        text-align: center;
        margin-bottom: 2rem;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-label {
        display: block;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.4rem;
        color: #475569;
    }

    .form-control {
        width: 100%;
        padding: 0.65rem 0.85rem;
        background: white;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        color: #1e293b;
        font-family: inherit;
        font-size: 0.9rem;
        outline: none;
        transition: border-color 0.2s ease;
    }

    .form-control:focus {
        border-color: var(--primary-brand);
    }

    .form-checkbox {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.85rem;
        color: #64748b;
        cursor: pointer;
        font-weight: 600;
    }

    .form-checkbox input {
        accent-color: var(--primary-brand);
    }

    .auth-footer {
        margin-top: 1.5rem;
        text-align: center;
        font-size: 0.85rem;
        color: #64748b;
    }

    .auth-footer a {
        color: var(--primary-brand);
        text-decoration: none;
        font-weight: 700;
    }

    .auth-footer a:hover {
        text-decoration: underline;
    }

    .error-list {
        background: #fee2e2;
        border: 1px solid #fca5a5;
        padding: 0.65rem 0.85rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        list-style: none;
        color: #991b1b;
        font-size: 0.8rem;
    }
</style>
@endsection

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h1 class="auth-title">Welcome Back</h1>
        <p class="auth-subtitle">Log in to manage operations & shopping cart</p>

        @if ($errors->any())
            <ul class="error-list">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="name@example.com" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>

            <div class="form-group" style="display: flex; justify-content: space-between; align-items: center;">
                <label class="form-checkbox">
                    <input type="checkbox" name="remember">
                    <span>Remember me</span>
                </label>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 0.5rem; background: var(--primary-brand); border-radius: 8px; font-weight: 750;">Log In</button>
        </form>

        <div class="auth-footer">
            Don't have a customized profile? <a href="{{ route('register') }}">Create Profile</a>
        </div>
    </div>
</div>
@endsection
