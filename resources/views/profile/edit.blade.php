@extends('layouts.app')

@section('title', 'My Profile - FeastFlow')

@section('styles')
<style>
    .profile-container {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 2rem 0;
    }
    
    .profile-card {
        width: 100%;
        max-width: 600px;
        animation: fadeIn 0.5s ease;
    }

    .profile-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.25rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-align: center;
        background: linear-gradient(to right, #fff, var(--accent));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .profile-subtitle {
        color: var(--text-muted);
        text-align: center;
        margin-bottom: 2rem;
        font-size: 0.95rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
    }

    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-group.full-width {
        grid-column: span 2;
    }

    .form-label {
        display: block;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text-main);
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid var(--border-glass);
        border-radius: 10px;
        color: var(--text-main);
        font-family: inherit;
        font-size: 0.95rem;
        transition: var(--transition);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--accent);
        background: rgba(255, 255, 255, 0.08);
        box-shadow: 0 0 10px rgba(217, 119, 6, 0.2);
    }

    .dietary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
        gap: 0.75rem;
        margin-top: 0.5rem;
    }

    .dietary-checkbox {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 0.75rem;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--border-glass);
        border-radius: 8px;
        font-size: 0.85rem;
        color: var(--text-muted);
        cursor: pointer;
        transition: var(--transition);
        user-select: none;
    }

    .dietary-checkbox input {
        accent-color: var(--primary);
    }

    .dietary-checkbox:hover {
        background: rgba(255, 255, 255, 0.06);
        color: var(--text-main);
    }

    .dietary-checkbox input:checked + span {
        color: var(--accent);
        font-weight: 600;
    }

    .error-list {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.2);
        padding: 0.75rem 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        list-style: none;
        color: #fca5a5;
        font-size: 0.85rem;
    }
</style>
@endsection

@section('content')
<div class="profile-container">
    <div class="glass-panel profile-card">
        <h1 class="profile-title">Customized Profile</h1>
        <p class="profile-subtitle">Update your preferences and contact info</p>

        @if ($errors->any())
            <ul class="error-list">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                </div>

                <div class="form-group">
                    <label for="address" class="form-label">Default Table / Delivery Address</label>
                    <input type="text" id="address" name="address" class="form-control" value="{{ old('address', $user->address) }}">
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">New Password (leave blank to keep current)</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="••••••••">
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="••••••••">
                </div>

                <div class="form-group full-width">
                    <label class="form-label">Custom Dietary Preferences</label>
                    <div class="dietary-grid">
                        @php
                            $options = ['Vegetarian', 'Vegan', 'Gluten-Free', 'Halal', 'Dairy-Free', 'Nut-Free'];
                        @endphp
                        @foreach($options as $option)
                            <label class="dietary-checkbox">
                                <input type="checkbox" name="dietary_preferences[]" value="{{ $option }}" 
                                    {{ in_array($option, $userPreferences) ? 'checked' : '' }}>
                                <span>{{ $option }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Save Changes</button>
        </form>
    </div>
</div>
@endsection
