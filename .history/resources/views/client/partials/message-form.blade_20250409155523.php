<div class="mt-4">
    <form action="{{ route('messages.start') }}" method="POST" class="flex flex-col space-y-3">
        @csrf
        <input type="hidden" name="artisan_id" value="{{ $artisan->id }}">
        <div>
            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Send a message</label>
            <textarea name="message" id="message" rows="3" placeholder="Write your message here..."
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50"
                required></textarea>
        </div>
        <div>
            <button type="submit"
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                <i class="fas fa-paper-plane mr-2"></i>
                Send Message
            </button>
        </div>
    </form>
</div>
