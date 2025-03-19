@extends('layouts.artisan')

@section('title', 'Artisan Profile')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-amber-800 mb-6">My Profile</h1>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Profile Information -->
                        <div class="lg:col-span-1">
                            <div class="bg-amber-50 p-6 rounded-lg shadow">
                                <div class="flex flex-col items-center">
                                    <div class="w-32 h-32 rounded-full overflow-hidden mb-4">
                                        @if (Auth::user()->profile_image || (isset($artisanProfile) && $artisanProfile->profile_photo))
                                            <img src="{{ asset('storage/' . (Auth::user()->profile_image ?? ($artisanProfile->profile_photo ?? ''))) }}"
                                                alt="{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}"
                                                class="w-full h-full object-cover">
                                        @else
                                            <div
                                                class="w-full h-full bg-amber-200 flex items-center justify-center text-amber-600 text-3xl font-bold">
                                                {{ strtoupper(substr(Auth::user()->firstname, 0, 1) . substr(Auth::user()->lastname, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <h2 class="text-xl font-medium">{{ Auth::user()->firstname }}
                                        {{ Auth::user()->lastname }}</h2>
                                    <p class="text-gray-500">
                                        {{ isset($artisanProfile) && $artisanProfile ? $artisanProfile->profession ?? 'Artisan' : 'Artisan' }}
                                    </p>

                                    <form action="{{ route('artisan.profile.photo') }}" method="POST"
                                        enctype="multipart/form-data" class="mt-4">
                                        @csrf
                                        <input type="file" name="profile_photo" id="photo" class="hidden"
                                            onchange="this.form.submit()">
                                        <label for="photo"
                                            class="inline-flex items-center px-4 py-2 bg-amber-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-700 active:bg-amber-900 focus:outline-none focus:border-amber-900 focus:ring ring-amber-300 disabled:opacity-25 transition ease-in-out duration-150 cursor-pointer">
                                            <i class="fas fa-camera mr-2"></i> Update Photo
                                        </label>
                                    </form>
                                </div>

                                <div class="mt-6">
                                    <h3 class="font-medium text-gray-700 mb-2">Contact Information</h3>
                                    <div class="space-y-2 text-sm">
                                        <p class="flex items-center">
                                            <i class="fas fa-envelope text-amber-600 mr-2 w-5"></i>
                                            {{ Auth::user()->email }}
                                        </p>
                                        <p class="flex items-center">
                                            <i class="fas fa-phone text-amber-600 mr-2 w-5"></i>
                                            {{ isset($artisanProfile) && $artisanProfile ? $artisanProfile->phone ?? '+33 1 23 45 67 89' : '+33 1 23 45 67 89' }}
                                        </p>
                                        <p class="flex items-center">
                                            <i class="fas fa-map-marker-alt text-amber-600 mr-2 w-5"></i>
                                            @php
                                                $fullAddress = '';
                                                if (isset($artisanProfile) && $artisanProfile) {
                                                    $addressParts = [];
                                                    if (!empty($artisanProfile->address)) {
                                                        $addressParts[] = $artisanProfile->address;
                                                    }
                                                    if (!empty($artisanProfile->city)) {
                                                        $addressParts[] = $artisanProfile->city;
                                                    }
                                                    if (!empty($artisanProfile->postal_code)) {
                                                        $addressParts[] = $artisanProfile->postal_code;
                                                    }
                                                    if (!empty($artisanProfile->country)) {
                                                        $addressParts[] = $artisanProfile->country;
                                                    }
                                                    $fullAddress = !empty($addressParts)
                                                        ? implode(', ', $addressParts)
                                                        : 'Paris, France';
                                                } else {
                                                    $fullAddress = 'Paris, France';
                                                }
                                            @endphp
                                            {{ $fullAddress }}
                                        </p>
                                    </div>

                                    <button type="button" onclick="toggleModal('contactInfoModal')"
                                        class="mt-4 w-full inline-flex justify-center items-center px-3 py-1 bg-amber-100 text-amber-600 border border-transparent rounded-md font-medium text-xs uppercase tracking-widest hover:bg-amber-200 active:bg-amber-300 focus:outline-none focus:ring ring-amber-200 transition ease-in-out duration-150">
                                        <i class="fas fa-edit mr-1"></i> Edit Contact Info
                                    </button>
                                </div>

                                <div class="mt-6">
                                    <h3 class="font-medium text-gray-700 mb-2">Business Information</h3>
                                    <div class="space-y-2 text-sm">
                                        <p class="flex items-center">
                                            <i class="fas fa-building text-amber-600 mr-2 w-5"></i>
                                            {{ isset($artisanProfile) && $artisanProfile ? $artisanProfile->business_name ?? 'Not specified' : 'Not specified' }}
                                        </p>
                                        <p class="flex items-center">
                                            <i class="fas fa-id-card text-amber-600 mr-2 w-5"></i>
                                            Reg:
                                            {{ isset($artisanProfile) && $artisanProfile ? $artisanProfile->business_registration_number ?? 'Not specified' : 'Not specified' }}
                                        </p>
                                    </div>

                                    <button type="button" onclick="toggleModal('businessInfoModal')"
                                        class="mt-4 w-full inline-flex justify-center items-center px-3 py-1 bg-amber-100 text-amber-600 border border-transparent rounded-md font-medium text-xs uppercase tracking-widest hover:bg-amber-200 active:bg-amber-300 focus:outline-none focus:ring ring-amber-200 transition ease-in-out duration-150">
                                        <i class="fas fa-edit mr-1"></i> Edit Business Info
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Details -->
                        <div class="lg:col-span-2">
                            <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-medium text-gray-800">Professional Information</h3>
                                    <button type="button" onclick="toggleModal('professionalInfoModal')"
                                        class="inline-flex items-center px-3 py-1 bg-amber-100 text-amber-600 border border-transparent rounded-md font-medium text-xs uppercase tracking-widest hover:bg-amber-200 active:bg-amber-300 focus:outline-none focus:ring ring-amber-200 transition ease-in-out duration-150">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </button>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Profession</h4>
                                        <p class="mt-1">
                                            {{ isset($artisanProfile) && $artisanProfile ? $artisanProfile->profession ?? 'Not specified' : 'Not specified' }}
                                        </p>
                                    </div>

                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">About Me</h4>
                                        <p class="mt-1 text-sm text-gray-600">
                                            {{ isset($artisanProfile) && $artisanProfile ? $artisanProfile->about_me ?? 'No information provided yet.' : 'No information provided yet.' }}
                                        </p>
                                    </div>

                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Experience</h4>
                                        <p class="mt-1">
                                            {{ isset($artisanProfile) && $artisanProfile ? $artisanProfile->experience_years ?? 0 : 0 }}
                                            years</p>
                                    </div>

                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Hourly Rate</h4>
                                        <p class="mt-1">
                                            €{{ isset($artisanProfile) && $artisanProfile ? $artisanProfile->hourly_rate ?? '0' : '0' }}
                                        </p>
                                    </div>

                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Skills & Expertise</h4>
                                        <div class="mt-2 flex flex-wrap gap-2">
                                            @if (isset($artisanProfile) &&
                                                    isset($artisanProfile->skills) &&
                                                    is_array($artisanProfile->skills) &&
                                                    count($artisanProfile->skills) > 0)
                                                @foreach ($artisanProfile->skills as $skill)
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-amber-100 text-amber-800">
                                                        {{ $skill }}
                                                    </span>
                                                @endforeach
                                            @else
                                                <p class="text-sm text-gray-500">No skills added yet.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white p-6 rounded-lg shadow border border-gray-100 mt-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-medium text-gray-800">Work Experience</h3>
                                    <button type="button" onclick="toggleModal('workExperienceModal')"
                                        class="inline-flex items-center px-3 py-1 bg-amber-100 text-amber-600 border border-transparent rounded-md font-medium text-xs uppercase tracking-widest hover:bg-amber-200 active:bg-amber-300 focus:outline-none focus:ring ring-amber-200 transition ease-in-out duration-150">
                                        <i class="fas fa-plus mr-1"></i> Add
                                    </button>
                                </div>

                                <!-- Work Experience Section -->
                                <div class="space-y-6">
                                    @if (isset($workExperiences) && count($workExperiences) > 0)
                                        @foreach ($workExperiences as $experience)
                                            <div class="border-l-2 border-amber-500 pl-4">
                                                <h4 class="font-medium">
                                                    {{ $experience->position ?? $experience->title }}{{ $experience->company_name ? ', ' . $experience->company_name : '' }}
                                                </h4>
                                                <p class="text-sm text-gray-500">
                                                    @if (isset($experience->start_date) && !empty($experience->start_date))
                                                        {{ date('M Y', strtotime($experience->start_date)) }} -
                                                        @if ($experience->is_current)
                                                            Present
                                                        @elseif(isset($experience->end_date) && !empty($experience->end_date))
                                                            {{ date('M Y', strtotime($experience->end_date)) }}
                                                        @else
                                                            (No end date)
                                                        @endif
                                                    @else
                                                        {{ $experience->date_range ?? 'Date not specified' }}
                                                    @endif
                                                </p>
                                                <p class="mt-1 text-sm">{{ $experience->description }}</p>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-center text-gray-500 py-4">
                                            No work experience added yet. Click the "Add" button to add your work
                                            experience.
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="bg-white p-6 rounded-lg shadow border border-gray-100 mt-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-medium text-gray-800">Certifications</h3>
                                    <button type="button" onclick="toggleModal('certificationModal')"
                                        class="inline-flex items-center px-3 py-1 bg-amber-100 text-amber-600 border border-transparent rounded-md font-medium text-xs uppercase tracking-widest hover:bg-amber-200 active:bg-amber-300 focus:outline-none focus:ring ring-amber-200 transition ease-in-out duration-150">
                                        <i class="fas fa-plus mr-1"></i> Add
                                    </button>
                                </div>

                                <!-- Certifications Section -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @if (isset($certifications) && count($certifications) > 0)
                                        @foreach ($certifications as $certification)
                                            <div class="bg-gray-50 p-4 rounded-lg relative">
                                                <h4 class="font-medium">{{ $certification->name ?? $certification->title }}
                                                </h4>
                                                <p class="text-sm text-gray-500">Issued by:
                                                    {{ $certification->issuer ?? $certification->issuing_organization }}
                                                </p>
                                                <p class="text-sm text-gray-500">Valid until:
                                                    @if (isset($certification->valid_until) && !empty($certification->valid_until))
                                                        {{ date('M Y', strtotime($certification->valid_until)) }}
                                                    @elseif (isset($certification->expiry_date) && !empty($certification->expiry_date))
                                                        {{ date('M Y', strtotime($certification->expiry_date)) }}
                                                    @else
                                                        Not specified
                                                    @endif
                                                </p>
                                                <form
                                                    action="{{ route('artisan.profile.certification.delete', $certification->id) }}"
                                                    method="POST" class="absolute top-2 right-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700"
                                                        onclick="return confirm('Are you sure you want to delete this certification?')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-span-2 text-center text-gray-500 py-4">
                                            No certifications added yet. Click the "Add" button to add your certifications.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Work Experience Modal -->
    <div id="workExperienceModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Add Work Experience</h3>

                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="mt-4" action="{{ route('artisan.profile.work-experience') }}" method="POST">
                    @csrf
                    <input type="hidden" name="artisan_profile_id"
                        value="{{ isset($artisanProfile) && $artisanProfile ? $artisanProfile->id : '' }}">
                    <div class="mb-4 text-left">
                        <label for="title" class="block text-sm font-medium text-gray-700">Job Title</label>
                        <input type="text" name="title" id="title" required
                            class="mt-1 focus:ring-amber-500 focus:border-amber-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="mb-4 text-left">
                        <label for="company" class="block text-sm font-medium text-gray-700">Company</label>
                        <input type="text" name="company" id="company"
                            class="mt-1 focus:ring-amber-500 focus:border-amber-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4 text-left">
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                            <input type="date" name="start_date" id="start_date" required
                                class="mt-1 focus:ring-amber-500 focus:border-amber-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div class="mb-4 text-left">
                            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                            <input type="date" name="end_date" id="end_date"
                                class="mt-1 focus:ring-amber-500 focus:border-amber-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>
                    <div class="mb-4 text-left">
                        <div class="flex items-center">
                            <!-- Add a hidden field to ensure is_current is always sent, even when unchecked -->
                            <input type="hidden" name="is_current" value="0">
                            <input type="checkbox" name="is_current" id="is_current" value="1"
                                class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300 rounded">
                            <label for="is_current" class="ml-2 block text-sm text-gray-900">Current Position</label>
                        </div>
                    </div>
                    <div class="mb-4 text-left">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="3"
                            class="mt-1 focus:ring-amber-500 focus:border-amber-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                    </div>
                    <div class="flex justify-between mt-5">
                        <button type="button" onclick="toggleModal('workExperienceModal')"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-amber-600 text-white rounded-md">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Certification Modal -->
    <div id="certificationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Add Certification</h3>
                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form class="mt-4" action="{{ route('artisan.profile.certification') }}" method="POST">
                    @csrf
                    <input type="hidden" name="artisan_profile_id"
                        value="{{ isset($artisanProfile) && $artisanProfile ? $artisanProfile->id : '' }}">
                    <div class="mb-4 text-left">
                        <label for="title" class="block text-sm font-medium text-gray-700">Certification Name</label>
                        <input type="text" name="title" id="title" required
                            class="mt-1 focus:ring-amber-500 focus:border-amber-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="mb-4 text-left">
                        <label for="issuing_organization" class="block text-sm font-medium text-gray-700">Issuing
                            Organization</label>
                        <input type="text" name="issuing_organization" id="issuing_organization" required
                            class="mt-1 focus:ring-amber-500 focus:border-amber-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="mb-4 text-left">
                        <label for="expiry_date" class="block text-sm font-medium text-gray-700">Valid Until</label>
                        <input type="date" name="expiry_date" id="expiry_date"
                            class="mt-1 focus:ring-amber-500 focus:border-amber-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="flex justify-between mt-5">
                        <button type="button" onclick="toggleModal('certificationModal')"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-amber-600 text-white rounded-md">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Contact Info Modal -->
    <div id="contactInfoModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Update Contact Information</h3>
                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form class="mt-4" action="{{ route('artisan.profile.contact-info') }}" method="POST">
                    @csrf
                    <div class="mb-4 text-left">
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="text" name="phone" id="phone"
                            value="{{ isset($artisanProfile) && $artisanProfile ? $artisanProfile->phone : '' }}"
                            class="mt-1 focus:ring-amber-500 focus:border-amber-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="mb-4 text-left">
                        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                        <input type="text" name="address" id="address"
                            value="{{ isset($artisanProfile) && $artisanProfile ? $artisanProfile->address : '' }}"
                            class="mt-1 focus:ring-amber-500 focus:border-amber-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="mb-4 text-left">
                        <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                        <input type="text" name="city" id="city"
                            value="{{ isset($artisanProfile) && $artisanProfile ? $artisanProfile->city : '' }}"
                            class="mt-1 focus:ring-amber-500 focus:border-amber-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="mb-4 text-left">
                        <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                        <input type="text" name="country" id="country"
                            value="{{ isset($artisanProfile) && $artisanProfile ? $artisanProfile->country : '' }}"
                            class="mt-1 focus:ring-amber-500 focus:border-amber-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="mb-4 text-left">
                        <label for="postal_code" class="block text-sm font-medium text-gray-700">Postal Code</label>
                        <input type="text" name="postal_code" id="postal_code"
                            value="{{ isset($artisanProfile) && $artisanProfile ? $artisanProfile->postal_code : '' }}"
                            class="mt-1 focus:ring-amber-500 focus:border-amber-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="flex justify-between mt-5">
                        <button type="button" onclick="toggleModal('contactInfoModal')"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-amber-600 text-white rounded-md">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Business Info Modal -->
    <div id="businessInfoModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Update Business Information</h3>
                <form class="mt-4" action="{{ route('artisan.profile.business-info') }}" method="POST">
                    @csrf
                    <div class="mb-4 text-left">
                        <label for="business_name" class="block text-sm font-medium text-gray-700">Business Name</label>
                        <input type="text" name="business_name" id="business_name"
                            value="{{ isset($artisanProfile) && $artisanProfile ? $artisanProfile->business_name : '' }}"
                            class="mt-1 focus:ring-amber-500 focus:border-amber-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="mb-4 text-left">
                        <label for="business_registration_number"
                            class="block text-sm font-medium text-gray-700">Registration Number</label>
                        <input type="text" name="business_registration_number" id="business_registration_number"
                            value="{{ isset($artisanProfile) && $artisanProfile ? $artisanProfile->business_registration_number : '' }}"
                            class="mt-1 focus:ring-amber-500 focus:border-amber-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="mb-4 text-left">
                        <label for="insurance_details" class="block text-sm font-medium text-gray-700">Insurance
                            Details</label>
                        <textarea name="insurance_details" id="insurance_details" rows="3"
                            class="mt-1 focus:ring-amber-500 focus:border-amber-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ isset($artisanProfile) && $artisanProfile ? $artisanProfile->insurance_details : '' }}</textarea>
                    </div>
                    <div class="flex justify-between mt-5">
                        <button type="button" onclick="toggleModal('businessInfoModal')"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-amber-600 text-white rounded-md">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Professional Info Modal -->
    <div id="professionalInfoModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Update Professional Information</h3>

                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="mt-4" action="{{ route('artisan.profile.professional-info') }}" method="POST">
                    @csrf
                    <div class="mb-4 text-left">
                        <label for="profession" class="block text-sm font-medium text-gray-700">Profession</label>
                        <input type="text" name="profession" id="profession"
                            value="{{ isset($artisanProfile) && $artisanProfile ? $artisanProfile->profession ?? '' : '' }}"
                            required
                            class="mt-1 focus:ring-amber-500 focus:border-amber-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="mb-4 text-left">
                        <label for="about_me" class="block text-sm font-medium text-gray-700">About Me</label>
                        <textarea name="about_me" id="about_me" rows="4"
                            class="mt-1 focus:ring-amber-500 focus:border-amber-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ isset($artisanProfile) && $artisanProfile ? $artisanProfile->about_me ?? '' : '' }}</textarea>
                    </div>
                    <div class="mb-4 text-left">
                        <label for="skills" class="block text-sm font-medium text-gray-700">Skills
                            (comma-separated)</label>
                        <input type="text" name="skills" id="skills"
                            value="{{ isset($artisanProfile) && $artisanProfile && isset($artisanProfile->skills) && is_array($artisanProfile->skills) ? implode(', ', $artisanProfile->skills) : '' }}"
                            class="mt-1 focus:ring-amber-500 focus:border-amber-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        <p class="mt-1 text-xs text-gray-500">Example: Woodworking, Restoration, Custom Furniture</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4 text-left">
                            <label for="experience_years" class="block text-sm font-medium text-gray-700">Years of
                                Experience</label>
                            <input type="number" name="experience_years" id="experience_years" min="0"
                                value="{{ isset($artisanProfile) && $artisanProfile ? $artisanProfile->experience_years ?? 0 : 0 }}"
                                class="mt-1 focus:ring-amber-500 focus:border-amber-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div class="mb-4 text-left">
                            <label for="hourly_rate" class="block text-sm font-medium text-gray-700">Hourly Rate
                                (€)</label>
                            <input type="number" name="hourly_rate" id="hourly_rate" min="0" step="0.01"
                                value="{{ isset($artisanProfile) && $artisanProfile ? $artisanProfile->hourly_rate ?? 0 : 0 }}"
                                class="mt-1 focus:ring-amber-500 focus:border-amber-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>
                    <div class="flex justify-between mt-5">
                        <button type="button" onclick="toggleModal('professionalInfoModal')"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-amber-600 text-white rounded-md">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');

                // Reset form if opening the work experience modal
                if (modalId === 'workExperienceModal') {
                    const form = modal.querySelector('form');
                    if (form) {
                        form.reset();

                        // Re-enable end date field (in case it was disabled)
                        const endDateInput = document.getElementById('end_date');
                        if (endDateInput) {
                            endDateInput.disabled = false;
                        }

                        // Log for debugging
                        console.log('Work experience form has been reset');
                    }
                }
            } else {
                modal.classList.add('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const isCurrentCheckbox = document.getElementById('is_current');
            const endDateInput = document.getElementById('end_date');

            if (isCurrentCheckbox && endDateInput) {
                isCurrentCheckbox.addEventListener('change', function() {
                    endDateInput.disabled = this.checked;
                    if (this.checked) {
                        endDateInput.value = '';
                    }
                });
            }

            // Handle form submission for work experience
            const workExpForm = document.querySelector('#workExperienceModal form');
            if (workExpForm) {
                workExpForm.addEventListener('submit', function() {
                    // Add a small delay before hiding the modal to ensure form submission
                    setTimeout(function() {
                        toggleModal('workExperienceModal');
                    }, 100);

                    // Log for debugging
                    console.log('Work experience form submitted');
                });
            }

            // Check for refresh form flag from controller
            const shouldRefreshForm = {{ session('refreshFormData') ? 'true' : 'false' }};
            if (shouldRefreshForm) {
                console.log('Form refresh triggered by controller');
                // Do any additional form reset actions if needed
            }
        });
    </script>
@endsection
