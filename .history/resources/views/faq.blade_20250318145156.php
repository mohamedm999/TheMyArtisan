@extends('layouts.app')

@section('title', 'Frequently Asked Questions - MyArtisan')
@section('description', 'Find answers to common questions about the MyArtisan platform, including how to book artisans,
    payment methods, and account management.')

@section('content')
    <div class="bg-amber-50 py-12 px-4 sm:px-6 lg:px-8">
        <!-- Hero section -->
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-4xl font-bold text-amber-800 mb-6">Frequently Asked Questions</h1>
            <p class="text-lg text-gray-700 max-w-3xl mx-auto">
                Everything you need to know about MyArtisan and connecting with Moroccan craftspeople
            </p>
        </div>
    </div>

    <div class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-4xl mx-auto">
            <!-- FAQ Categories Tabs -->
            <div x-data="{ activeTab: 'general' }" class="border-b border-gray-200 mb-8">
                <nav class="flex flex-wrap -mb-px">
                    <button @click="activeTab = 'general'"
                        :class="{ 'border-amber-500 text-amber-600': activeTab === 'general', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'general' }"
                        class="py-4 px-1 font-medium text-sm border-b-2 mr-8">
                        General Questions
                    </button>
                    <button @click="activeTab = 'artisans'"
                        :class="{ 'border-amber-500 text-amber-600': activeTab === 'artisans', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'artisans' }"
                        class="py-4 px-1 font-medium text-sm border-b-2 mr-8">
                        For Artisans
                    </button>
                    <button @click="activeTab = 'clients'"
                        :class="{ 'border-amber-500 text-amber-600': activeTab === 'clients', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'clients' }"
                        class="py-4 px-1 font-medium text-sm border-b-2 mr-8">
                        For Clients
                    </button>
                    <button @click="activeTab = 'payment'"
                        :class="{ 'border-amber-500 text-amber-600': activeTab === 'payment', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'payment' }"
                        class="py-4 px-1 font-medium text-sm border-b-2">
                        Payment & Booking
                    </button>
                </nav>
            </div>

            <!-- General Questions -->
            <div x-show="activeTab === 'general'" class="space-y-8">
                <div x-data="{ open: false }" class="border-b border-gray-200 pb-6">
                    <button @click="open = !open" class="flex items-center justify-between w-full text-left">
                        <h3 class="text-lg font-medium text-gray-900">What is MyArtisan?</h3>
                        <span class="ml-6 flex-shrink-0">
                            <i x-show="!open" class="fas fa-plus text-amber-500"></i>
                            <i x-show="open" class="fas fa-minus text-amber-500"></i>
                        </span>
                    </button>
                    <div x-show="open" class="mt-3">
                        <p class="text-gray-600">
                            MyArtisan is a platform that connects skilled Moroccan artisans with clients who appreciate
                            authentic craftsmanship. We provide a marketplace for artisans to showcase their work, manage
                            bookings, and interact with customers. For clients, we offer a curated selection of craftspeople
                            specializing in various traditional Moroccan arts.
                        </p>
                    </div>
                </div>

                <div x-data="{ open: false }" class="border-b border-gray-200 pb-6">
                    <button @click="open = !open" class="flex items-center justify-between w-full text-left">
                        <h3 class="text-lg font-medium text-gray-900">How does MyArtisan work?</h3>
                        <span class="ml-6 flex-shrink-0">
                            <i x-show="!open" class="fas fa-plus text-amber-500"></i>
                            <i x-show="open" class="fas fa-minus text-amber-500"></i>
                        </span>
                    </button>
                    <div x-show="open" class="mt-3">
                        <p class="text-gray-600">
                            Artisans create profiles showcasing their skills, services, and availability. Clients can browse
                            these profiles, view portfolios, read reviews, and book services directly through our platform.
                            Our system handles scheduling, payments, and communications, making the process seamless for
                            both parties.
                        </p>
                    </div>
                </div>

                <div x-data="{ open: false }" class="border-b border-gray-200 pb-6">
                    <button @click="open = !open" class="flex items-center justify-between w-full text-left">
                        <h3 class="text-lg font-medium text-gray-900">Where does MyArtisan operate?</h3>
                        <span class="ml-6 flex-shrink-0">
                            <i x-show="!open" class="fas fa-plus text-amber-500"></i>
                            <i x-show="open" class="fas fa-minus text-amber-500"></i>
                        </span>
                    </button>
                    <div x-show="open" class="mt-3">
                        <p class="text-gray-600">
                            Currently, MyArtisan primarily serves major Moroccan cities including Marrakech, Fez, Rabat,
                            Casablanca, and Tangier. We're continuously expanding to other regions of Morocco to include
                            more traditional crafts and artisans from diverse communities.
                        </p>
                    </div>
                </div>

                <div x-data="{ open: false }" class="border-b border-gray-200 pb-6">
                    <button @click="open = !open" class="flex items-center justify-between w-full text-left">
                        <h3 class="text-lg font-medium text-gray-900">How do I contact customer support?</h3>
                        <span class="ml-6 flex-shrink-0">
                            <i x-show="!open" class="fas fa-plus text-amber-500"></i>
                            <i x-show="open" class="fas fa-minus text-amber-500"></i>
                        </span>
                    </button>
                    <div x-show="open" class="mt-3">
                        <p class="text-gray-600">
                            You can reach our customer support team through several channels:
                        </p>
                        <ul class="list-disc pl-5 mt-2 text-gray-600">
                            <li>Email us at support@myartisan.ma</li>
                            <li>Use the contact form on our <a href="{{ route('contact') }}"
                                    class="text-amber-600 hover:text-amber-500">Contact Us</a> page</li>
                            <li>If you're a registered user, you can also access support through the Help section in your
                                account dashboard</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- For Artisans -->
            <div x-show="activeTab === 'artisans'" class="space-y-8">
                <div x-data="{ open: false }" class="border-b border-gray-200 pb-6">
                    <button @click="open = !open" class="flex items-center justify-between w-full text-left">
                        <h3 class="text-lg font-medium text-gray-900">How do I join as an artisan?</h3>
                        <span class="ml-6 flex-shrink-0">
                            <i x-show="!open" class="fas fa-plus text-amber-500"></i>
                            <i x-show="open" class="fas fa-minus text-amber-500"></i>
                        </span>
                    </button>
                    <div x-show="open" class="mt-3">
                        <p class="text-gray-600">
                            To join MyArtisan as a craftsperson:
                        </p>
                        <ol class="list-decimal pl-5 mt-2 space-y-2 text-gray-600">
                            <li>Register for an account by clicking "Join as Artisan" on our homepage</li>
                            <li>Complete your profile with details about your craft, experience, and portfolio</li>
                            <li>Upload photos of your work and any certifications you may have</li>
                            <li>Set your availability and service offerings</li>
                            <li>Once approved by our team, your profile will be visible to clients</li>
                        </ol>
                    </div>
                </div>

                <div x-data="{ open: false }" class="border-b border-gray-200 pb-6">
                    <button @click="open = !open" class="flex items-center justify-between w-full text-left">
                        <h3 class="text-lg font-medium text-gray-900">What fees does MyArtisan charge artisans?</h3>
                        <span class="ml-6 flex-shrink-0">
                            <i x-show="!open" class="fas fa-plus text-amber-500"></i>
                            <i x-show="open" class="fas fa-minus text-amber-500"></i>
                        </span>
                    </button>
                    <div x-show="open" class="mt-3">
                        <p class="text-gray-600">
                            MyArtisan takes a 15% commission on each successfully completed booking. This fee covers
                            platform maintenance, marketing, payment processing, and customer support. There is no upfront
                            cost or subscription fee to join as an artisan.
                        </p>
                    </div>
                </div>

                <div x-data="{ open: false }" class="border-b border-gray-200 pb-6">
                    <button @click="open = !open" class="flex items-center justify-between w-full text-left">
                        <h3 class="text-lg font-medium text-gray-900">How do I manage my availability?</h3>
                        <span class="ml-6 flex-shrink-0">
                            <i x-show="!open" class="fas fa-plus text-amber-500"></i>
                            <i x-show="open" class="fas fa-minus text-amber-500"></i>
                        </span>
                    </button>
                    <div x-show="open" class="mt-3">
                        <p class="text-gray-600">
                            Once logged in, you can access your calendar through the artisan dashboard. Here you can:
                        </p>
                        <ul class="list-disc pl-5 mt-2 text-gray-600">
                            <li>Set your regular working hours</li>
                            <li>Block off days when you're unavailable</li>
                            <li>View and manage upcoming bookings</li>
                            <li>Set buffer time between appointments if needed</li>
                        </ul>
                    </div>
                </div>

                <div x-data="{ open: false }" class="border-b border-gray-200 pb-6">
                    <button @click="open = !open" class="flex items-center justify-between w-full text-left">
                        <h3 class="text-lg font-medium text-gray-900">When and how do I get paid?</h3>
                        <span class="ml-6 flex-shrink-0">
                            <i x-show="!open" class="fas fa-plus text-amber-500"></i>
                            <i x-show="open" class="fas fa-minus text-amber-500"></i>
                        </span>
                    </button>
                    <div x-show="open" class="mt-3">
                        <p class="text-gray-600">
                            Payments are processed within 48 hours after a service is marked as completed. You'll need to
                            set up your preferred payment method in your account settings. We currently support direct bank
                            deposits, mobile money services, and digital payment platforms available in Morocco.
                        </p>
                    </div>
                </div>
            </div>

            <!-- For Clients -->
            <div x-show="activeTab === 'clients'" class="space-y-8">
                <div x-data="{ open: false }" class="border-b border-gray-200 pb-6">
                    <button @click="open = !open" class="flex items-center justify-between w-full text-left">
                        <h3 class="text-lg font-medium text-gray-900">How do I find and book an artisan?</h3>
                        <span class="ml-6 flex-shrink-0">
                            <i x-show="!open" class="fas fa-plus text-amber-500"></i>
                            <i x-show="open" class="fas fa-minus text-amber-500"></i>
                        </span>
                    </button>
                    <div x-show="open" class="mt-3">
                        <p class="text-gray-600">
                            To find and book an artisan:
                        </p>
                        <ol class="list-decimal pl-5 mt-2 space-y-2 text-gray-600">
                            <li>Browse featured artisans on our homepage or search by craft category, location, or specific
                                skills</li>
                            <li>Review artisan profiles, including their portfolio, reviews, and ratings</li>
                            <li>Select the service you're interested in from their offerings</li>
                            <li>Choose an available date and time from their calendar</li>
                            <li>Complete the booking by providing any necessary details and making payment</li>
                        </ol>
                    </div>
                </div>

                <div x-data="{ open: false }" class="border-b border-gray-200 pb-6">
                    <button @click="open = !open" class="flex items-center justify-between w-full text-left">
                        <h3 class="text-lg font-medium text-gray-900">What if I need to cancel or reschedule?</h3>
                        <span class="ml-6 flex-shrink-0">
                            <i x-show="!open" class="fas fa-plus text-amber-500"></i>
                            <i x-show="open" class="fas fa-minus text-amber-500"></i>
                        </span>
                    </button>
                    <div x-show="open" class="mt-3">
                        <p class="text-gray-600">
                            Our cancellation policy allows for full refunds if you cancel more than 48 hours before the
                            scheduled appointment. For cancellations within 48 hours, a 50% fee may apply. You can
                            reschedule appointments without penalty if done at least 24 hours in advance. To cancel or
                            reschedule, simply go to your bookings section in your client dashboard.
                        </p>
                    </div>
                </div>

                <div x-data="{ open: false }" class="border-b border-gray-200 pb-6">
                    <button @click="open = !open" class="flex items-center justify-between w-full text-left">
                        <h3 class="text-lg font-medium text-gray-900">How do I communicate with an artisan?</h3>
                        <span class="ml-6 flex-shrink-0">
                            <i x-show="!open" class="fas fa-plus text-amber-500"></i>
                            <i x-show="open" class="fas fa-minus text-amber-500"></i>
                        </span>
                    </button>
                    <div x-show="open" class="mt-3">
                        <p class="text-gray-600">
                            Once you've made a booking, you'll have access to a secure messaging system within the platform
                            to communicate with your artisan. This allows you to discuss details, ask questions, or provide
                            additional information prior to your appointment. All communication is kept on the platform for
                            your security and reference.
                        </p>
                    </div>
                </div>

                <div x-data="{ open: false }" class="border-b border-gray-200 pb-6">
                    <button @click="open = !open" class="flex items-center justify-between w-full text-left">
                        <h3 class="text-lg font-medium text-gray-900">Can I request custom work?</h3>
                        <span class="ml-6 flex-shrink-0">
                            <i x-show="!open" class="fas fa-plus text-amber-500"></i>
                            <i x-show="open" class="fas fa-minus text-amber-500"></i>
                        </span>
                    </button>
                    <div x-show="open" class="mt-3">
                        <p class="text-gray-600">
                            Yes, many of our artisans accept custom commissions. You can inquire directly with an artisan by
                            contacting them through their profile page. Discuss your requirements, timeline, and budget, and
                            they can create a custom service listing specifically for your project if they're available to
                            take on the work.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Payment & Booking -->
            <div x-show="activeTab === 'payment'" class="space-y-8">
                <div x-data="{ open: false }" class="border-b border-gray-200 pb-6">
                    <button @click="open = !open" class="flex items-center justify-between w-full text-left">
                        <h3 class="text-lg font-medium text-gray-900">What payment methods are accepted?</h3>
                        <span class="ml-6 flex-shrink-0">
                            <i x-show="!open" class="fas fa-plus text-amber-500"></i>
                            <i x-show="open" class="fas fa-minus text-amber-500"></i>
                        </span>
                    </button>
                    <div x-show="open" class="mt-3">
                        <p class="text-gray-600">
                            MyArtisan accepts the following payment methods:
                        </p>
                        <ul class="list-disc pl-5 mt-2 text-gray-600">
                            <li>Credit and debit cards (Visa, Mastercard)</li>
                            <li>PayPal</li>
                            <li>Mobile payment services popular in Morocco</li>
                            <li>Bank transfers (for certain bookings)</li>
                        </ul>
                        <p class="mt-2 text-gray-600">All transactions are secure and encrypted for your protection.</p>
                    </div>
                </div>

                <div x-data="{ open: false }" class="border-b border-gray-200 pb-6">
                    <button @click="open = !open" class="flex items-center justify-between w-full text-left">
                        <h3 class="text-lg font-medium text-gray-900">Is my payment secure?</h3>
                        <span class="ml-6 flex-shrink-0">
                            <i x-show="!open" class="fas fa-plus text-amber-500"></i>
                            <i x-show="open" class="fas fa-minus text-amber-500"></i>
                        </span>
                    </button>
                    <div x-show="open" class="mt-3">
                        <p class="text-gray-600">
                            Yes, all payments on MyArtisan are processed through secure payment gateways that comply with
                            PCI DSS standards. Your payment information is encrypted and never stored directly on our
                            servers. We use industry-standard security measures to protect all transactions and personal
                            data.
                        </p>
                    </div>
                </div>

                <div x-data="{ open: false }" class="border-b border-gray-200 pb-6">
                    <button @click="open = !open" class="flex items-center justify-between w-full text-left">
                        <h3 class="text-lg font-medium text-gray-900">When am I charged for a booking?</h3>
                        <span class="ml-6 flex-shrink-0">
                            <i x-show="!open" class="fas fa-plus text-amber-500"></i>
                            <i x-show="open" class="fas fa-minus text-amber-500"></i>
                        </span>
                    </button>
                    <div x-show="open" class="mt-3">
                        <p class="text-gray-600">
                            For most services, you'll be charged a deposit (typically 20%) at the time of booking to secure
                            your appointment. The remaining balance is charged 24 hours before your scheduled service. For
                            custom projects or larger commissions, payment terms may vary and will be clearly outlined
                            before you confirm your booking.
                        </p>
                    </div>
                </div>

                <div x-data="{ open: false }" class="border-b border-gray-200 pb-6">
                    <button @click="open = !open" class="flex items-center justify-between w-full text-left">
                        <h3 class="text-lg font-medium text-gray-900">What is your refund policy?</h3>
                        <span class="ml-6 flex-shrink-0">
                            <i x-show="!open" class="fas fa-plus text-amber-500"></i>
                            <i x-show="open" class="fas fa-minus text-amber-500"></i>
                        </span>
                    </button>
                    <div x-show="open" class="mt-3">
                        <p class="text-gray-600">
                            Our refund policy is as follows:
                        </p>
                        <ul class="list-disc pl-5 mt-2 text-gray-600">
                            <li>Full refund if cancelled more than 48 hours before the appointment</li>
                            <li>50% refund if cancelled between 24-48 hours before the appointment</li>
                            <li>No refund for cancellations less than 24 hours before the appointment</li>
                            <li>Full refund if the artisan cancels for any reason</li>
                            <li>In case of service quality issues, our customer support team will review refund requests on
                                a case-by-case basis</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Section -->
        <div class="mt-16 bg-amber-50 rounded-lg p-8 max-w-4xl mx-auto">
            <h3 class="text-xl font-semibold text-amber-800 mb-4">Still have questions?</h3>
            <p class="text-gray-600 mb-6">
                If you couldn't find the answer to your question, please don't hesitate to reach out to our support team.
            </p>
            <a href="{{ route('contact') }}"
                class="inline-flex items-center px-5 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-amber-600 hover:bg-amber-700">
                Contact Us
            </a>
        </div>
    </div>
@endsection
