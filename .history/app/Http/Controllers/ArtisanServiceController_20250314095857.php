// ...existing code...

// In your store or update method:
if ($request->hasFile('image')) {
    // Make sure it's storing with a path relative to storage/app/public
    $path = $request->file('image')->store('services', 'public');
    $service->image = $path; // This should store "services/filename.jpg"
}

// ...existing code...
