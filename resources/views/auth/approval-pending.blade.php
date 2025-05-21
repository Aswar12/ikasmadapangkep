<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Thank you for registering with IKA SMADA Pangkep! Your account is pending approval from our administrators. This usually takes 1-2 business days.') }}
    </div>

    <div class="mt-4 bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">{{ __('What happens next?') }}</strong>
        <ul class="mt-2 list-disc list-inside text-sm">
            <li>{{ __('Our admin team will review your registration') }}</li>
            <li>{{ __('You\'ll receive an email notification once your account is approved') }}</li>
            <li>{{ __('You can then log in and access all features of the platform') }}</li>
        </ul>
    </div>
    
    <div class="mt-4 text-sm text-gray-600">
        {{ __('If you have any questions or need assistance, please contact our support team.') }}
    </div>

    <div class="mt-4 flex items-center justify-end">
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
