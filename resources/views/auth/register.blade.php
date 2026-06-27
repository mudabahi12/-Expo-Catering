@extends('layouts.app')

@section('title', 'Register - Expo Catering')

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
        min-height: 80vh;
    }
    
    .auth-card {
        width: 100%;
        max-width: 580px;
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

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .form-group {
        margin-bottom: 1.1rem;
    }

    .form-group.full-width {
        grid-column: span 2;
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

    /* Dietary grid */
    .dietary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 0.6rem;
        margin-top: 0.5rem;
    }

    .dietary-checkbox {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.45rem 0.75rem;
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 0.8rem;
        color: #475569;
        cursor: pointer;
        transition: all 0.2s ease;
        user-select: none;
        font-weight: 600;
    }

    .dietary-checkbox input {
        accent-color: var(--primary-brand);
    }

    .dietary-checkbox:hover {
        background: rgba(230, 95, 43, 0.04);
        border-color: var(--primary-brand);
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

    @media (max-width: 576px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        .form-group.full-width {
            grid-column: span 1;
        }
    }
</style>
@endsection

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h1 class="auth-title">Create Custom Profile</h1>
        <p class="auth-subtitle">Add details to personalize your catering menus</p>

        @if ($errors->any())
            <ul class="error-list">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form action="{{ route('register.post') }}" method="POST">
            @csrf
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="John Doe" value="{{ old('name') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="john@example.com" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" id="phone" name="phone" class="form-control" placeholder="+44 7700 900000" value="{{ old('phone') }}">
                </div>

                <div class="form-group">
                    <label for="address" class="form-label">Delivery Address / Notes</label>
                    <input type="text" id="address" name="address" class="form-control" placeholder="Office 402, Building A" value="{{ old('address') }}">
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Min. 6 characters" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="••••••••" required>
                </div>

                <div class="form-group full-width">
                    <label class="form-label">Dietary Preferences & Allergies</label>
                    <div class="dietary-grid">
                        <label class="dietary-checkbox">
                            <input type="checkbox" name="dietary_preferences[]" value="Vegetarian">
                            <span>Vegetarian</span>
                        </label>
                        <label class="dietary-checkbox">
                            <input type="checkbox" name="dietary_preferences[]" value="Vegan">
                            <span>Vegan</span>
                        </label>
                        <label class="dietary-checkbox">
                            <input type="checkbox" name="dietary_preferences[]" value="Gluten-Free">
                            <span>Gluten-Free</span>
                        </label>
                        <label class="dietary-checkbox">
                            <input type="checkbox" name="dietary_preferences[]" value="Halal">
                            <span>Halal</span>
                        </label>
                        <label class="dietary-checkbox">
                            <input type="checkbox" name="dietary_preferences[]" value="Dairy-Free">
                            <span>Dairy-Free</span>
                        </label>
                        <label class="dietary-checkbox">
                            <input type="checkbox" name="dietary_preferences[]" value="Nut-Free">
                            <span>Nut-Free</span>
                        </label>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 0.5rem; background: var(--primary-brand); border-radius: 8px; font-weight: 750;">Register Profile</button>
        </form>

        <div class="auth-footer">
            Already have a profile? <a href="{{ route('login') }}">Log In</a>
        </div>
    </div>
</div>
@endsection
