<x-layouts.app>


    <div class="flex min-h-screen bg-white">
        <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm lg:w-96">

                @if ($successfulRegistration)
                    <div class="rounded-md bg-green-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <!-- Heroicon name: solid/check-circle -->
                                <svg
                                    class="h-5 w-5 text-green-400"
                                    aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">
                                    Successfully registered. <br />We've sent you an email confirmation.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($deletedRegistration)
                    <div class="rounded-md bg-green-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <!-- Heroicon name: solid/check-circle -->
                                <svg
                                    class="h-5 w-5 text-green-400"
                                    aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">
                                    Registration successfully deleted. <br />We've sent you an email confirmation.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <div>
                    <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                        Magnolia Green Volleyball
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Weekly Adult Pickup Games. Located in Arbor Walk.
                    </p>
                    <p class="mt-1 text-sm text-gray-600">
                        Register for: <span class="font-bold">
                            {{ $cutoff->format('l, F jS, Y') }} at 3PM
                        </span>
                    </p>
                </div>

                <div class="mt-8">
                    <div class="mt-6">
                        <form
                            class="space-y-6"
                            action="{{ route('signups.store') }}"
                            method="POST"
                        >
                            @csrf
                            <input
                                name="cutoff"
                                type="hidden"
                                value="{{ $cutoff }}"
                            >
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    for="name"
                                >
                                    Name
                                </label>
                                <div class="mt-1">
                                    <input
                                        class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                                        id="name"
                                        name="name"
                                        type="text"
                                        value="{{ old('name') }}"
                                        required
                                    >
                                    @error('name')
                                        <p
                                            class="mt-2 text-sm text-red-600"
                                            id="email-error"
                                        >{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="space-y-1">
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    for="email"
                                >
                                    Email address
                                </label>
                                <div class="mt-1">
                                    <input
                                        class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                                        id="email"
                                        name="email"
                                        type="email"
                                        value="{{ old('email') }}"
                                        autocomplete="email"
                                        required
                                    >

                                    @error('email')
                                        <p
                                            class="mt-2 text-sm text-red-600"
                                            id="email-error"
                                        >{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <div class="flex items-center">
                                    <input
                                        name="receive_reminders"
                                        type="hidden"
                                        value="0"
                                    >
                                    <input
                                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                        id="receive-reminders"
                                        name="receive_reminders"
                                        type="checkbox"
                                        value="1"
                                        {{ old('receive_reminders') ? 'checked' : '' }}
                                    >
                                    <label
                                        class="ml-2 block text-sm text-gray-900"
                                        for="receive-reminders"
                                    >
                                        Receive weekly sign up reminders
                                        <span class="block text-xs">(unsubscribe anytime)</span>
                                    </label>

                                </div>
                                @error('receive_reminders')
                                    <p
                                        class="mt-2 text-sm text-red-600"
                                        id="email-error"
                                    >{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <button
                                    class="flex w-full justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                    type="submit"
                                >
                                    COUNT ME IN!
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="relative hidden w-0 flex-1 lg:block">
            <img
                class="absolute inset-0 h-full w-full object-cover"
                src="{{ Vite::image('volleyball-court.jpg') }}"
            >
        </div>
    </div>


</x-layouts.app>
