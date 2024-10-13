<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>{{ config('app.name') }}</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Add jQuery -->
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-semibold text-center mb-6">{{ __('Reset Password') }}</h2>
        
        <form id="resetPasswordForm">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
        
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email Address') }}</label>
                <input id="email" type="email" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300" name="email" value="{{ old('email', $email ?? '') }}" required autocomplete="email" autofocus>
            </div>
        
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">{{ __('New Password') }}</label>
                <input id="password" type="password" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300" name="password" required autocomplete="new-password">
            </div>
        
            <div class="mb-4">
                <label for="password-confirm" class="block text-sm font-medium text-gray-700">{{ __('Confirm Password') }}</label>
                <input id="password-confirm" type="password" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300" name="password_confirmation" required autocomplete="new-password">
            </div>
        
            <div class="flex items-center justify-between">
                <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2 rounded-md hover:bg-blue-700 transition duration-200">
                    {{ __('Reset Password') }}
                </button>
            </div>
        </form>      
        <div id="message" class="mb-4 font-medium text-sm mt-5" style="display:none;"></div>

    </div>  

    <script>
        $(document).ready(function() {
            $('#resetPasswordForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: '{{ route('password.update') }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#message').removeClass('text-red-600').addClass('text-green-600').text(response.message).show();
                    },
                    error: function(xhr) {
                        const errorResponse = xhr.responseJSON;
                        $('#message').removeClass('text-green-600').addClass('text-red-600').text(errorResponse.message).show();
                    }
                });
            });
        });
    </script>
</body>
</html>
