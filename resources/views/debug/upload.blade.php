<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Profile Photo Upload - Debug Mode</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6">Test Profile Photo Upload - Debug Mode</h1>
        
        @auth
        <div class="mb-4 p-4 bg-blue-50 rounded">
            <p><strong>Logged in as:</strong> {{ Auth::user()->name }}</p>
            <p><strong>User ID:</strong> {{ Auth::user()->id }}</p>
            <p><strong>Current Photo URL:</strong> {{ Auth::user()->profile_photo_url }}</p>
        </div>
        
        <form id="uploadForm" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Select Photo (JPG, PNG, GIF - Max 2MB)
                </label>
                <input type="file" 
                       id="photo" 
                       name="profile_photo" 
                       accept="image/jpeg,image/png,image/jpg,image/gif"
                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>
            
            <button type="submit" 
                    id="uploadBtn"
                    class="w-full py-2 px-4 bg-blue-600 text-white rounded hover:bg-blue-700 disabled:bg-gray-400">
                Upload Photo
            </button>
        </form>
        
        <div id="preview" class="mt-6 hidden">
            <h3 class="font-semibold mb-2">Preview:</h3>
            <img id="previewImg" class="w-32 h-32 object-cover rounded-full">
        </div>
        
        <div id="result" class="mt-6"></div>
        
        <div id="debug" class="mt-6 p-4 bg-gray-100 rounded text-xs font-mono"></div>
        
        @else
        <div class="p-4 bg-red-50 text-red-700 rounded">
            <p>Please login first to test photo upload.</p>
            <a href="{{ route('login') }}" class="text-blue-600 underline">Login here</a>
        </div>
        @endauth
    </div>

    @auth
    <script>
    $(document).ready(function() {
        const debug = (msg) => {
            $('#debug').append(`<div>${new Date().toISOString()}: ${msg}</div>`);
        };
        
        // File preview
        $('#photo').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                debug(`File selected: ${file.name} (${file.size} bytes, ${file.type})`);
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewImg').attr('src', e.target.result);
                    $('#preview').removeClass('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
        
        // Form submission
        $('#uploadForm').on('submit', function(e) {
            e.preventDefault();
            
            const file = $('#photo')[0].files[0];
            if (!file) {
                alert('Please select a file first');
                return;
            }
            
            debug('Starting upload...');
            
            const formData = new FormData();
            formData.append('profile_photo', file);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            
            // Log FormData
            debug('FormData contents:');
            for (let [key, value] of formData.entries()) {
                if (value instanceof File) {
                    debug(`- ${key}: File(${value.name}, ${value.size} bytes)`);
                } else {
                    debug(`- ${key}: ${value}`);
                }
            }
            
            $('#uploadBtn').prop('disabled', true).text('Uploading...');
            $('#result').html('');
            
            $.ajax({
                url: '{{ route("alumni.profile.photo.update") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                success: function(response) {
                    debug('Success response: ' + JSON.stringify(response));
                    $('#result').html(`
                        <div class="p-4 bg-green-50 text-green-700 rounded">
                            <p class="font-semibold">✅ ${response.message}</p>
                            ${response.photo_url ? `<p>New photo URL: ${response.photo_url}</p>` : ''}
                        </div>
                    `);
                    
                    // Reload after 2 seconds
                    setTimeout(() => location.reload(), 2000);
                },
                error: function(xhr, status, error) {
                    debug(`Error: ${status} - ${error}`);
                    debug('Response: ' + xhr.responseText);
                    
                    let errorMsg = 'Upload failed';
                    try {
                        const response = JSON.parse(xhr.responseText);
                        errorMsg = response.message || response.error || errorMsg;
                        if (response.errors && response.errors.profile_photo) {
                            errorMsg = response.errors.profile_photo[0];
                        }
                    } catch (e) {}
                    
                    $('#result').html(`
                        <div class="p-4 bg-red-50 text-red-700 rounded">
                            <p class="font-semibold">❌ Error: ${errorMsg}</p>
                        </div>
                    `);
                },
                complete: function() {
                    $('#uploadBtn').prop('disabled', false).text('Upload Photo');
                }
            });
        });
    });
    </script>
    @endauth
</body>
</html>
