// ...existing code...
public function profile()
{
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login');
    }

    return view('artisan.profile', compact('user'));
}
// ...existing code...
