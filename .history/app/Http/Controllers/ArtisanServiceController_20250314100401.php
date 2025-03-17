// ...existing code...

// Make sure your store/update method uses this approach for images
if ($request->hasFile('image')) {
    $path = $request->file('image')->store('services', 'public');
    $service->image = $path; // This should store path as "services/filename.jpg"
}

// ...existing code...
